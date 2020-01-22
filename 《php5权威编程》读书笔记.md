  
单例模式  
```
class Singleton {
    static private $instance = NULL;
    private function __construct() {
    }
    static public function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new Singleton();
        }
    return self::$instance;
    }
}
```
  
循环时修改值  
```
foreach ($array as &$value) {
    if ($value === "NULL") {
        $value = NULL;
    }
}
```
  
```
function my_func(&$arg = null) {
    if ($arg === NULL) {
        print '$arg is empty';
    }
}
my_func();
```
  
- [SAX](https://zh.wikipedia.org/wiki/SAX) Simple API for XML（簡稱SAX）是個循序存取XML的解析器API
- [[https://www.cnblogs.com/Anker/p/3542058.html][libxml2]] [wiki](https://zh.wikipedia.org/wiki/Libxml2) libxml是一个用来解析XML文档的函数库,xml广泛应用于网络数据交换，配置文件、Web服务等等
- XSLT [[https://zh.wikipedia.org/zh-cn/XSLT][wiki]] [百科](https://baike.baidu.com/item/XSLT)
  
- [PHP扩展和包的管理：PEAR、PECL、Composer](https://www.jianshu.com/p/d8b75dbc852a)
- [PHP和PEAR, PHAR, PECL](https://jysperm.me/2013/04/790/)
  - https://pecl.php.net/
  - https://pear.php.net/packages.php
  - https://packagist.org/
  
- SOAP
  - [浅谈 SOAP](https://www.ibm.com/developerworks/cn/xml/x-sisoap/index.html)
    - SOAP（Simple Object Access Protocol）简单对象访问协议是在分散或分布式的环境中交换信息的简单的协议，是一个基于XML的协议
    - SOAP简单的理解，就是这样的一个开放协议SOAP=RPC+HTTP+XML
  - [REST和SOAP：谁更好，或者都好？](http://www.infoq.com/cn/articles/rest-soap-when-to-use-each)
  
- perl扩展
  - [嵌入式 Perl 解释器扩展](https://www.ibm.com/developerworks/cn/opensource/os-cn-php-pecl/index.html)
  
- isset() and !empty()
  - [In where shall I use isset() and !empty()](https://stackoverflow.com/questions/1219542/in-where-shall-i-use-isset-and-empty)
  - [Why check both isset() and !empty()](https://stackoverflow.com/questions/4559925/why-check-both-isset-and-empty/4560099)
  - [[http://php.net/manual/en/types.comparisons.php]] 官方的对比文档
  
- chapter 9
- [WebDAV](https://zh.wikipedia.org/wiki/%E5%9F%BA%E4%BA%8EWeb%E7%9A%84%E5%88%86%E5%B8%83%E5%BC%8F%E7%BC%96%E5%86%99%E5%92%8C%E7%89%88%E6%9C%AC%E6%8E%A7%E5%88%B6)
  - 知乎 [webdav是什么，有什么作用，应用场景是什么，不要概念？](https://www.zhihu.com/question/30719209)
  - https://juejin.im/entry/556fcde4e4b0daa259c432e9
- [JSON-RPC](https://zh.wikipedia.org/wiki/JSON-RPC)
  - [WEB开发中，使用JSON-RPC好，还是RESTful API好？](https://www.zhihu.com/question/28570307)
