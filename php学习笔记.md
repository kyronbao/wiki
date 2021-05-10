## php闭包的作用
```
public function __construct($config)
{
parent::__construct();
$this['config'] = function () use ($config) {
    return new Config($config);
};

其中
$this['config'] = function () use ($config) {
    return new Config($config);
 能不能直接写成这样：
$this['config'] = new Config($config);
  有什么优势？
```
  
惰加载。这两种写法都可以，但是。  
```
$this['config'] = new Config($config);
```
这种方式，当你给 =$this['config']= 赋值的时候，即进行了 =new Config($config)= 操作。  
```
$this['config'] = function () use ($config) {
        return new Config($config);
}
```
这种方式，你只是给 =$this['config']= 一个匿名函数，当你要用到的时候，才会进行 =new Config($config)= 的操作。  
  
这样写的好处的是，当 =$this['config']= 不被真正使用时，减少了额外实例化的过程和内存的消耗，即懒加载。  
  

## php闭包使用use和直接传参的区别 
实际应用 1 : 在创建闭包时, 生成所use变量的快照, 下文再次调用闭包函数时, 快照变量不改变  
```
    $a = 5;

    $b = function ($x) use ($a) {
        $a += $x;
        echo $a;
    };

    $a = 10; // 这个变量被再次赋值, 但是在use语句中的'快照'是不会改变的

    $b(100); // 输出 : 105
```
实际应用 2 : 使用引用传值, 生成所use变量的指针, 下文再次调用闭包函数时, 快照变量会改变(其实这样做与直接传参已经没有区别, 所以这么做意义不大, 而且代码可读性降低)  
```
    $a = 5;

    $b = function ($x) use (&$a) {
        $a += $x;
        echo $a;
    };

    $a = 10; // 变量重新赋值, 上文中闭包所引用的变量值也被改变

    $b(100); // 输出 : 110
```

## php的加密函数  
php提供了加密的函数  
//查看哈希值的相关信息  
array password_get_info (string $hash)  
  
//创建hash密码  
string password_hash(string $password , integer $algo [, array $options ])  
  
//判断hash密码是否特定选项、算法所创建  
boolean password_needs_rehash (string $hash , integer $algo [, array $options ]  
  
boolean password_verify (string $password , string $hash)  
//验证密码  
  
问： 这样和用md5自己设计规则的算法相比有什么不同呢？  
 md5,sha1这种在加盐后得到的值为固定一样的密码，也容易被反向破解  
password_hash默认采用CRYPT_BLOWFISH加密算法，目前不能被反向破解；每次加的盐值随机（官方建议不使用固定的盐：PASSWORD_BCRYPT算法提供，PHP7.0.0版本后废弃），即使使用原生密码相同，加密后的值也是不同的  
  
参考  
- https://www.php.net/manual/zh/faq.passwords.php
- https://zh.wikipedia.org/wiki/Blowfish
## php和mysql关于时间的处理和Carbon的使用  
首先是Mysql的时间格式有datetime，timestamp，该怎么选择  
  
- [怎么选择datetime timestap](https://stackoverflow.com/questions/409286/should-i-use-the-datetime-or-timestamp-data-type-in-mysql)
- [怎么创建mysql datatime字段](https://stackoverflow.com/questions/168736/how-do-you-set-a-default-value-for-a-mysql-datetime-column)
  
- [Mysql时间字段格式如何选择，TIMESTAMP，DATETIME，INT？](https://segmentfault.com/q/1010000000121702)
  
总结来说，  
一般created_at,updated_at使用timestamp，  
初始值使用CURRENT_TIME  
  
carbon  
- https://9iphp.com/web/laravel/php-datetime-package-carbon.html
创建时间  
$bbbb = \Carbon\Carbon::createFromDate(2018, 12, 25);  
$bbbb = \Carbon\Carbon::yesterday();  
$bbbb = \Carbon\Carbon::now();  
  
一天的开始时间 结束时间  
$this->yesterday = Carbon::yesterday();  
$this->startOfDay = $this->yesterday->startOfDay()->toDateTimeString();  
$this->endOfDay = $this->yesterday->endOfDay()->toDateTimeString();  
时间戳  
$this->yesterday->startOfDay()->timestamp  
日期格式  
$this->yesterday->format("Y-m-d")  
  
  
date()  
昨天  
date('Y-m-d', strtotime('-1 days'));  
date('Ym', strtotime($date));  
  
打印时间戳  


## php加载不到类的处理办法  
在yii项目中调试发现 有个类找不到，试了各种办法：  
- 重新拉取masster代码
- composer install
- copy别的项目可用的vender
最后，都不管用  
  
解决办法是：  
  
```
composer dump-autoload -o
```
