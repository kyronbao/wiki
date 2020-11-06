  
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
## 二位数组的排序

如果按两个字段排序，可以这样

        array_multisort(array_column($params, 'seq'),SORT_ASC,
            array_column($params,'bdDyestuffAssistName'), SORT_STRING,
            $params
        );
		
如果三个字段排序，其中一个字段按规定排序

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

## 对象转数组

    json_decode(json_encode($data), true);
