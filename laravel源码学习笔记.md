## Str
vendor/laravel/framework/src/Illuminate/Support/Str.php:12  
## Arr
vendor/laravel/framework/src/Illuminate/Support/Arr.php:8  
  
## 查看app的服务提供者
vendor/laravel/framework/src/Illuminate/Foundation/Application.php:546  
```
dump($providers->collapse()->toArray());
dump($this->getCachedServicesPath()); // 已分类
```
## request参数处理
vendor/symfony/http-foundation/ParameterBag.php:81  
## 查找一些方法实现源码
比如想查看Collection的fresh()方法，首先打开api文档  
- https://laravel.com/api/5.6/search.html
搜到后进入相应的源码，方法右边可以看到github的源码地址  
## http 状态码
\Symfony\Component\HttpFoundation\Response  
vendor/symfony/http-foundation/Response.php:20  
## 打印sql
```
$thread->toSql();
```
## 一个很好的观察bind()的方法
在bind()内打印  
```
dump($abstract, $concrete );
```
然后在singleton()函数下面打印$app并终止 =dd($app);=  
## 观察laravel的事件机制
vendor/laravel/framework/src/Illuminate/Events/Dispatcher.php:192  
在函数内打印  
=dump($event)=  
  
## 打印模型中注册的事件
vendor/laravel/framework/src/Illuminate/Database/Eloquent/Concerns/HasEvents.php:129  
在if中打印  
```
dump([static::$dispatcher, "eloquent.{$event}: {$name}", $callback]);
```
## 观察管道中流过的顺序
vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php:52  
或  
vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php:128  
=dump($pipe)=  
  
## 容器中服务的注册的地方
app实例化时  
vendor/laravel/framework/src/Illuminate/Foundation/Application.php:137  
这里注册了  
  - app Container::Class PackageManifest::Class
  - Event Log Routing服务
  - 给核心类工厂设置了别名
    - 加载 bootstrap/cache/services.php:3
  
bootstrap/app.php:28  
这里注册了Kernel类，Kernel实例中包含了各种中间件  
  
vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:146  
Kernel类中启动各种服务，包含RegisterProviders服务  
  
vendor/laravel/framework/src/Illuminate/Foundation/Bootstrap/RegisterProviders.php:14  
vendor/laravel/framework/src/Illuminate/Foundation/Application.php:539  
RegisterRroviders的执行，加载config/app.providers  
  
  
  
## 配置文件中APP_URL用在什么地方
在命令行执行php artisan时，获取url  
vendor/laravel/framework/src/Illuminate/Foundation/Bootstrap/SetRequestForConsole.php:17  
  
## 实例化Application
### Application类创建
```
$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);
```
查看Application类  
```
/**
 * Create a new Illuminate application instance.
 *
 * @param  string|null  $basePath
 * @return void
 */
public function __construct($basePath = null)
{
    if ($basePath) {
        // 设置路径别名到instancs属性
        $this->setBasePath($basePath);
    }
    // 设置app,Container::class，PackageManifest::class到instances属性
    $this->registerBaseBindings();
    // 绑定到binding[]属性
    $this->registerBaseServiceProviders();
    // 设置别名
    $this->registerCoreContainerAliases();
}
```
  
### 分析register注册EventServiceProvider
vendor/laravel/framework/src/Illuminate/Foundation/Application.php:186  
  
```
$this->register(new EventServiceProvider($this));
```
通过注入容器的 =singleton()= 方法，最终可以追踪到到 =Container= 类的方法，其中 =$shared= 等于 =true= 。  
  
```
public function bind($abstract, $concrete = null, $shared = false)
{
    // If no concrete type was given, we will simply set the concrete type to the
    // abstract type. After that, the concrete type to be registered as shared
    // without being forced to state their classes in both of the parameters.
    $this->dropStaleInstances($abstract);

    if (is_null($concrete)) {
        $concrete = $abstract;
    }

    // If the factory is not a Closure, it means it is just a class name which is
    // bound into this container to the abstract type and we will just wrap it
    // up inside its own Closure to give us more convenience when extending.
    if (! $concrete instanceof Closure) {
        $concrete = $this->getClosure($abstract, $concrete);
    }

    // 绑定到容器
    $this->bindings[$abstract] = compact('concrete', 'shared');

    // If the abstract type was already resolved in this container we'll fire the
    // rebound listener so that any objects which have already gotten resolved
    // can have their copy of the object updated via the listener callbacks.
    if ($this->resolved($abstract)) {
        $this->rebound($abstract);
    }
}
```
  
### 分析register注册LogServiceProvider
以 =$this->register(new LogServiceProvider($this));= 举例，最终将闭包  
```
function () {
    return new LogManager($this->app);
}
```
绑定到 =$app->bindings['log']['concrete']= 中，=shared= 标志设为 =true= (参考bind()方法)  
  
