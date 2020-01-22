## 经验
## 内存超出
Fatal Error: Allowed Memory Size of 134217728 Bytes Exhausted  
在使用docker-compose时，如果.env的密码错误也会报这个错  
## 本地开发时不用php artisan serve
在用5.8自带的Auth组件开发login时，遇到一个问题，访问api/user路由，当加上'auth:api'中间件后，总是提示NotFound的问题，一直找不到原因。  
  
通过搜索，有人提示可能serve有bug，于是用PHP原生命令行启动服务后，发现登录后又再次访问了'/home'路由，原因找到了，这就是报错Notfound的原因。PHP原生启动命令会记录访问地址，所以方便排查。  
为什么会访问'/home'路由呢，原来是在 =LoginController= 里加了guest中间间，登录后会自动跳转到'/home'.  
  
所以建议使用 php -S localhost -t public  
laravel自带的serve命令启动后terminal没有url记录访问记录，不方便调试。  
  
## 安装类后找不到
当在项目中新建命名空间和类时  
执行  
```
composer dump-autoload
```
- http://developed.be/2014/08/29/composer-dump-autoload-laravel/
  
坑  
如果在测试环境开发  
需要确保版本代码一致  
  
## 500 无日志 lumen
```
chown -R 777 storage/
```
  
## lumen写文件时使用file_put_contents()函数不起作用
  
估计是lumen中做了限制  
  
参考  
- https://laracasts.com/discuss/channels/lumen/lumen-storage
- https://github.com/thephpleague/flysystem
  
语法  
use League\Flysystem\Filesystem;  
use League\Flysystem\Adapter\Local;  
  
        $adapter = new Local(__DIR__);  
        $filesystem = new Filesystem($adapter);  
        $response = $filesystem->write('cccc.txt', 'cccc');  
## 升级5.2到5.5
Declaration of App\Providers\EventServiceProvider::boot(Illuminate\Contracts\Events\Dispatcher $events) should be compatible with Illuminate\Foundation\Support\Providers\EventServiceProvider::boot()  
  
```
Laravel 5.2 EventServiceProvider example:

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
Laravel 5.3 EventServiceProvider example:

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
```
https://stackoverflow.com/questions/40935130/i-used-composer-to-upgrade-to-laravel-5-3-which-broke-it  
  
Declaration of App\Providers\RouteServiceProvider::boot(Illuminate\Routing\Router $router) should be compatible with Illuminate\Foundation\Support\Providers\RouteServiceProvider::boot()  
  
https://stackoverflow.com/questions/44788861/laravel-trait-illuminate-foundation-auth-authenticatesandregistersusers-not-f  
https://stackoverflow.com/questions/44789114/laravel-trait-method-guard-has-not-been-applied-because-there-are-collisions-w  
  
## bug 新建插入字段不成功
  fix 检查Model 的fill  
  
## 报错 =Call to undefined method Illuminate\View\Factory::getFirstLoop()= 处理
```
FatalThrowableError in 2154f392745gf102547be138a945a11b58e5649203.php line 2:
Call to undefined method Illuminate\View\Factory::getFirstLoop()
```
解决  
```
php artisan view:clear
```
  
## route路由访问不到排查
  
