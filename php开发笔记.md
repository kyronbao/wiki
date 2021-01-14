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