### 以数组格式获取容器的对象
=Container= 类实现 =ArrayAccess= 接口，可以像数组的方式访问 =$abstact= ，访问键值的实现为：  
```
    /**
     * Determine if a given offset exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->bound($key);
    }

    /**
     * Determine if the given abstract type has been bound.
     *
     * @param  string  $abstract
     * @return bool
     */
    public function bound($abstract)
    {
        return isset($this->bindings[$abstract]) ||
               isset($this->instances[$abstract]) ||
               $this->isAlias($abstract);
    }
```
最后的 =bound()= 判断是否已经绑定了 =abstract= 。  
  
获取值的实现：  
```
protected function resolve($abstract, $parameters = [])
{
    // 通过递归的方式获取了别名
    $abstract = $this->getAlias($abstract);

    $needsContextualBuild = ! empty($parameters) || ! is_null(
        $this->getContextualConcrete($abstract)
    );

    // 返回已存在的实例，实现了每次可以调用相同的实例
    // If an instance of the type is currently being managed as a singleton we'll
    // just return an existing instance instead of instantiating new instances
    // so the developer can keep using the same objects instance every time.
    if (isset($this->instances[$abstract]) && ! $needsContextualBuild) {
        return $this->instances[$abstract];
    }

    $this->with[] = $parameters;

    // 返回绑定的具体实现，比如闭包
    $concrete = $this->getConcrete($abstract);

    // 递归解析具体对象
    // We're ready to instantiate an instance of the concrete type registered for
    // the binding. This will instantiate the types, as well as resolve any of
    // its "nested" dependencies recursively until all have gotten resolved.
    if ($this->isBuildable($concrete, $abstract)) {
        //
        $object = $this->build($concrete);
    } else {
        $object = $this->make($concrete);
    }

    // If we defined any extenders for this type, we'll need to spin through them
    // and apply them to the object being built. This allows for the extension
    // of services, such as changing configuration or decorating the object.
    foreach ($this->getExtenders($abstract) as $extender) {
        $object = $extender($object, $this);
    }

    // 当$this->bindings[$abstract]['shared'] === true且不需要构建上下文时，将实例
    // 存到$this->instances[$abstract]中，再次判断isShare()方法时，检查instances
    // 中变量，这样就实现了一次创建，后续请求调用同一个实例。
    // If the requested type is registered as a singleton we'll want to cache off
    // the instances in "memory" so we can return it later without creating an
    // entirely new instance of an object on each subsequent request for it.
    if ($this->isShared($abstract) && ! $needsContextualBuild) {
        $this->instances[$abstract] = $object;
    }

    $this->fireResolvingCallbacks($abstract, $object);

    // Before returning, we will also set the resolved flag to "true" and pop off
    // the parameter overrides for this build. After those two things are done
    // we will be ready to return back the fully constructed class instance.
    $this->resolved[$abstract] = true;

    // 将函数开始传入的参数弹出栈
    array_pop($this->with);

    return $object;
}
```
  
最后，通过魔术方法实现访问和修改数组对象，如 =$app->log= 。  
```
    /**
     * Dynamically access container services.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this[$key];
    }

    /**
     * Dynamically set container services.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this[$key] = $value;
    }
```
  
检验 =dump($this->app);= ,发现实例多了如下变量：  
 [[file:EventServiceProvider.png]]  
  
## app绑定核心kernel
### singleton方法绑定Kernel
```
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);
```
  
在bind()函数中执行  
```

// If the factory is not a Closure, it means it is just a class name which is
// bound into this container to the abstract type and we will just wrap it
// up inside its own Closure to give us more convenience when extending.
if (! $concrete instanceof Closure) {
    $concrete = $this->getClosure($abstract, $concrete);
}
```
当$concrete不是闭包（如类名App\Http\Kernel）时，通过闭包，保存在bindings[]的concrete  
子数组中  
  
getCloure()函数如下：  
```
/**
 * Get the Closure to be used when building a type.
 *
 * @param  string  $abstract
 * @param  string  $concrete
 * @return \Closure
 */
protected function getClosure($abstract, $concrete)
{
    return function ($container, $parameters = []) use ($abstract, $concrete) {
        if ($abstract == $concrete) {
            return $container->build($concrete);
        }

        return $container->make($concrete, $parameters);
    };
}
```
打印后显示  
```
"Illuminate\Contracts\Http\Kernel" => array:2 [▼
  "concrete" => Closure {#21 ▼
    class: "Illuminate\Container\Container"
    this: Application {#3}
    parameters: {▶}
    use: {▶}
    file: "/home/kyronbao/laratice/vendor/laravel/framework/src/Illuminate/Container/Container.php"
    line: "251 to 257"
  }
  "shared" => true
]
```
发现里面返回是闭包，最后绑定到binding[]中，暂时先停止追踪。  
  
### Kernel类的实现
vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php:88  
  
