# 前言
## 缘由

笔者一年前曾陆陆续续记录了一些Laravel源码学习的笔记，最近读起来，发现好多内容自己也看不太懂了。这次，借着工作中重新使用Laravel开发，打算重写一下源码阅读笔记，同时对以前的笔记也做一个梳理。

## 目标
- 易读，易读，易读

## 版本
- Laravel 6.02
由于最新的Laravel 6.0版本为长期维护的LTS版本，所以打算目前最新的6.02版为源码阅读的版本


# 怎样阅读laravel源码
## 工具的使用
好的工具，可以事半功倍
### PHPStorm 
好用不解释。常见的使用如：
函数等源的追踪： Ctrl+单击
追踪完后的返回：菜单->Navigate->Back(可自定义快捷键如：Alt+z)
全项目查找：Ctrl+Shift+f

类或方法的父辈导航: 单击类或方法名左边对应的^
类或方法的后辈导航: 单击类或方法名左边对应的V

### API文档
地址：https://laravel.com/api/6.x/
API文档清晰,简洁
可以用来预览laravel各类的方法及作用
也可以用来查找某些源码（比如说类的方法）的实现地址

### Chrome的扩展Sourcegraph
这个堪称神器，实现了在浏览器源码追踪的功能，打算临时查找一些源码，又不想使用IDE,可以一用。


# 概念：请求生命周期
## 前言
这篇文章打算列出Laravel生命周期的尽可能详细的各个步骤，待后面进一步分析。

## 容器实例的启动
容器启动时注册绑定了各种实例，如下：

```
    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }
        $this->registerBaseBindings();
        $this->registerBaseServiceProviders();
        $this->registerCoreContainerAliases();
    }
```
## 容器解析出kernel实例

## kernel处理request请求，生成response实例

## response发送输出

## kernel结束实例

# 概念：服务容器
参考 https://laravel.com/docs/6.x/container
这里解释了几种函数的用法，大致使用如下：

## 基础的绑定
当类没有继承接口，没有必要绑定到容器，因为可以通过注入来实现。

bind可以绑定一个闭包的实现。（本例中，因为闭包中含有容器中实例的调用解析，所以使用了服务提供者）
```
$this->app->bind('HelpSpot\API', function ($app) {
    return new HelpSpot\API($app->make('HttpClient'));
});
```
singleton绑定后，只解析一次，后续返回相同的实例
```
$this->app->singleton('HelpSpot\API', function ($app) {
    return new HelpSpot\API($app->make('HttpClient'));
});
```
instance绑定一个存在的实例
```
$api = new HelpSpot\API(new HttpClient);

$this->app->instance('HelpSpot\API', $api);
```

## 绑定接口的实现
bind可以传参2个参数（接口和其实现），绑定后，通过注入接口来得到需要的实现
```
$this->app->bind(
    'App\Contracts\EventPusher',
    'App\Services\RedisEventPusher'
);
```

```
use App\Contracts\EventPusher;


public function __construct(EventPusher $pusher)
{
    $this->pusher = $pusher;
}
```

# 概念：服务提供者
## 前言
Laravel中有个重要的概念是服务提供者，具体参考 https://laravel.com/docs/6.x/providers

服务提供者是Laravel中所有application启动的地方。我们的application，包括Laravel的核心服务都是通过服务提供者来启动的。

# 概念：门面
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

# 概念：契约
## 契约 vs 门面

门面，不要注入，直接拿来使用，方便

契约，允许指定具体的实现，通过注入使用，可以方便精确控制使用那个实现

## 何时使用契约

构建第三方包时，要使用契约，因为方便测试。