检查路由顺序是否正确  
=$router->get('adminuser/changeSelf',...=  
必须在 =$router->resource('adminuser', 'AdminUserController');= 前面  
  
## /welcome路由可以访问，其他路由Not Found
可能是没有启用伪静态规则  
  
apache  
开启apache2的rewrite模块  
```
sudo a2enmod rewrite

sudo vim /etc/apache2/apache2.conf
# 将其中的AllowOverride None 全部替换为 AllowOverride All：
```
  
nginx  
```
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```
## 显示不了视图
控制器可以显示已有的视图，但是无法显示新建的视图，报500服务器错误。  
  
给storage目录增加权限  
```
sudo chown -R www-data:www-data storage/
```
## .env连接redis配置后，改为file,关闭redis-server，测试时仍然每次提示redis连接失败
原因解析：  
配置文件缓存  
  
解决：  
```
php artisan config:clear
```
## 5.6版修改User Model位置为App/Models后使用不了原有的登录套件
在 =Auth\LoginController= 中添加方法  
```
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            return response()->json([
                'data' => $user->toArray(),
            ]);
        }

        return $this->sendFailedLoginResponse($request);
    }
```
curl访问接口  
```
curl -X POST http://apidemo.test/api/login \
    -H "Accept: application/json" \
    -H "Content-type: application/json" \
    -d "{\"email\": \"admin@laravelacademy.org\", \"password\": \"test123\" }"
```
报错  
```

{
    "message": "Class '\\App\\User' not found",
    "exception": "Symfony\\Component\\Debug\\Exception\\FatalThrowableError",
    "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Auth/EloquentUserProvider.php",
    "line": 154,
    "trace": [
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Auth/EloquentUserProvider.php",
            "line": 114,
            "function": "createModel",
            "class": "Illuminate\\Auth\\EloquentUserProvider",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Auth/SessionGuard.php",
            "line": 352,
            "function": "retrieveByCredentials",
            "class": "Illuminate\\Auth\\EloquentUserProvider",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php",
            "line": 79,
            "function": "attempt",
            "class": "Illuminate\\Auth\\SessionGuard",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/app/Http/Controllers/Auth/LoginController.php",
            "line": 47,
            "function": "attemptLogin",
            "class": "App\\Http\\Controllers\\Auth\\LoginController",
            "type": "->"
        },
        {
            "function": "login",
            "class": "App\\Http\\Controllers\\Auth\\LoginController",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Controller.php",
            "line": 54,
            "function": "call_user_func_array"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php",
            "line": 45,
            "function": "callAction",
            "class": "Illuminate\\Routing\\Controller",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Route.php",
            "line": 212,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\ControllerDispatcher",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Route.php",
            "line": 169,
            "function": "runController",
            "class": "Illuminate\\Routing\\Route",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Router.php",
            "line": 665,
            "function": "run",
            "class": "Illuminate\\Routing\\Route",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php",
            "line": 30,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/app/Http/Middleware/RedirectIfAuthenticated.php",
            "line": 24,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "App\\Http\\Middleware\\RedirectIfAuthenticated",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php",
            "line": 41,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Routing\\Middleware\\SubstituteBindings",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php",
            "line": 57,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Routing\\Middleware\\ThrottleRequests",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Router.php",
            "line": 667,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Router.php",
            "line": 642,
            "function": "runRouteWithinStack",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Router.php",
            "line": 608,
            "function": "runRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Router.php",
            "line": 597,
            "function": "dispatchToRoute",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php",
            "line": 176,
            "function": "dispatch",
            "class": "Illuminate\\Routing\\Router",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php",
            "line": 30,
            "function": "Illuminate\\Foundation\\Http\\{closure}",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/fideloper/proxy/src/TrustProxies.php",
            "line": 57,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Fideloper\\Proxy\\TrustProxies",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php",
            "line": 31,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php",
            "line": 27,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/CheckForMaintenanceMode.php",
            "line": 51,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
            "line": 151,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php",
            "line": 53,
            "function": "Illuminate\\Pipeline\\{closure}",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
            "line": 104,
            "function": "Illuminate\\Routing\\{closure}",
            "class": "Illuminate\\Routing\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php",
            "line": 151,
            "function": "then",
            "class": "Illuminate\\Pipeline\\Pipeline",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php",
            "line": 116,
            "function": "sendRequestThroughRouter",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        },
        {
            "file": "/var/www/laratice/public/index.php",
            "line": 55,
            "function": "handle",
            "class": "Illuminate\\Foundation\\Http\\Kernel",
            "type": "->"
        }
    ]
}
```
  
修改会原来的位置 =App\User= 解决。  
## 5.5版Curl api/register...时报 “Function not exist”
解决：  
```
Route::post('register', ['as'=>'register', 'use'=>'Auth\RegisterController@register']);

# use改为uses
```
## node install时报错
按最前面提示执行  
```
npm rebuild node-sass --force
```
解决  
## npm run watch报错Can't resolve 'vue-loader'
```
ERROR in ./resources/assets/js/app.js
Module not found: Error: Can't resolve 'vue-loader' in '/var/www/laratice'
 @ ./resources/assets/js/app.js 5:0-28

解决
因为vue-loader最近更新了最新版，你install的时候没有写版本号所以最新了，不兼容。
在package.json里把vue-loader的版本号改为^14.0.2即可（你的应该是15.*）
然后
npm install
```
  
## 执行php artisan jwt:generate时报错
Go to JWTGenerateCommand.php file located in vendor/tymon/src/Commands and paste this part of code  
public function handle() { $this->fire(); }  
- https://github.com/tymondesigns/jwt-auth/issues/1298
## 日志大量快速生成  Class 'Predis\Client' not found
解决思路：想想哪里启动了redis服务  
原因：supervsor未关闭，启动了redis服务  
执行：sudo supervisorctl stop laravel-worker:*  
  
## jwt登录后测试resfulapi laravel的认证报错
```
"message": "Type error: Argument 1 passed to Illuminate\\Auth\\SessionGuard::login() must be an instance of Illuminate\\Contracts\\Auth\\Authenticatable, string given, called in /var/www/laratice/vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php on line 35",
```
  
解决  
In your app/Model/User.php you can try:  
```
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends \Eloquent implements Authenticatable
{
use AuthenticableTrait;
```
- https://github.com/jenssegers/laravel-mongodb/issues/702
## Postman测试/api/register跳转不返回数据
用curl命令执行成功返回json格式  
```
curl -X POST http://laratice.cc/api/register     -H "Accept: application/json"     -H "Content-Type: application/json"     -d '{"name": "学院君", "email": "admin@laravelacademy.org", "password": "test123", "password_confirmation": "test123"}'
{"message":"The given data was invalid.","errors":{"email":["The email has already been taken."]}}
```
但用Postman测试页面跳转，返回空白页  
  
解决：  
Postman加请求头  
```
"Accept: application/json"
"Content-Type: application/json"
```
## 查看源码时，不小心动了wender中的文件，报错
BadMethodCallException  
Method Illuminate\Database\Query\Builder::getRelaztion does not exist.  
  
这里提示是Query/Buider文件中有错  
实际上是  
Eloquent/Builer这个文件中查看源码时不小心敲了字母，导致了语法错误  
  
可见提示的报错也不一定准确  
  
  
  
## 怎么查看interface的方法实现在哪里
当使用phpstorm ctrl+点击时发现方法的实现是一个接口，然后怎么找它的具体实现呢？  
这时可以ctrl点击interface名,然后在实现这个接口的类中在查找就可以了。  
## collection分页
    /**  
     * Gera a paginação dos itens de um array ou collection.  
     *  
     * @param array|Collection      $items  
     * @param int   $perPage  
     * @param int  $page  
     * @param array $options  
     *  
     * @return LengthAwarePaginator  
     */  
    public function paginate($items, $perPage = 15, $page = null, $options = [])  
    {  
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);  
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);  
        return new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);  
    }  
