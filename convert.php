<?php
/**
 * Created by PhpStorm.
 * User: Kyronbao
 * Date: 20-1-20
 * Time: 下午2:07
 */


$dir = './';
$filenames = [];


if ($handle = opendir($dir)) {
    while (false !== ($filename = readdir($handle))) {
        $filename_old = $filename;

        $arr_filename = explode('.', $filename);
        if (is_dir($filename)) {
            continue;
        }
        if (count($arr_filename)<2) {
            throw new \Exception($filename."文件名没有后缀");
        }

        $ext = end($arr_filename);
        if ($ext == 'txt') {

            $file = substr($filename, 0, strlen($filename)-4);
            $file = str_replace(' ', '-', $file);
            $file = str_replace('、', '-', $file);
            $filename = strtolower($file.'.'.'md');
            $filenames[$filename_old] = $filename;
        }
    }
    closedir($handle);
}


asort($filenames);
$foreach_times = 0;
foreach($filenames as $filename_old=>$filename) {
//    rename($dir.$filename_old, $dir.$filename);
    $lines = file($dir.$filename_old);

    $commands = [
        'apt',
        'apt-get',
        'composer',
        'composer.phar',
        'cp',
        'cd',
        'cat',
        'chown',
        'chmod',
        'docker',
        'docker-compose',
        'export',
        'echo',
        'git',
        'grep',
        'less',
        'sudo',
        'su',
        'ls',
        'mkdir',
        'makepkg',
        'mv',
        'php',
        'ps',
        'systemctl',
        'ssh',
        'scp',
        'source',
        'touch',
        'tar',
        'useradd',
        'usermod',
        'vim',
        'vi',
        'nano',
        'wget',
        '&&',

    ];


    $lines_new = [];
    $line_flag = [];
    $i = 0;


    $code['min'] = $code['max'] = [];
    foreach($lines as $key=>&$line) {
        $words = explode(' ', $line);
        $is_command = in_array($words[0], $commands);
        if ($is_command) {
            $line_flag[$key] = 'code';
        } else {
            $line_flag[$key] = 'normal';
        }

        if (substr($line, 0, 3) == '** ') {
            $line = str_replace('** ', '## ', $line);
            $line_flag[$key] = 'head';
        } elseif (substr($line, 0, 4) == '*** ') {
            $line = str_replace('*** ', '### ', $line);
            $line_flag[$key] = 'head';
        } elseif (substr($line, 0, 5) == '**** ') {
            $line = str_replace('**** ', '#### ', $line);
            $line_flag[$key] = 'head';
        } elseif (substr($line, 0, 2) == ': ') {
            $line_flag[$key] = 'code';
            $line = substr($line,2);
        } elseif (substr($line, 0, 2) == '$ ') {
            $line_flag[$key] = 'code';
            $line = substr($line,2);
        } elseif (preg_match('/^\ *\-.*/', $line)) {
            $line_flag[$key] = 'ref';
        } elseif (preg_match('/\#\+BEGIN_.*/', $line)) {
            $line = '```';
            $line_flag[$key] = 'code_begin';
            $code['min'][] = $key;
        } elseif (preg_match('/\#\+END_.*/', $line)) {
            $line = '```';
            $line_flag[$key] = 'code_end';
            $code['max'][] = $key;
        }

        // 转换链接
        if (preg_match('/(.*)\[\[(.+)\]\[(.+)\]\](.*)/', $line, $match)) {
            $line = $match[1].'['.$match[3].']('.$match[2].')'.$match[4];
        }
    }

    // foreach顺序不能移动
    // 上面code的会被覆盖为code_begin_end
    foreach($lines as $key=>&$line) {
        foreach($code['min'] as $k=>$v) {
            if ($key > $code['min'][$k] && $key < $code['max'][$k]) {
                $line_flag[$key] = 'code_begin_end';
            }
        }
    }


    // 直接连接（$line=$line.'  '）会把空格添加到一行的前面
    // 经测试，如下方法可以生效
    foreach($lines as &$line) {
        $line = rtrim($line);
        $line = $line.PHP_EOL;
    }

    foreach($lines as $key=>&$line) {
        if ($line_flag[$key] == 'normal') {
            $line = rtrim($line);
            $line = $line.'  '.PHP_EOL;
        }
    }


    $arr_2_change_codes = [];
    $arr_2_change_code_times = 0;
    $arr_2_change_code_keys_begin = [];
    $arr_2_change_code_keys_end = [];
    foreach($lines as $key=>$line) {
        $arr_2_change_code_times++;
        array_push($arr_2_change_codes, $line_flag[$key]);

        if ($arr_2_change_code_times > 1) {
            if ($arr_2_change_codes[0]!=='code' && $arr_2_change_codes[1]=='code') {
                $arr_2_change_code_keys_begin[] = $key;

            } elseif ($arr_2_change_codes[0]=='code' && $arr_2_change_codes[1]!=='code') {
                $arr_2_change_code_keys_end[] = $key;
            }
            array_shift($arr_2_change_codes);
        }
    }




    foreach ($lines as $key=>$val) {
        echo $key.'--->'.$line_flag[$key]."\n";
    }

    $old_line = '';
    foreach($lines as $key=>$line) {
        if (in_array($key, $arr_2_change_code_keys_begin)) {
            array_push($lines_new, $old_line);
            array_push($lines_new, "```\n");
        } elseif (in_array($key, $arr_2_change_code_keys_end)) {
            array_push($lines_new, $old_line);
            array_push($lines_new, "```\n");
        } else {
            array_push($lines_new, $old_line);
        }

        $old_line = $line;
    }


    file_put_contents($dir.$filename, $lines_new);
    unlink($dir.$filename_old);
    $foreach_times++;

    echo $filename_old.'---->'.$filename."\n";

}