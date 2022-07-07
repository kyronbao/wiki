## __sleep() __wakeup() 对象序列化时先调用__sleep()方法，用来处理需要保存的属性  
vendor/laravel/framework/src/Illuminate/Queue/SerializesModels.php:17  
- http://php.net/manual/zh/language.oop5.magic.php

此功能可以用于清理对象，并返回一个包含对象中所有应被序列化的变量名称的数组  
  
相关函数  
 http://php.net/manual/zh/reflectionproperty.setaccessible.php  
- setAccessible() 让私有属性可读取
 http://php.net/manual/en/reflectionproperty.getvalue.php  
- getValue() 获取属性
 http://php.net/manual/zh/reflectionproperty.setvalue.php  
- setValue() 设置对象的属性
  
总结 http://php.net/manual/en/reflectionproperty.isstatic.php  
  
## forward_static_call()调用类的方法或函数，同时传入参数（懒绑定模式）
vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:206  
- http://php.net/manual/en/function.forward-static-call.php
## flock
vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php:58  
- https://blog.csdn.net/fdipzone/article/details/43839851
## array_reverse() 反转数组中的值  
```
/**  
 * Return an array with elements in reverse order  
 * @link http://php.net/manual/en/function.array-reverse.php  
 * @param array $array <p>  
 * The input array.  
 * </p>  
 * @param bool $preserve_keys [optional] <p>  
 * If set to true keys are preserved.  
 * </p>  
 * @return array the reversed array.  
 * @since 4.0  
 * @since 5.0  
 */  
function array_reverse(array $array, $preserve_keys = null) { }  
```
## static() 后期静态绑定  
vendor/symfony/http-foundation/Request.php:1910  

```
class A {
  public function create1() {
    $class = get_class($this);
　　　　return new $class();
  }
  public function create2() {
    return new static();
  }
}

class B extends A {

}

$b = new B();
var_dump(get_class($b->create1()), get_class($b->create2()));

/*
The result
string(1) "B"
string(1) "B"
*/
```
## bindTo()
```
    /**  
     * Duplicates the closure with a new bound object and class scope  
     * @link http://www.php.net/manual/en/closure.bindto.php  
     * @param object $newthis The object to which the given anonymous function should be bound, or NULL for the closure to be unbound.  
     * @param mixed $newscope The class scope to which associate the closure is to be associated, or 'static' to keep the current one.  
     * If an object is given, the type of the object will be used instead.  
     * This determines the visibility of protected and private methods of the bound object.  
     * @return Closure Returns the newly created Closure object or FALSE on failure  
     */  
    function bindTo($newthis, $newscope = 'static') { }  
```  
## array_reduce
```  
/**  
 * Iteratively reduce the array to a single value using a callback function  
 * @link http://php.net/manual/en/function.array-reduce.php  
 * @param array $input <p>  
 * The input array.  
 * </p>  
 * @param callback $function <p>  
 * The callback function.  
 * </p>  
 * @param mixed $initial [optional] <p>  
 * If the optional initial is available, it will  
 * be used at the beginning of the process, or as a final result in case  
 * the array is empty.  
 * </p>  
 * @return mixed the resulting value.  
 * </p>  
 * <p>  
 * If the array is empty and initial is not passed,  
 * array_reduce returns &null;.  
 * @since 4.0.5  
 * @since 5.0  
 */  
function array_reduce(array $input, $function, $initial = null) { }  
```
## parse_str() 从字符串解析参数  
vendor/symfony/http-foundation/Request.php:286  
```  
/**  
 * Parses the string into variables  
 * @link http://php.net/manual/en/function.parse-str.php  
 * @param string $str <p>  
 * The input string.  
 * </p>  
 * @param array $arr [optional] <p>  
 * If the second parameter arr is present,  
 * variables are stored in this variable as array elements instead.  
 * </p>  
 * @return void  
 * @since 4.0  
 * @since 5.0  
 */  
function parse_str ($str, array &$arr = null) {}  
```
## IteratorAggregate 创建遍历器的接口  
  
vendor/laravel/framework/src/Illuminate/Routing/RouteCollection.php:13  
```
/**  
 * Interface to create an external Iterator.  
 * @link http://php.net/manual/en/class.iteratoraggregate.php  
 */  
interface IteratorAggregate extends Traversable {  
  
    /**  
     * Retrieve an external iterator  
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php  
     * @return Traversable An instance of an object implementing <b>Iterator</b> or  
     * <b>Traversable</b>  
     * @since 5.0.0  
     */  
    public function getIterator();  
}  
```
## Countable 计算对象数量的接口  
```  
可以用来计算对象中成员的数量  
如 =count($obj)=  
  
vendor/laravel/framework/src/Illuminate/Routing/RouteCollection.php:13  
/**  
 * Classes implementing <b>Countable</b> can be used with the  
 * <b>count</b> function.  
 * @link http://php.net/manual/en/class.countable.php  
 */  
interface Countable {}  
```  
## ArrayAccess 使object可以像array
源码中容器Container implements ArrayAccess,  
参考 http://php.net/manual/en/class.arrayaccess.php  
通过示例，Arrayaccess接口使object可以像array一样方便使用，是个非常方便的功能  
## 三元运算符的简写
```
$output = $value ? $value : 'No value set.';  
相当于  
$output = $value ?: 'No value set.';  
```
是5.3的语法  
## http_build_query() 可以实现url的生成  
```
 URL::to('admin/source/iauth').'?'.http_build_query(['id'=>$data->source_id, 'title'=>$data->title, 'update'=>$data->updated_at])  
 ```
* Laravel封装的函数  
## class_uses_recursive() 返回类的traits
```
/**
 * Returns all traits used by a class, its parent classes and trait of their traits.
 *
 * @param  object|string  $class
 * @return array
 */
function class_uses_recursive($class)
{
    if (is_object($class)) {
        $class = get_class($class);
    }

    $results = [];

    foreach (array_reverse(class_parents($class)) + [$class => $class] as $class) {
        $results += trait_uses_recursive($class);
    }

    return array_unique($results);
}
```
  
使用示例：  
Mode中查找Trait  
vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:202  
## class_basename($class) 返回命名空间类的类名

vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php:203  
```
    /**
     * Get the class "basename" of the given object / class.
     *
     * @param  string|object  $class
     * @return string
     */
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
```
