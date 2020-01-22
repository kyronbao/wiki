
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