```
/**
 * Create a new HTTP kernel instance.
 *
 * @param  \Illuminate\Contracts\Foundation\Application  $app
 * @param  \Illuminate\Routing\Router  $router
 * @return void
 */
public function __construct(Application $app, Router $router)
{
    $this->app = $app;
    $this->router = $router;

    $router->middlewarePriority = $this->middlewarePriority;

    foreach ($this->middlewareGroups as $key => $middleware) {
        $router->middlewareGroup($key, $middleware);
    }

    foreach ($this->routeMiddleware as $key => $middleware) {
        $router->aliasMiddleware($key, $middleware);
    }
}
```
## app生成核心kernel
### make()解析出核心
在实例化了$app后，回到index.php文件  
```
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
```
这里make()方法最终解析构建了$kernel实例  
  
这里最终解析了  
```
"Illuminate\Contracts\Http\Kernel"
"router"
"events"
```
  
### 详细分析解析步骤
进入resove()，  
通过getAliase()获取$abstract：”Illuminate\Contracts\Http\Kernel“，  
通过getConcrete()取出上一章绑定bindings["Illuminate\Contracts\Http\Kernel"]["concrete"]中的  
App\Http\Kernel构建的闭包，  
  
然后执行闭包的实现  
```
$object = $this->build($concrete);
```
因为$concrete是闭包，执行下面这行：  
```
$concrete($this, $this->getLastParameterOverride());
```
  
闭包的具体实现在这里  
vendor/laravel/framework/src/Illuminate/Container/Container.php:248  
```
/**
 * Get the Closure to be used when building a type.
 *
 * @param  string  $abstract
 * @param  string  $concrete
 * @return \Closure
 */
protected function getClosure($abstract, $concrete)
{
    return function ($container, $parameters = []) use ($abstract, $concrete) {
        if ($abstract == $concrete) {
            return $container->build($concrete);
        }
        return $container->make($concrete, $parameters);
    };
}
```
这里闭包中保存了$concrete的值"App\Http\Kernel"，需要执行$container->make($concrete, $parameters);  
即再次构建"App\Http\Kernel"。  
  
构建时进入下面流程：  
因为$concrete, $abstract均为App\Http\Kernel，进入  
```
$object = $this->build($concrete);
```
然后来到：  
```
$reflector = new ReflectionClass($concrete);

...

 $dependencies = $constructor->getParameters();

 // Once we have all the constructor's parameters we can create each of the
 // dependency instances and then use the reflection instances to make a
 // new instance of this class, injecting the created dependencies in.
 $instances = $this->resolveDependencies(
     $dependencies
 );
```
最后的方法resolveDependencies()通过分析可以知道，  
  - 执行了 =$this->resolveClass($dependency)= ，
  - 再次 =$this->resolveClass($dependency)= ，
  
通过PHP反射的功能将Kernel类的构造函数的依赖的类进行了解析，  
$parameter->getClass()->name分别为  
  - "Illuminate\Contracts\Foundation\Application"
  - 和"Illuminate\Routing\Router"，
别名为"app"和"router"。  
  
执行$this->make($parameter->getClass()->name);  
分析返回$instances值[$app, $router]可以知道：  
  - $app为Application的实例，$router为如下闭包的实现
  
vendor/laravel/framework/src/Illuminate/Routing/RoutingServiceProvider.php:38  
```
$this->app->singleton('router', function ($app) {
    return new Router($app['events'], $app);
});
```
  
最后 =$reflector->newInstanceArgs($instances)= 即对Kernel类实例化。  
  
Kerner类构造函数如下：  
```
/**
 * Create a new HTTP kernel instance.
 *
 * @param  \Illuminate\Contracts\Foundation\Application  $app
 * @param  \Illuminate\Routing\Router  $router
 * @return void
 */
public function __construct(Application $app, Router $router)
{
    $this->app = $app;
    $this->router = $router;

    $router->middlewarePriority = $this->middlewarePriority;

    foreach ($this->middlewareGroups as $key => $middleware) {
        $router->middlewareGroup($key, $middleware);
    }

    foreach ($this->routeMiddleware as $key => $middleware) {
        $router->aliasMiddleware($key, $middleware);
    }
}
```
将容器（即app/Http/Kernel.php）中的中间层和中间层分组赋值给$router，并且设置了别名。  
  
总结来说，首先实例化出Kernel类构造函数所需的参数$app和$router，最后再将Kernal实例化。  
## 获取网络请求requeset
查看capture方法  
  
首先设置网络请求时POST中可以被代替为PUT，DELETE等的设置  
```
static::enableHttpMethodParameterOverride();
```
  
然后创建$request对象  
```
return static::createFromBase(SymfonyRequest::createFromGlobals());
```
其中这句 =SymfonyRequest::createFromGlobals()= 调用Symfony的Request类，返回封装好的$request实例。  
传入createFromBase()方法，这里Laravel对$request实例复制并再次做了一些封装：  
比如：  
过滤$file数组中空值等。  
  
  
下面几节开始分析kernal的handle()方法  
## kernal中启动服务提供者
### 绑定request到容器中，初始化各种服务
  
