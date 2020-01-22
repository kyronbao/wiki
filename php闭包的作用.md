```
public function __construct($config)
{
parent::__construct();
$this['config'] = function () use ($config) {
    return new Config($config);
};

 #    其中
$this['config'] = function () use ($config) {
    return new Config($config);
#    能不能直接写成这样：
$this['config'] = new Config($config);
#    有什么优势？
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
  
