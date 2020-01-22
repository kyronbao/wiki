## 介绍
参考：https://laravel.com/docs/6.x/facades

门面提供了一个“静态”的接口，用来使用使用Laravel服务容器中可用的类。门面类似于提供了Laravel底层类的“静态代理“，比传统的静态方法语法更灵活，易测试。

## 什么时候使用门面

Laravel的门面容易使用。不同于依赖注入（可以在contruct函数中直观的看到注入的类的多少，而避免注入太多的实例），需要注意的是在类中使用门面时注意类的大小，使门面的作用范围简洁。

当构造第三方包时，最好使用注入而不是门面。因为包构建在Laravel的外部，不需要Laravel门面测试的支持。

## 门面 vs 依赖注入

门面更易测试

## 门面 vs 帮助函数
没什么本质的而区别。在底层，帮助函数的方法通过门面来实现
```
return View::make('profile');

return view('profile');
```

## 门面是怎么实现的
门面通过魔术方法 __callStatic() 延迟调用一个容器中解析的对象。
```
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }
```

```
    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        if (static::$app) {
            return static::$resolvedInstance[$name] = static::$app[$name];
        }
    }
```

## 实时门面
待续