- https://gist.github.com/vluzrmos/3ce756322702331fdf2bf414fea27bcb
## collection 过滤
$paginator = $query->orderBy('updated_time', 'desc')  
            ->paginate(PageSizeHelper::getPageSize());
  
$list = $paginator;  
if ($account_dispose_status = array_get($param,'account_dispose_status')) {  
    $list = $paginator->getCollection()->filter(function ($value) use($param, $account_dispose_status) {  
        return $value->account_dispose_status == $account_dispose_status;  
    });  
}  
  
## 获取的模型怎么处理
  
$query = $this->select(['*'])->where('check_result', '<>','');  
$paginator = $query->orderBy('updated_time', 'desc')  
    ->paginate(PageSizeHelper::getPageSize());
  
$paginator->getCollection()->transform(function ($value) {  
//$value->dispose_status = $this->getAccountDisposeStatusAttribute();  
    return $value;  
});  
## 工具
Arr::wrap()  包裹给定的值字符串或空值为 数组  
  
Str::is('test*', 'test11') 验证字符串相等或匹配字符串  
  如  
  
  
## 数据库join连接
  
        $query = \DB::connection('mysql_pay')->table('trade');  
        $query->join('trade_params', 'trade_params.trade_id', '=', 'trade.id');  
        $query->select(  
            'trade_platform', 'business_type', 'trade_result_time', 'amount', 'trade_no',  
            'bank_card_account', 'bank_card_no', 'trade_desc','trade.created_time'  
