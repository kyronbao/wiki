## awesome

-书籍
- [《深入理解PHP内核》](http://www.php-internals.com/)
- http://www.cunmou.com/phpbook/preface.md 《PHP扩展开发及内核应用》
  
最佳实践  
- https://www.kancloud.cn/itsky71/php-standard/150 PHP开发规范
- [Laravel 的十八个最佳实践](https://laravel-china.org/articles/12762/eighteen-best-practices-of-laravel)
- https://laravel-china.github.io/php-the-right-way/
- https://www.phptherightway.com/
  
- https://www.bo56.com/php7%E6%89%A9%E5%B1%95/ PHP7扩展开发
- https://laravel-china.org/topics/17232 网友整理
- https://github.com/ziadoz/awesome-php
- [PHP并发IO编程之路](http://rango.swoole.com/archives/508)

SAPI，特意去查了一下，它是 Server Application Programming Interface
- https://www.php.cn/php-weizijiaocheng-410435.html

缓存  
- [Opcode是啥以及如何使用好Opcache](https://www.zybuluo.com/phper/note/1016714)
  
异步 进程间通信  
- [PHP进程通信](https://segmentfault.com/a/1190000009967836)
- [PHP进程间通信IPC-消息队列的使用](http://rango.swoole.com/archives/103)
- [[https://www.jianshu.com/p/3f8a43b22dd8][PHP异步的的玩法-新的玩法]]  [介绍了基于消息队列、共享内存与信号量的例子](http://blog.it2048.cn/article_php-thread.html)
- [[http://www.laruence.com/2008/04/14/318.html][PHP实现异步调用方法研究]]-鸟哥版  [[https://blog.csdn.net/intersting/article/details/52612794][详细版1]] [详细版2](https://blog.csdn.net/openn/article/details/8212847)
- [swoole提供的实现方法](https://segmentfault.com/a/1190000009115087)
- [利用swoole_process和eventloop实现php异步编程](https://segmentfault.com/a/1190000008034626)
  
 流  
- [php发送与接收流文件](http://www.qipajun.com/php/379.html)
- http://php.net/manual/zh/intro.stream.php
- http://laravelacademy.org/post/7459.html
- [PHP回顾之流](https://juejin.im/post/5b0ae110f265da0dd71697da)
- [为什么阿里会选择 Flink 作为新一代流式计算引擎？](https://juejin.im/post/59dc836e6fb9a0451f2fe68b)
- [PHP 共享内存使用场景及注意点](https://mp.weixin.qq.com/s?__biz=MzIyNzUwMjM2MA==&mid=2247483997&idx=1&sn=dc26caff6e704a81e5e7be3fe9a8e7c2&chksm=e861722adf16fb3c45f7f39587aaab37ec06dd9744c217175d0e9b45e006b312acb2ea786020&scene=0#wechat_redirect)
  
- 面向对象
  - https://designpatternsphp.readthedocs.io/en/latest/
  
 关于PHP  
- [为什么大多数互联网公司自己写 PHP 框架？](https://www.zhihu.com/question/19793142)
  
- 模板引擎
  - [PHP 模板引擎有多大意义？](https://www.zhihu.com/question/19674848)
  - [PHP－关于模板的原理和解析](https://blog.csdn.net/qq_23488347/article/details/51120533)
- [php怎样和c语言混合编程？](https://www.zhihu.com/question/51845513)
- [用C/C++扩展你的PHP](http://www.laruence.com/2009/04/28/719.html)
- [PHP中的无限级分类、无限嵌套评论](https://juejin.im/post/5b3e1fa55188251b134e54aa)
  
工具  
- phpstorm-for-php-framework
  
PHP7和各版本  
- http://php.net/ChangeLog-7.php
  - PHP7.2.0发布于30 Nov 2017
- http://www.php7.site/book/php7/error-changes-28.html
  
- https://www.csdn.net/article/2015-09-16/2825720 PHP7革新与性能优化，鸟哥PPT整理
- http://php.net/manual/zh/migration70.new-features.php
- [PHP5.5 ~ PHP7.2 新特性整理](https://blog.csdn.net/qq_16885135/article/details/79755713)
  
- https://juejin.im/post/5b2f855e6fb9a00e5e427715 PHP回顾之多进程编程
- https://segmentfault.com/a/1190000003893899
- https://juejin.im/entry/5b31aa1bf265da597f1c81c0 strace帮助你调试PHP代码
  
 PHP性能分析  
- [使用XHProf查找PHP性能瓶颈](https://segmentfault.com/a/1190000003509917)
- https://github.com/eryx/php-framework-benchmark  PHP框架性能测试工具
  
异常  
- https://blog.csdn.net/kikajack/article/details/81318552
- [PHP 中 Error 与 Exception 的区别，及如何捕获](https://www.sunzhongwei.com/difference-between-the-error-and-the-exception-in-php-and-how-to-catch)
- [PHP 7 的异常和错误处理](http://blog.p2hp.com/archives/4211)
  
  
- swoole -----------------------------------------------------------------------------
  
 文档和论坛  
- https://wiki.swoole.com/
- http://rango.swoole.com/
- https://segmentfault.com/blog/swoole
- [并发的API接口选用什么PHP框架合适？](https://segmentfault.com/q/1010000003882388) https://github.com/bixuehujin/blink 一个基于swoole的框架
- [Yii/Yaf/Swoole3个框架的压测性能对比](http://rango.swoole.com/archives/254)
框架  
- https://segmentfault.com/a/1190000014899296 使用 Swoole 来加速你的 Laravel 应用
- [Swoole 在 Swoft 中的应用](https://segmentfault.com/a/1190000013153231)
- https://github.com/swoole
- https://github.com/swoole/swoole-src
入门  
- http://www.codingke.com/course/257 Swoole课程初探 视频
- https://segmentfault.com/a/1190000006140097 Swoole 入门教程 —— 2小时入门Swoole
- https://segmentfault.com/a/1190000003057118 五分钟教你写超简单的swoole聊天室
 资源推荐  
- https://segmentfault.com/a/1190000012975028 聊聊 2018 年后端技术趋势-韩天峰
- https://www.transfon.com/products/swoole-compiler php加密加速
 基础知识  
- https://tech.youzan.com/yi-bu-wang-luo-mo-xing/ 异步网络模型
  
对比  
- https://www.zhihu.com/question/19653241/answer/15993549 swoole nodejs对比
- https://www.v2ex.com/t/332071 Swoole 终将一统高性能 php 场景  [hhxsv5/laravel-s](https://github.com/hhxsv5/laravel-s)
- https://wiki.swoole.com/wiki/page/356.html swoole与golang相比有哪些优势
- https://segmentfault.com/q/1010000007046499 workerman 和 swoole哪个稳定，不谈性能... 提到1.8.x稳定
- https://wiki.swoole.com/wiki/main/63 Nginx/Golang/Swoole/Node.js的性能对比
- [PHP7+Swoole、Node Express、Sails、Beego、ThinkPHP 并发性能测试](https://blog.csdn.net/yue7603835/article/details/53441526)
- http://rango.swoole.com/archives/185 Swoole压测：如何做到并发10万TCP连接
- https://www.cnblogs.com/dormscript/p/8855137.html 使用Swoole测试MySQL在特定SQL下的并发性能
消息队列  
- [woole来实现实时异步任务队列](http://hudeyong926.iteye.com/blog/2285903)
- [如何实现从 Redis 中订阅消息转发到 WebSocket 客户端](https://segmentfault.com/a/1190000010986855)
  
- Yaf --------------------------------------------------------------------------------
  
 http://www.php.net/manual/zh/book.yaf.php 最新文档  
- [Yaf中文文档](http://yaf.laruence.com/manual/), 不过中文文档目前主要针对的是2.1.9版本.
- [又一份Yaf文档——写给正在迷惑的你](http://lovelock.coding.me/php/Yaf-yet-another-manual-for-human/) 关于Nginx配置的正确版本
- [关于Yaf的一些说明-鸟哥](http://www.laruence.com/2012/08/31/2742.html)
- [Yaf的性能](http://www.laruence.com/manual/yaf.bench.html)
- [Yaf的一些资源](http://www.laruence.com/2012/07/06/2649.html)
- http://www.laruence.com/tag/yaf
  
- [yaf 路由协议配置测试](https://blog.csdn.net/zefang94/article/details/46369583)
  
资源  
- https://github.com/slayerhover/api yaf&lumen精简接口示例
  
  
-- laravel ---------------------------------------------------------------------------
全文搜索 scout  
- https://segmentfault.com/a/1190000014230010 Elasticsearch
- https://laravelacademy.org/post/9485.html 讯搜
后台搭建  
- [[https://github.com/jwwb681232/laravel-multi-auth-admin][laravel5.2 RBAC权限管理后台，color admin模板，前后台登录认证]]  前端模板[color-admin模板](https://github.com/pokerdragon/color-admin)
- http://dt54.yajrabox.com/eloquent/has-one 对Datables在Laravel实现了很多封装
  - Eloquent
  - Html Builder
- https://github.com/spatie/laravel-permission
  
加密  
- [RSA加密算法详解以及RSA在laravel中的应用](https://blog.csdn.net/LJFPHP/article/details/78566133)
- [客户端通信如何加密并且防抓包？](https://www.zhihu.com/question/65383073)
- [简单理解rsa的加密和签名-PHP实现](https://segmentfault.com/a/1190000005935157)
- http://penghui.link/articles/2016/08/php_rsa.html
用户授权  
- https://github.com/spatie/laravel-permission#using-blade-directives
- [介绍 Laravel 授权方式 Gate 和 Policy](https://laravel-china.org/articles/5479/the-introduction-of-laravel-authorization-methods-gate-and-policy)
- [讲讲我对 Laravel Policy 的认识](https://laravel-china.org/topics/3420/talk-about-my-understanding-of-laravel-policy)
RBAC实现  
- [使用Laravel5.1自带权限控制系统 ACL](https://9iphp.com/web/laravel/laravel-5-acl-define.html)
容器  
- http://blog.mallow-tech.com/2016/06/request-life-cycle-of-laravel/
- [深度挖掘 Laravel 生命周期](https://laravel-china.org/articles/10421/depth-mining-of-laravel-life-cycle)
- 深入剖析 Laravel 服务容器 http://blog.phpzendo.com/?p=353
包开发  
- https://learnku.com/courses/creating-package overtrue的教程
- http://laravelacademy.org/post/1219.html 如何在Laravel 5.1中进行自定义包开发
- http://laravelacademy.org/post/216.html 5.1包开发文档
- https://blog.csdn.net/m0sh1/article/details/79257935 laravel composer 扩展包开发（超详细）
全局作用域  
- https://laravel-china.org/articles/3819/learn-the-advanced-part-of-laravel-eloquentorm-with-me
宏 macro  
- [如何利用 macro 方法来扩展 Laravel 的基础类的功能](https://laravel-china.org/topics/2915/how-to-use-the-macro-method-to-extend-the-function-of-the-base-class-of-laravel)
- https://scotch.io/tutorials/understanding-and-using-laravel-eloquent-macros
- http://www.shiguopeng.cn/archives/317
博客项目  

## json数据比对方法
开发时有时有些大json数据要比较或者查看
有效的方法是
先把json保存到编辑器，
然后把json保存到1.json这样的文件，再移到浏览器查看
## z正则替换字符串中第几个值
```
$subject = "SELECT uid FROM users WHERE uid = ? or username = ?";

function str_replace_nth($search, $replace, $subject, $nth)
{
    $found = preg_match_all('/'.preg_quote($search).'/', $subject, $matches, PREG_OFFSET_CAPTURE);
    if (false !== $found && $found > $nth) {
        return substr_replace($subject, $replace, $matches[0][$nth][1], strlen($search));
    }
    return $subject;
}


echo str_replace_nth('?', 'username', $subject, 1);
```
https://stackoverflow.com/questions/19907155/how-to-replace-a-nth-occurrence-in-a-string
## 组件 "tucker-eric/eloquentfilter": "^2.4"　搜索模型和关联模型的所有字段
使用示例：在产品目录库中搜索坯布，色布里面的各种字段
## excel合并列样例（三维数组，四维数组）

### 二维数组


        if(!empty($datas)) {
		
            $hz=rand_name();
            $excel_name = "KnitFactoryMachineInfo".'_'.date('Ymd').'_'.$hz.'.xlsx';

            $file_obj=\Excel::create($excel_name, function ($excel) use ($datas) {
                $excel->sheet('order', function ($sheet) use ($datas) {

                    $sheet->cell('A:N', function ($cell) {
                        $cell->setAlignment('center');//水平居中
                        $cell->setValignment('center');//垂直对齐
                        $cell->setFont(['family' => 'Calibri', 'size' => '13']);
                    });

                    $sheet->cell('A1:N1', function ($cells) {
                        $cells->setAlignment('center');//水平居中
                        $cells->setValignment('center');//垂直对齐
                        $cells->setBackground('#45818e');//背景色
                        $cells->setFont(['family' => 'Calibri', 'size' => '13']);
                    });

                    $sheet->setWidth(['A' => 18, 'B' => 18, 'C' => 18, 'D' => 18, 'E' => 12, 'F' => 22, 'G' => 18, 'H' => 18, 'I' => 18,'J' => 18, 'K' => 12,'L' => 12,'M' => 12,'N' => 12]);
                    $sheet->appendRow(['织厂名称','联系方式','联系地址',  '织外勤',  '用户类型',   '织机编号','织机种类',  '品牌',     '织机状态', '当前所织布类','寸数','针数','总针数','路数']);

                    $j = 1;
                    foreach($datas as $data) {
                        $j++;
                        if (!empty($data['details'])) {
                            foreach ($data['details'] as $key => $value) {

                                if ($value['is_import']) {
                                    $loom_name = empty($value['import_loom_name']) ? ' ' : $value['import_loom_name'];
                                    $fabrication = empty($value['import_fabrication']) ? ' ' : $value['import_fabrication'];
                                    $diameter = empty($value['import_diameter']) ? ' ' : $value['import_diameter'];
                                    $gauge = empty($value['import_gauge']) ? ' ' : $value['import_gauge'];
                                } else {
                                    $loom_name = empty($value['loom']) ? ' ' : $value['loom']['loom_name'];
                                    $fabrication = empty($value['fabrication']) ? ' ' : $value['fabrication']['name'];
                                    $diameter = empty($value['diameter']) ? ' ' : $value['diameter']['name'];
                                    $gauge = empty($value['gauge']) ? ' ' : $value['gauge']['name'];
                                }

                                $sheet->appendRow([
                                    $data['knit_factory']['name'] ?? '',//织厂名称
                                    $data['contact_info'] ?? '',//联系方式
                                    $data['address'] ?? '',//联系地址
                                    $data['knit_out']['name'] ?? '',//织外勤
                                    CompanyAccount::USER_TYPE[$data['knit_factory']['user_type']] ?? '',//用户类型
                                    $value['code'] ?? '',//织机编号
                                    $loom_name,//织机种类
                                    $value['brand'] ?? '',//品牌
                                    KnitLoomDetails::LOOM_STATUS[$value['loom_status']] ?? '',//织机状态
                                    $fabrication,//当前所织布类
                                    $diameter,//寸数
                                    $gauge,//针数
                                    $value['needle'] ?? '',//总针数
                                    $value['road_number'] ?? '',//路数
                                ]);
                            }

                            if (count($data['details']) == 0) {
                                $end = $j+count($data['details']);
                            } else {
                                $end = $j+count($data['details'])-1;
                            }
                            $sheet->mergeCells('A'.$j.':A'.$end);
                            $sheet->mergeCells('B'.$j.':B'.$end);
                            $sheet->mergeCells('C'.$j.':C'.$end);
                            $sheet->mergeCells('D'.$j.':D'.$end);
                            $sheet->mergeCells('E'.$j.':E'.$end);

                            $j = $end;
                        }
                        else {
                            $sheet->appendRow([
                                $data['knit_factory']['name'] ?? '',
                                $data['contact_info'] ?? '',
                                $data['address'] ?? '',//联系地址
                                $data['knit_out']['name'] ?? '',
                                CompanyAccount::USER_TYPE[$data['knit_factory']['user_type']] ?? '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                            ]);
                        }

                    }
                });
            })->string('xlsx');

            (new AsyncTaskService())->update([
                'task_id' => $task_id,
                'file_name' => $excel_name,
                'file_obj' => $file_obj,
                'remark'   => '织机信息导出',
            ]);

        }

### 四维数组
    public function test()
    {
        $arr = [
            ['bb'=>1,'cc'=>2,'dd'=>[
                ['ee'=>3,'ff'=>[
                    ['gg'=>11,],
                    ['gg'=>22,],
                ]],
                ['ee'=>32,'ff'=>[
                    ['gg'=>11,],
                    ['gg'=>22,],
                    ['gg'=>33,],
                ]],
                ['ee'=>33,'ff'=>[]],
                ['ee'=>34,'ff'=>[]],
            ]],
            ['bb'=>11,'cc'=>22,'dd'=> []],
            ['bb'=>111,'cc'=>222,'dd'=>[
                ['ee'=>333,'ff'=>[]],
                ['ee'=>333,'ff'=>[
                    ['gg'=>11,],
                    ['gg'=>22,],
                ]],
            ]],
        ];
//        return $arr;

        $j = 0;
        $i = 0;
        foreach($arr as $key => $val) {
            $j++;
            $m = 0;
            if (!empty($val['dd'])) {
                foreach($val['dd'] as $k=>$v) {

                    $i++;
                    if (!empty($v['ff'])) {
                        foreach($v['ff'] as $kk=>$vv) {
                            $m++;
                        }
                    } else {
                        $m++;
                    }
                    if (count($v['ff']) == 0) {
                        $end2 = $i;
                    } else {
                        $end2 = $i+count($v['ff'])-1;
                    }
//                    \Log::error($i);
//                    \Log::error($end2);
//                    \Log::error('2222222222');
                    $i = $end2;
                }
            } else {
                $i++;
                $end2 = $i;
//                \Log::error($i);
//                \Log::error($end2);
//                \Log::error('2222222222');
            }


            if (count($val['dd']) == 0) {
                $end = $j;
            } else {
                $end = $j+$m-1;
            }
            \Log::error($j);
            \Log::error($end);
            \Log::error('1111111111');
            $j = $end;
        }

        echo 'test';
    }
## 列表搜索优化例子
```
Trait CommonSearcher
{
    /**
    // 参数示例
    public $searchParams = [
        'code' => 'like',
        'bdYarnCountId' => '=',//key为数据库字段驼峰格式, value可以为'=', '>', '<', '>=', '<=', 'like'
        'createdTime' => [
            //type 必填，标识区间类型,参数: either|both，either表示前端可传区间的一个参数即可搜索，both表示前端需要传两个参数才生效
            'type' => 'either',
            'params' => [
                //createdBegin 为搜索字段的前端传值
                'createdBegin' =>'>=',
                'createdEnd' =>'<=',
            ],
        ],
    ];
    */

    /**
     * 驼峰转化大写
     *
     * @param $key
     * @return string
     */
    public function snakeUpper($key)
    {
        $key = Str::snake($key);
        return Str::upper($key);
    }


    /**
     * 普通的键值对搜索
     *
     * @param $params
     */
    public function searchNormal($params)
    {

        $data = array_filter($this->searchParams, function ($v,$k) {
            if (in_array($v, ['=', '>', '<', '>=', '<=', 'like'])) {
                return true;
            }
        }, ARRAY_FILTER_USE_BOTH);
        foreach ($data as $paramName => $operator) {
            if(isset($params[$paramName]) && $params[$paramName] != '') {
                $upperName = $this->snakeUpper($paramName);
                $value = $operator !== 'like' ? $params[$paramName] : '%'.$params[$paramName].'%';
                $this->query = $this->query->where($upperName, $operator, $value);
            }
        }
    }


    /**
     * 区间字段的搜索
     *
     * @param $params
     */
    public function searchInterval($params)
    {
        $data = array_filter($this->searchParams, function ($v,$k) {
            if(isset($v['type']) && in_array($v['type'],['both','either'])) {
                return true;
            }
        }, ARRAY_FILTER_USE_BOTH);
        foreach($data as $key => $item) {
            $key = $this->snakeUpper($key);
            switch ($item['type']) {
                case 'either':
                    foreach($item['params'] as $paramName => $operator) {
                        if (isset($params[$paramName])) {
                            $this->query = $this->query->where($key, $operator, $params[$paramName]);
                        }
                    }
                    break;

                case 'both':
                    $paramNames = array_keys($item['paramStrings']);
                    if (isset($params[$paramNames[0]]) && isset($params[$paramNames[1]])) {
                        foreach($params['params'] as $paramName => $operator) {
                            $this->query = $this->query->where($key, $operator, $params[$paramName]);
                        }
                    }
                    break;
            }
        }
    }
}
```
## "guzzlehttp/guzzle": "^6.3" 访问外部接口例子
```
        $client = new Client();
        $response = $client->request('POST', 'http://8.129.112.123/color/', [
            // php数组转json
			'body' => json_encode($params),
        ]);

        $content =  $response->getBody()->getContents();
		// 坑，(返回数据用postman可以查看，但是)无法直接用json_decode()转化，需要移除空格
        $content = trim($content,'﻿');
        $content = json_decode($content, true);
        $content = $content['data'] ?? [];
```

## "spatie/laravel-fractal": "^5.3",  json数据返回格式转化transform  
## "tymon/jwt-auth": "1.0.0-rc.1"     laravel5.5 jwt版本  
  

## php二进制例子
        $a = -1;
		// 打印8位二进制格式的
        echo $aa = sprintf('%08b', $a); 
        echo "\n";
        echo strlen($aa);
        echo "\n";
        $b = 1;
        echo $bb = sprintf('%08b', $b);
        echo "\n";
        echo strlen($bb);
        echo "\n";
        $num = 5;
        $location = 'tree';
## PHP使用preg_split函数分割含换行和分号字符串
$result = preg_split('/[;\r\n]+/s', $value);   // 返回数据保存在$result数组中  
## 二位数组的排序
### 按多维数组的嵌套值排序
        $arr = [
            ['aa'=>11, 'bb'=>['cc'=>11,'dd'=>2]],
            ['aa'=>33, 'bb'=>['cc'=>33,'dd'=>1]],
            ['aa'=>22, 'bb'=>['cc'=>22,'dd'=>3]],
        ];
		https://stackoverflow.com/questions/22247844/array-multisort-array-sizes-are-inconsistent

        foreach($arr as $key=>$val) {
            $new[$key] = $val['bb']['dd'];
        }

        array_multisort($new,SORT_DESC, $arr);
        return $arr;

### 如果按两个字段排序，可以这样

        array_multisort(array_column($params, 'seq'),SORT_ASC,
            array_column($params,'bdDyestuffAssistName'), SORT_STRING,
            $params
        );
		
### 如果三个字段排序，其中一个字段按规定排序

        $colorMap = [
            1	=> "紫色",
            2	=> "玫红",
            3	=> "红色",
            4	=> "橙色",
            5	=> "红黄",
            6	=> "青黄",
            7	=> "湖绿",
            8	=> "蓝色",
            9	=> "艳兰",
            10 => "黑色",
            11 => "白色",
            12 => "",
        ];

        foreach($params as &$item) {
            $item['bdDyestuffAssistColorIndex'] = array_search($item['bdDyestuffAssistColor'], $colorMap);
        }

        array_multisort(array_column($params, 'seq'),SORT_ASC,
            array_column($params,'bdDyestuffAssistColorIndex'), SORT_ASC,
            array_column($params,'bdDyestuffAssistName'), SORT_STRING,
            $params
        );

## 对象和数组转化

Converting an array -> stdClass  
$stdClass = (object) $array;  
$stdClass = json_decode(json_encode($booking));  
  
Converting an array/stdClass -> array  
$array = json_decode(json_encode($booking), true);  
stdClass -> array  一维  
$array = (array)$stdClass;  
## 前段传值isPage为0时怎么验证？
        if (isset($params['isPage']) && in_array($params['isPage'],['1','0'])) {
            $query = $query->where('isPage',(int)$params['isPage']);
        }
## phps树型结构(可分页和不可分页)jquery表现  
### 可分页版
从数组看依次取出10条id,在根据id取出相应的父节点数据，最后过滤10条里的重复数组  
#+ATTR_HTML: :textarea t :height 200  
```
private function createTree($array, $pid = 0)
{
    $ret = array();

    foreach($array as $key => $value){
        if($value['pid'] == $pid){
            $tmp = $value;
            unset($array[$key]);
            $tmp['list'] = $this->createTree($array, $value['id']);
            $ret[] = $tmp;
        }
    }

    return $ret;
}

private function array_multiToSingle($array,$clearRepeated=false)
{
    if(!isset($array)||!is_array($array)||empty($array)){
        return false;
    }
    if(!in_array($clearRepeated,array('true','false',''))){
        return false;
    }
    static $result_array=array();
    foreach($array as $value){
        if(is_array($value)){
            $this->array_multiToSingle($value);
        }else{
            $result_array[]=$value;
        }
    }
    if($clearRepeated){
        $result_array=array_unique($result_array);
    }
    return $result_array;
}


private function array_SingleTo2($array)
{
    static $result_array=array();
    $len = count($array)/10;
    for($i=0;$i<$len;$i++){
        $result_array[$i]['level'] = array_shift($array);
        $result_array[$i]['id'] = array_shift($array);
        $result_array[$i]['pid'] =array_shift($array);
        $result_array[$i]['name'] = array_shift($array);
        $result_array[$i]['user'] = array_shift($array);
        $result_array[$i]['auth'] = array_shift($array);
        $result_array[$i]['updated'] = array_shift($array);
        $result_array[$i]['title'] = array_shift($array);
        $result_array[$i]['user_id'] = array_shift($array);
        $result_array[$i]['comments_id'] = array_shift($array);
    }

    return $result_array;
}

private function array_addLevel($arr)
{

    foreach($arr as $key=>$val){

        array_unshift($arr[$key],0);

        if(isset($val['list']) && is_array($val['list']) && !empty($val['list'])){
            foreach($val['list'] as $k=>$v){
                array_unshift($arr[$key]['list'][$k],1);

                //
                if(isset($v['list']) && is_array($v['list']) && !empty($v['list'])){
                    foreach($v['list'] as $kk=>$vv){
                        array_unshift($arr[$key]['list'][$k]['list'][$kk],2);
                    }
                }
                //
            }
        }

    }

    return $arr;
}

function array_unique_2d($array2D){
    $temp = $res = array();
    foreach ($array2D as $v){
        $v = json_encode($v);  //降维,将一维数组转换字符串
        $temp[] = $v;
    }
    $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
    foreach ($temp as $item){
        $res[] = json_decode($item,true);   //再将拆开的数组重新组装
    }
    return $res;
}

/**
 * 管理端AJAX数组
 * @param Request $request
 * @param String 'comments_resource'
 * @return mixed
 */
public function listResourceIndex(Request $request)
{
    $draw = $request->input('draw', 1);
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);
    $auth = intval($request->input('auth', 0));
    $order['name'] = $request->input('columns.' . $request->input('order.0.column').'.name');
    $order['dir'] = $request->input('order.0.dir', 'asc');
    $search['value'] = $request->input('search.value', '');
    $search['regex'] = $request->input('search.regex', false);

	//$model = DB::table('comments_resource as cr');
	//
	//if ($search['value']) {
	//    if ($search['regex'] == 'true') {//传过来的是字符串不能用bool值比较
	//        $model = $model->where('title', 'like', "%{$search['value']}%");
	//    } else {
	//        $model = $model->where('title', $search['value'])->orWhere('title', $search['value']);
	//    }
	//}
	//$model = $model->leftJoin('comments as c', 'c.comments_id', '=', 'cr.comments_id');
	//$model = $model->leftJoin('users as u', 'u.id', '=', 'cr.user_id');
	//$count = $model->count();
	//
	//
	//$model = $model->orderBy('cr.updated_at', $order['dir']);
	//$arr = $model->offset($start)->limit($length)->get([
	//    'level','comments_resource_id as id','parent_id as pid','txt as name','u.name as user',
	//    'is_check as auth','cr.updated_at as updated','title','cr.user_id','cr.comments_id']);
	//$auth = Comments::COMMENTS_CHECK_ING;

    if($auth == '0'){

        $arr0 = DB::select('
                    SELECT comments_resource_id as id
                    FROM comments_resource t2
                    LEFT JOIN comments as c ON c.comments_id = t2.comments_id
                    LEFT JOIN users as u ON u.id = t2.user_id
                    WHERE t2.is_check = '.$auth.'
                    ORDER BY t2.comments_resource_id
                ');

        $arr1 = DB::select('
                    SELECT comments_resource_id as id
                    FROM comments_resource t2
                    LEFT JOIN comments as c ON c.comments_id = t2.comments_id
                    LEFT JOIN users as u ON u.id = t2.user_id
                    WHERE t2.is_check = '.$auth.'
                    ORDER BY t2.comments_resource_id
                    LIMIT 10 OFFSET 0;
                ');

        $arr2 = [];
        foreach($arr1 as $val){
            $arr2[]= DB::select('
                SELECT level,comments_resource_id as id,parent_id as pid,txt as name,u.name as user,
                    is_check as auth,t2.updated_at as updated,title,t2.user_id,t2.comments_id
                FROM (
                    SELECT
                            @r AS _id,
                            (SELECT @r := parent_id as pid FROM comments_resource WHERE comments_resource_id = _id) AS pid,
                             @l := @l + 1 AS lvl
                    FROM
                            (SELECT @r := '.$val->id.', @l := 0) vars,
                            comments_resource h
                    WHERE @r <> 0) t1
                JOIN comments_resource t2 ON t1._id = t2.comments_resource_id
                LEFT JOIN comments as c ON c.comments_id = t2.comments_id
                LEFT JOIN users as u ON u.id = t2.user_id
                ORDER BY t2.comments_resource_id
            ');

        }

        $arr3 = [];
        foreach($arr2 as $val){
            foreach($val as $v){
                array_push($arr3, $v);
            }
        }

        $arr = $this->array_unique_2d($arr3);

        $count = count($arr0);

    }else{

        $arr12 = DB::select('
                SELECT comments_resource_id as id
                FROM comments_resource t2
                LEFT JOIN comments as c ON c.comments_id = t2.comments_id
                LEFT JOIN users as u ON u.id = t2.user_id
                WHERE t2.is_check = '.$auth.';
            ');

        $arr11 = DB::select('
                SELECT level,comments_resource_id as id,parent_id as pid,txt as name,u.name as user,
                    t2.is_check as auth,t2.updated_at as updated,title,t2.user_id,t2.comments_id
                FROM comments_resource t2
                LEFT JOIN comments as c ON c.comments_id = t2.comments_id
                LEFT JOIN users as u ON u.id = t2.user_id
                WHERE t2.is_check = '.$auth.'
                ORDER BY t2.comments_resource_id
                LIMIT '.$length.' OFFSET '.$start.';
            ');
        $arr = json_decode(json_encode($arr11), true);

        $count = count($arr12);
    }


	//$arr = json_decode(json_encode($arr1), true);
	//$arr = $this->createTree($arr);
	//$arr = $this->array_multiToSingle($arr);
	//$arr = $this->array_SingleTo2($arr);

    return [
        'draw' => $draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $arr
    ];
}
```
参考 [php函数二维数组惟一过滤](http://www.dewen.net.cn/q/1511/%E5%A6%82%E4%BD%95%E5%AF%B9php+%E5%81%9A%E4%BA%8C%E7%BB%B4%E6%95%B0%E7%BB%84%E7%9A%84array_unique)  
### 不可分页版
控制器二维变嵌套，再变一维，再变二维返回前端  
```
function createTree($array, $pid = 0)
{
    $ret = array();

    foreach($array as $key => $value){
        if($value['pid'] == $pid){
            $tmp = $value;
            unset($array[$key]);
            $tmp['list'] = $this->createTree($array, $value['id']);
            $ret[] = $tmp;

        }
    }

    return $ret;
}


function array_multiToSingle($array,$clearRepeated=false)
{
    if(!isset($array)||!is_array($array)||empty($array)){
        return false;
    }
    if(!in_array($clearRepeated,array('true','false',''))){
        return false;
    }
    static $result_array=array();
    foreach($array as $value){
        if(is_array($value)){
            $this->array_multiToSingle($value);
        }else{
            $result_array[]=$value;
        }
    }
    if($clearRepeated){
        $result_array=array_unique($result_array);
    }
    return $result_array;
}

function array_SingleTo2($array){
    static $result_array=array();
    $len = (count($array)+1)/3-1;
    for($i=0;$i<$len;$i++){
        $result_array[$i]['id'] = array_shift($array);
        array_shift($array);
        $result_array[$i]['name'] = array_shift($array);
    }

    return $result_array;
}

public function index()
{
    $arr = array(
        array('id'=>1,'pid'=>0,'name'=>'1'),
        array('id'=>2,'pid'=>1,'name'=>'1-1'),
        array('id'=>3,'pid'=>0,'name'=>'2'),
        array('id'=>4,'pid'=>3,'name'=>'3-3'),
        array('id'=>5,'pid'=>3,'name'=>'3-4'),
        array('id'=>6,'pid'=>1,'name'=>'1-2')
    );

    $arr = $this->createTree($arr);
    $arr = $this->array_multiToSingle($arr);
    $arr = $this->array_SingleTo2($arr);
    dd($arr);die;

    $tree = json_encode($this->createTree($arr), JSON_UNESCAPED_UNICODE);

    return view('admin.comments.index',['tree'=>$tree]);
}
```
### 参考版 json树形数组->html
  
var menulist = {  
    "menulist": [  
        { "MID": "M001", "MName": "首页", "Url": "#", "menulist": "" },  
        { "MID": "M002", "MName": "车辆买卖", "Url": "#", "menulist":  
            [  
                { "MID": "M003", "MName": "新车", "Url": "#", "menulist":  
                    [  
                        { "MID": "M006", "MName": "奥迪", "Url": "#", "menulist": "" },  
                        { "MID": "M007", "MName": "别克", "Url": "#", "menulist": "" }  
                    ]  
                },  
                { "MID": "M004", "MName": "二手车", "Url": "#", "menulist": "" },  
                { "MID": "M005", "MName": "改装车", "Url": "#", "menulist": "" }  
            ]  
        },  
        { "MID": "M006", "MName": "宠物", "Url": "#", "menulist": "" }  
    ]  
};  
  
$("#click").click(function () {  
     var showlist = $("<ul></ul>");  
     showall(menulist.menulist, showlist);  
     $("#tree").append(showlist);  
});  
  
  
//menu_list为json数据  
//parent为要组合成html的容器  
function showall(menu_list, parent) {  
    for (var menu in menu_list) {  
        //如果有子节点，则遍历该子节点  
        if (menu_list[menu].menulist.length > 0) {  
            //创建一个子节点li  
            var li = $("<li></li>");  
            //将li的文本设置好，并马上添加一个空白的ul子节点，并且将这个li添加到父亲节点中  
            $(li).append(menu_list[menu].MName).append("<ul></ul>").appendTo(parent);  
            //将空白的ul作为下一个递归遍历的父亲节点传入  
            showall(menu_list[menu].menulist, $(li).children().eq(0));  
        }  
        //如果该节点没有子节点，则直接将该节点li以及文本创建好直接添加到父亲节点中  
        else {  
            $("<li></li>").append(menu_list[menu].MName).appendTo(parent);  
        }  
    }  
 }  
  
参考 http://www.cnblogs.com/hxhbluestar/archive/2011/11/17/2252009.html  
### 优化版：php二维数组处理返回嵌套数组，前端循环变量显示
```

function createTree($array, $pid = 0){
    $ret = array();

    foreach($array as $key => $value){
        if($value['pid'] == $pid){
            $tmp = $value;
            unset($array[$key]);
            $tmp['list'] = $this->createTree($array, $value['id']);
            $ret[] = $tmp;
        }
    }

    return $ret;
}

public function index()
{
    $array = array(
        array('id'=>1,'pid'=>'0','name'=>'11111'),
        array('id'=>2,'pid'=>'1','name'=>'22222'),
        array('id'=>3,'pid'=>'0','name'=>'33333'),
        array('id'=>4,'pid'=>'3','name'=>'44444'),
        array('id'=>5,'pid'=>'4','name'=>'55555'),
        array('id'=>6,'pid'=>'1','name'=>'66666')
    );

    $tree = json_encode($this->createTree($array), JSON_UNESCAPED_UNICODE);

    return view('admin.comments.index',['tree'=>$tree]);
}

```
```

<button id="click">click</button>
            <div id="tree">

            </div>

var tree = {}
    tree.list = {!! $tree !!}

$("#click").click(function () {
    var showlist = $("<ul></ul>");
    showall(tree.list, showlist);
    $("#tree").append(showlist);
});

function showall(list, parent) {
    for (var index in list) {
        if (list[index].list.length > 0) {
            var li = $("<li></li>");
            $(li).append(list[index].name).append("<ul></ul>").appendTo(parent);
            showall(list[index].list, $(li).children().eq(0));
        }else {
            $("<li></li>").append(list[index].name).appendTo(parent);
        }
    }
}