```
$response = $this->sendRequestThroughRouter($request);
```
  
```
/**
 * Send the given request through the middleware / router.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
protected function sendRequestThroughRouter($request)
{
    // 绑定request
    $this->app->instance('request', $request);

    Facade::clearResolvedInstance('request');

    // 在容器中启动kernel的$bootstrappers
    $this->bootstrap();

    return (new Pipeline($this->app))
                ->send($request)
                ->through($this->app->shouldSkipMiddleware() ? [] : $this->middleware)
                ->then($this->dispatchToRouter());
}
```
  
查看启动的方法 =$this->bootstrap()=  
这里调用了初始化配置，门面，异常服务，注册服务，启动服务，  
在下面几节将详细介绍  
  
```
/**
 * Run the given array of bootstrap classes.
 *
 * @param  array  $bootstrappers
 * @return void
 */
public function bootstrapWith(array $bootstrappers)
{
    $this->hasBeenBootstrapped = true;

    foreach ($bootstrappers as $bootstrapper) {
        $this['events']->fire('bootstrapping: '.$bootstrapper, [$this]);

        $this->make($bootstrapper)->bootstrap($this);

        $this['events']->fire('bootstrapped: '.$bootstrapper, [$this]);
    }
}
```
这里依次启动系统中的一些实例，触发了fire事件，$bootstrappers如下  
```
/**
 * The bootstrap classes for the application.
 *
 * @var array
 */
protected $bootstrappers = [
    //加载.env
    \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
    //加载config配置文件，将参数实例化到对象中
    \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
    \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
    // 注册门面
    \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
    // 注册服务提供者
    \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
    // 启动服务提供者
    \Illuminate\Foundation\Bootstrap\BootProviders::class,
];
```
### 加载env参数，config文件，处理异常服务
略  
### 注册门面
其中注册门面Facades的启动函数如下  
```
/**
 * Bootstrap the given application.
 *
 * @param  \Illuminate\Contracts\Foundation\Application  $app
 * @return void
 */
public function bootstrap(Application $app)
{
    Facade::clearResolvedInstances();

    // 注册门面的app实例
    Facade::setFacadeApplication($app);

    AliasLoader::getInstance(array_merge(
        $app->make('config')->get('app.aliases', []), // 取到config的参数数组
          $app->make(PackageManifest::class)->aliases()  // 暂时为空 []
    ))->register();
}
```
### 注册服务提供者
```
    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        $providers = Collection::make($this->config['app.providers'])
                        ->partition(function ($provider) {
                            return Str::startsWith($provider, 'Illuminate\\');
                        });

        $providers->splice(1, 0, [$this->make(PackageManifest::class)->providers()]);

        (new ProviderRepository($this, new Filesystem, $this->getCachedServicesPath()))
                    ->load($providers->collapse()->toArray());
    }
```
### 启动服务提供者
```
    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->booted) {
            return;
        }

        // Once the application has booted we will also fire some "booted" callbacks
        // for any listeners that need to do work after this initial booting gets
        // finished. This is useful when ordering the boot-up processes we run.
        $this->fireAppCallbacks($this->bootingCallbacks);

        array_walk($this->serviceProviders, function ($p) {
            $this->bootProvider($p);
        });

        $this->booted = true;

        $this->fireAppCallbacks($this->bootedCallbacks);
    }
```
## Router返回Response对象
### Router中注入Request对象
可以先了解一下[管道模式](https://laravel-china.org/topics/7543/pipeline-pipeline-design-paradigm-in-laravel)， 后面在详细分析这一模式  
```
return (new Pipeline($this->app))
            ->send($request)
            ->through($this->app->shouldSkipMiddleware() ? [] : $this->middleware)
            ->then($this->dispatchToRouter());
```
其中 =$this->app->shouldSkipMiddleware()= 指当绑定了 =middleware.disable= 值时，可以跳过中间件。  
通过打印可知 =$this->middleware=  
```
array:5 [
  0 => "Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode"
  1 => "Illuminate\Foundation\Http\Middleware\ValidatePostSize"
  2 => "App\Http\Middleware\TrimStrings"
  3 => "Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull"
  4 => "App\Http\Middleware\TrustProxies"
]
```
  
首先查看一下管道处理完后的执行函数 =$this->dispatchToRouter()= ，  
来到这里，返回一个传入$request的闭包。  
```
/**
 * Get the route dispatcher callback.
 *
 * @return \Closure
 */
protected function dispatchToRouter()
{
    return function ($request) {
        $this->app->instance('request', $request);

        return $this->router->dispatch($request);
    };
}
```
这里，在容器中注入了request的实现。  
  
查看dispatch()的具体实现  
vendor/laravel/framework/src/Illuminate/Routing/Router.php:592  
```
/**
 * Dispatch the request to the application.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
 */
public function dispatch(Request $request)
{
    // 将当前请求保存到路由实例中
    $this->currentRequest = $request;

    return $this->dispatchToRoute($request);
}
```
  
来到这里  
```
/**
 * Dispatch the request to a route and return the response.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return mixed
 */
public function dispatchToRoute(Request $request)
{
    return $this->runRoute($request, $this->findRoute($request));
}
```
这里，通过Request的引用在Router对象中传入了request的具体实现  
  
分析 =$this->findRoute($request)=  
```
/**
 * Find the route matching a given request.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Routing\Route
 */
protected function findRoute($request)
{
    $this->current = $route = $this->routes->match($request);

    $this->container->instance(Route::class, $route);

    return $route;
}
```
  
### 匹配路由到控制器
  
追究一下 =$this->routes->match($request)= ，匹配到请求路由并绑定到当前路由  
```
/**
 * Find the first route matching a given request.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Routing\Route
 *
 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
 */
public function match(Request $request)
{
    // $request->getMethod()获取HTTP请求方法，如GET，POST，PUT等
    // 举例来说，浏览器不传参时，这里通过GET获取array ["api/user" => $route,  "/" => $route]
    // 这里"api/user"，"/"即在我们路由文件（routes根目录下文件）里设置的所有GET路由
    $routes = $this->get($request->getMethod());

    // 接下来，匹配当前url，并绑定到路由中
    // First, we will see if we can find a matching route for this current request
    // method. If we can, great, we can just return it so that it can be called
    // by the consumer. Otherwise we will check for routes with another verb.
    $route = $this->matchAgainstRoutes($routes, $request);

    if (! is_null($route)) {
        return $route->bind($request);
    }

    ...

}
```
  
分析 =runRoute()=  
```
/**
 * Return the response for the given route.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Illuminate\Routing\Route  $route
 * @return mixed
 */
protected function runRoute(Request $request, Route $route)
{
    // 将路由赋值给$request解析器
    $request->setRouteResolver(function () use ($route) {
        return $route;
    });

    // 派发事件
    // 具体实现见：vendor/laravel/framework/src/Illuminate/Events/Dispatcher.php:192
    // 如果
    $this->events->dispatch(new Events\RouteMatched($route, $request));

    return $this->prepareResponse($request,
        $this->runRouteWithinStack($route, $request)
    );
}
```
  
分析其中的 =$this->runRouteWithinStack($route, $request)=  
```
/**
 * Run the given route within a Stack "onion" instance.
 *
 * @param  \Illuminate\Routing\Route  $route
 * @param  \Illuminate\Http\Request  $request
 * @return mixed
 */
protected function runRouteWithinStack(Route $route, Request $request)
{
    $shouldSkipMiddleware = $this->container->bound('middleware.disable') &&
                            $this->container->make('middleware.disable') === true;

    $middleware = $shouldSkipMiddleware ? [] : $this->gatherRouteMiddleware($route);

    return (new Pipeline($this->container))
                    ->send($request)
                    ->through($middleware)
                    ->then(function ($request) use ($route) {
                        // 返回response对象
                        return $this->prepareResponse(
                            $request, $route->run()
                        );
                    });
}
```
通过打印可知 =$middleware= 为Kernal类的$middlewareGroups['web']的值  
```
array:6 [
  0 => "App\Http\Middleware\EncryptCookies"
  1 => "Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse"
  2 => "Illuminate\Session\Middleware\StartSession"
  3 => "Illuminate\View\Middleware\ShareErrorsFromSession"
  4 => "App\Http\Middleware\VerifyCsrfToken"
  5 => "Illuminate\Routing\Middleware\SubstituteBindings"
]
```
  
其中，=$route->run()= 返回处理完成后的View对象  
```
/**
 * Run the route action and return the response.
 *
 * @return mixed
 */
public function run()
{
    $this->container = $this->container ?: new Container;

    try {
        if ($this->isControllerAction()) {
            return $this->runController();  // 进入控制器的判断
        }

        // 比如当没有设置路由到控制器时，即直接在路由文件返回时
        return $this->runCallable();
    } catch (HttpResponseException $e) {
        return $e->getResponse();
    }
}
```
总结：  
到这里，可以看到路由参数进入控制器的流程  
  
### 返回Response对象，渲染页面
再分析将$request和以上返回值注入 =prepareResponse()=  
即 = toResponse()=  
  
```
/**
 * Static version of prepareResponse.
 *
 * @param  \Symfony\Component\HttpFoundation\Request  $request
 * @param  mixed  $response
 * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
 */
public static function toResponse($request, $response)
{
    if ($response instanceof Responsable) {
        $response = $response->toResponse($request);
    }

    if ($response instanceof PsrResponseInterface) {
        $response = (new HttpFoundationFactory)->createResponse($response);
    } elseif ($response instanceof Model && $response->wasRecentlyCreated) {
        $response = new JsonResponse($response, 201);
    } elseif (! $response instanceof SymfonyResponse &&
               ($response instanceof Arrayable ||
                $response instanceof Jsonable ||
                $response instanceof ArrayObject ||
                $response instanceof JsonSerializable ||
                is_array($response))) {
        $response = new JsonResponse($response);
    } elseif (! $response instanceof SymfonyResponse) {
        // 传入View对象
        $response = new Response($response);
    }

    if ($response->getStatusCode() === Response::HTTP_NOT_MODIFIED) {
        $response->setNotModified();
    }

    // 处理一些head,http version等信息
    // 比如移除Content-Type，Content-Length等信息
    return $response->prepare($request);
}
```
  
渲染页面的逻辑  
vendor/laravel/framework/src/Illuminate/Http/Response.php:24  
这里注意子对象中覆盖了setContent()  
```
    /**
     * Set the content on the response.
     *
     * @param  mixed  $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->original = $content;

        // If the content is "JSONable" we will set the appropriate header and convert
        // the content to JSON. This is useful when returning something like models
        // from routes that will be automatically transformed to their JSON form.
        if ($this->shouldBeJson($content)) {
            $this->header('Content-Type', 'application/json');

            $content = $this->morphToJson($content);
        }

        // If this content implements the "Renderable" interface then we will call the
        // render method on the object so we will avoid any "__toString" exceptions
        // that might be thrown and have their errors obscured by PHP's handling.
        elseif ($content instanceof Renderable) {
            $content = $content->render();
        }

        parent::setContent($content);

        return $this;
    }
```
  
View渲染出页面  
```
/**
 * Get the string contents of the view.
 *
 * @param  callable|null  $callback
 * @return string
 *
 * @throws \Throwable
 */
public function render(callable $callback = null)
{
    try {
        $contents = $this->renderContents();

        $response = isset($callback) ? call_user_func($callback, $this, $contents) : null;

        // Once we have the contents of the view, we will flush the sections if we are
        // done rendering all views so that there is nothing left hanging over when
        // another view gets rendered in the future by the application developer.
        $this->factory->flushStateIfDoneRendering();

        return ! is_null($response) ? $response : $contents;
    } catch (Exception $e) {
        $this->factory->flushState();

        throw $e;
    } catch (Throwable $e) {
        $this->factory->flushState();

        throw $e;
    }
}
```
  
最后，调用Engines开始来处理  
其中View对象的Engines如下  
```
    #engines: EngineResolver {#95 ▼
      #resolvers: array:3 [▼
        "file" => Closure {#96 ▶}
        "php" => Closure {#97 ▶}
        "blade" => Closure {#99 ▶}
      ]
      #resolved: array:1 [▼
        "blade" => CompilerEngine {#235 ▶}
      ]
    }
```
  
下面时php Engine的处理函数  
```
    /**
     * Get the evaluated contents of the view at the given path.
     *
     * @param  string  $__path
     * @param  array   $__data
     * @return string
     */
    protected function evaluatePath($__path, $__data)
    {
        $obLevel = ob_get_level();

        ob_start();

        extract($__data, EXTR_SKIP);

        // We'll evaluate the contents of the view inside a try/catch block so we can
        // flush out any stray output that might get out before an error occurs or
        // an exception is thrown. This prevents any partial views from leaking.
        try {
            include $__path;
        } catch (Exception $e) {
            $this->handleViewException($e, $obLevel);
        } catch (Throwable $e) {
            $this->handleViewException(new FatalThrowableError($e), $obLevel);
        }

        return ltrim(ob_get_clean());
    }
```
  
报错提示中间件  
vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php:35  
```
    public function handle($request, Closure $next)
    {
        // If the current session has an "errors" variable bound to it, we will share
        // its value with all view instances so the views can easily access errors
        // without having to bind. An empty bag is set when there aren't errors.
        $this->view->share(
            'errors', $request->session()->get('errors') ?: new ViewErrorBag
        );

        // Putting the errors in the view for every view allows the developer to just
        // assume that some errors are always available, which is convenient since
        // they don't have to continually run checks for the presence of errors.

        return $next($request);
```
### 管道模式分析
管道的具体分析，可以参考 [[http://php.net/manual/en/function.array-reduce.php][array_reduce()]] [Laravel 管道流原理](https://laravel-china.org/articles/5206/the-use-of-php-built-in-function-array-reduce-in-laravel)  
  
这里讲一下laravel管道的传值过程  
```
/**
 * Run the pipeline with a final destination callback.
 *
 * @param  \Closure  $destination
 * @return mixed
 */
public function then(Closure $destination)
{
    $pipeline = array_reduce(
        array_reverse($this->pipes), $this->carry(), $this->prepareDestination($destination)
    );

    return $pipeline($this->passable);
}

/**
 * Get the final piece of the Closure onion.
 *
 * @param  \Closure  $destination
 * @return \Closure
 */
protected function prepareDestination(Closure $destination)
{
    // 这里是array_reduce的起始init参数，最先执行
    return function ($passable) use ($destination) {
        return $destination($passable);
    };
}
```
  
```
/**
 * Get a Closure that represents a slice of the application onion.
 *
 * @return \Closure
 */
protected function carry()
{
    return function ($stack, $pipe) {
        return function ($passable) use ($stack, $pipe) {
            if (is_callable($pipe)) {
                // If the pipe is an instance of a Closure, we will just call it directly but
                // otherwise we'll resolve the pipes out of the container and call it with
                // the appropriate method and arguments, returning the results back out.
                return $pipe($passable, $stack);
            } elseif (! is_object($pipe)) {
                list($name, $parameters) = $this->parsePipeString($pipe);

                // If the pipe is a string we will parse the string and resolve the class out
                // of the dependency injection container. We can then build a callable and
                // execute the pipe function giving in the parameters that are required.
                $pipe = $this->getContainer()->make($name);

                $parameters = array_merge([$passable, $stack], $parameters);
            } else {
                // If the pipe is already an object we'll just make a callable and pass it to
                // the pipe as-is. There is no need to do any extra parsing and formatting
                // since the object we're given was already a fully instantiated object.
                $parameters = [$passable, $stack];
            }

            $response = method_exists($pipe, $this->method)
                            ? $pipe->{$this->method}(...$parameters)
                            : $pipe(...$parameters);

            return $response instanceof Responsable
                        ? $response->toResponse($this->container->make(Request::class))
                        : $response;
        };
    };
}
```
  
```
/**
 * Get a Closure that represents a slice of the application onion.
 *
 * @return \Closure
 */
protected function carry()
{
    return function ($stack, $pipe) {
        return function ($passable) use ($stack, $pipe) {
            try {
                $slice = parent::carry();

                $callable = $slice($stack, $pipe);

               // 这里又是一个闭包的实现，所以具体实现执行时间比上两行较晚
               // 返回Response对象
                return $callable($passable);
            } catch (Exception $e) {
                return $this->handleException($passable, $e);
            } catch (Throwable $e) {
                return $this->handleException($passable, new FatalThrowableError($e));
            }
        };
    };
}
```
  
then()方法实现具体来到array_reduce()  
array_reduce的执行逻辑可以追踪到carry()  
  
carry()函数的实现为闭包嵌套一层闭包，所以执行 =array_reduce()= 方法时，  
首先array_reduce()执行时运行carry()的外层闭包，将$pipe(中间件类名)保存在类似栈的结构中，  
  
  
  
这里从array_reduce()函数的角度执行来分析  
  
首先通过 =$this->carray()= 来执行 $this->pipes和$this->prepareDestination($destination),  
  
进一步分析可知具体执行的是 =$this->pipe= 的handle()方法，即目录  
Illuminate/Foundation/Http/Middleware/CheckForMaintenanceMode.php:45  
里的handle()方法，  
```
public function handle($request, Closure $next)
{
    ...
    return $next($request);
}
```
handle()中处理完中间件的具体逻辑后，返回 =$next($request)= ，  
  
所以以上array_reduce()的第一次循环可以理解为  
  
首先执行 =$this->prepareDestination($destination)= ，传入  
=$this->dispatchToRouter()=，  
到这里可以 知道，这里返回了一个传参$request的init闭包，具体实现暂且不深究。  
  
接着开始执行 =$this->carry()= ，对上面函数返回的init闭包和 =$this->pipe=  
的第一个值进行处理，返回Response对象；  
然后循环处理上一步返回的闭包和 =$this->pipe= 的第二个值，依次类推。  
  
这里需要注意，=$this->carry()= 的实现为两步，首先在父类中封装了两层闭包，  
然后在子类Illuminate\Routing\Pipeline中调用实现。  
（说个题外话，这里可以看出作者的设计思想，子类中即为客户端调用，父类为  
具体实现逻辑，实现代码的解耦。）  
  
array_reduce()执行完毕后，执行 =$pipeline($this->passable)= ，  
即通过array_reduce()返回的闭包传入request开始执行  
  
总结，通过以上方式，最终实现了这样的功能：  
通过carry()内部的 =$pipe->{$this->method}(...$parameters)= 方法实现了  
将handle()方法解耦到管道外面实现。  
  
可以这么理解，管道就是通过array_reduce()将处理request为response的闭包包塞入$stack,  
沿着中间件的管道依次通过处理。  
  
## $response->send();
设置头信息  
返回内容  
  
  
## From Apprentice To Artisan
 https://my.oschina.net/zgldh/blog/379461 Authentication 身份认证  
  
Illuminate/Contracts/Auth/UserProvider.php:12  接口  
Illuminate/Auth/DatabaseUserProvider.php:55 实现  
Illuminate/Auth/EloquentUserProvider.php:45 实现  
## laravel框架的思想
laravel中通过在容器中注册各种实例，  
然后通过各种模式组合实现功能  
  
laravel开发，通过各种服务开发  
服务可以通过工厂模式Manager和绑定bind 注册到laravel中  
  
授权auth的实现  
AuthManager生成SessionGuard  
 中注入EloquentUserProvider  
  
  
## Passport
Oauth2有几种验证模式，  
其中一种为客户端授权passport模式（个人命名的）：  
启动一个GuzzleHttp/Client发送POST请求，参数如下  
```
$http = new GuzzleHttp\Client;

$response = $http->post('http://your-app.com/oauth/token', [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => 'client-id',
        'client_secret' => 'client-secret',
        'username' => 'taylor@laravel.com',
        'password' => 'my-password',
        'scope' => '',
    ],
]);

return json_decode((string) $response->getBody(), true);
```
那么，在Passport组件中是怎么识别这种授权模式的呢？  
  
答案如下：  
```
    public function respondToAccessTokenRequest(ServerRequestInterface $request, ResponseInterface $response)
    {
        foreach ($this->enabledGrantTypes as $grantType) {
            // 通过can方法的具体实现来实现，（判断传参的参数password值）
            if ($grantType->canRespondToAccessTokenRequest($request)) {
                $tokenResponse = $grantType->respondToAccessTokenRequest(
                    $request,
                    $this->getResponseType(),
                    $this->grantTypeAccessTokenTTL[$grantType->getIdentifier()]
                );

                if ($tokenResponse instanceof ResponseTypeInterface) {
                    return $tokenResponse->generateHttpResponse($response);
                }
            }
        }

        throw OAuthServerException::unsupportedGrantType();
    }
```
代码位置 vendor/league/oauth2-server/src/AuthorizationServer.php:171  
  
## Model
### 分析Model的启动
构造函数如下：  
```
public function __construct(array $attributes = [])
{
    $this->bootIfNotBooted();

    // $this->original = $this->attributes
    $this->syncOriginal();

    // 批量赋值参数
    $this->fill($attributes);
}
```
  
现在依次开始分析，首先观察 =$this->bootIfNotBooted()= ，  
```
protected function bootIfNotBooted()
{
    if (! isset(static::$booted[static::class])) {
        static::$booted[static::class] = true;

        $this->fireModelEvent('booting', false);

        // 调用了 static::bootTraits()
        // 当Model的trait中含有BootTraitName()方法时执行
        // 比如App\Thread中含有trait RecordsActivity,
        // trait中含有bootRecordsActivity()方法时执行
        static::boot();

        $this->fireModelEvent('booted', false);
    }
}
```
其中 =boot()= 前后记录了事件的调用，当Model的 =static::$dispatcher= 存在时执行；  
这里有一个疑问，就是 =static::$dispatcher= 实例化Model的过程中已经存在了，具体是什么时候  
创建的呢。  
后来在查看数据库相关源码时，发现了:  
vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php:152  
```
    /**
     * Prepare the database connection instance.
     *
     * @param  \Illuminate\Database\Connection  $connection
     * @param  string  $type
     * @return \Illuminate\Database\Connection
     */
    protected function configure(Connection $connection, $type)
    {
        $connection = $this->setPdoForType($connection, $type);

        // First we'll set the fetch mode and a few other dependencies of the database
        // connection. This method basically just configures and prepares it to get
        // used by the application. Once we're finished we'll return it back out.
        if ($this->app->bound('events')) {
            $connection->setEventDispatcher($this->app['events']);
        }

        // Here we'll set a reconnector callback. This reconnector can be any callable
        // so we will set a Closure to reconnect from this manager with the name of
        // the connection, which will allow us to reconnect from the connections.
        $connection->setReconnector(function ($connection) {
            $this->reconnect($connection->getName());
        });

        return $connection;
    }
```
可以看到，当app容器中绑定了事件时，在DatabaseManager中，创建数据库连接时，执行了configure()方法，  
因为容器中已经绑定了events，所以在这里设置了EventDispatcher。  
  
总结：  
当使用Model时，  
如果使用trait，可以通过bootTraitName()来扩展  
在Model里也可以通过boot()方法来扩展  
### 在Model的boot()中注册事件方法
  
## DB
数据库连接  
vendor/laravel/framework/src/Illuminate/Database/Connectors/ConnectionFactory.php:265  
```
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if ($resolver = Connection::getResolver($driver)) {
            return $resolver($connection, $database, $prefix, $config);
        }

        switch ($driver) {
            case 'mysql':
                return new MySqlConnection($connection, $database, $prefix, $config);
...
    }
```
  
select() insert()等方法的具体实现  
vendor/laravel/framework/src/Illuminate/Database/Connection.php:314  
  
DB的 leftJoin() find() get()等方法实现  
vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php:459  
## Eloquent
find() first()等方法实现  
vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:277  
## Queue队列
查看SerializesModels  
__sleep()函数在序列化对象时进行预处理，返回可用于序列化的的属性  
  - 首先通过反射机制获取对象的属性，
  - 如果属性继承自QueueableCollection或QueueableEntity把值设置为ModelIdentifier
  - 最后在过滤掉静态的属性
  
序列化函数serialize(clone $job)实现地址  
