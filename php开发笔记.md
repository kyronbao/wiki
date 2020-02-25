  
使用注入还是new 还是静态调用  
注入的话框架使用  
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
