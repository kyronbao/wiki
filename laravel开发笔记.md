# 文档
Laravel 速查表　https://learnku.com/docs/laravel-cheatsheet/7.x

# 安装后设置

## 安装后设置权限
- https://stackoverflow.com/questions/30639174/how-to-set-up-file-permissions-for-laravel

cd ./laravel

sudo chown -R www-data:www-data 

sudo find ./ -type f -exec chmod 664 {} \;    
sudo find ./ -type d -exec chmod 775 {} \;

sudo usermod -a -G www-data qianyong


这两行感觉可以不运行
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

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
将其中的AllowOverride None 全部替换为 AllowOverride All：
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
## 500 无日志
```
chown -R 777 storage/
```
 

## composer安装laravel5.5时carbon提示 You can run ".\vendor\bin\upgrade-carbon" to get help
参考https://stackoverflow.com/questions/57408621/cannot-upgrade-carbon-1-to-carbon-2
add the following dependencies to your composer.json**:

{
  ...
  "require": {
    ...
    "kylekatarnls/laravel-carbon-2": "^1.0.0",
    "nesbot/carbon": "2.0.0-beta.2 as 1.25.0"
  }
  ...
}
then run:

composer update


# 组件
## laravel组件跨域处理 使用https://github.com/barryvdh/laravel-cors
这个组件基于https://github.com/asm89/stack-cors 使用
安装组件后，支持前端首先option请求，返回可用method, 然后前端再次发出请求的模式

# bug记录

## docker-compose .env配置错误:  Fatal Error: Allowed Memory Size of 134217728 Bytes Exhausted  
在使用docker-compose时，如果.env的密码错误也会报这个错  
## artisan文件bug: 访问api/user路由，当加上'auth:api'中间件后，总是提示NotFound
5.8自带的Auth组件开发login时，遇到一个问题，访问api/user路由，当加上'auth:api'中间件后，总是提示NotFound
在用5.8自带的Auth组件开发login时，遇到一个问题，访问api/user路由，当加上'auth:api'中间件后，总是提示NotFound的问题，一直找不到原因。  
  
通过搜索，有人提示可能serve有bug，于是用PHP原生命令行启动服务后，发现登录后又再次访问了'/home'路由，原因找到了，这就是报错Notfound的原因。PHP原生启动命令会记录访问地址，所以方便排查。  
为什么会访问'/home'路由呢，原来是在 =LoginController= 里加了guest中间间，登录后会自动跳转到'/home'.  
  
所以建议使用 php -S localhost -t public  
laravel自带的serve命令启动后terminal没有url记录访问记录，不方便调试。  
  
本地开发时建议不用php artisan serve

 
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
  

## 缓存未清理：Call to undefined method Illuminate\View\Factory::getFirstLoop()
```
FatalThrowableError in 2154f392745gf102547be138a945a11b58e5649203.php line 2:
Call to undefined method Illuminate\View\Factory::getFirstLoop()
```
解决  
```
php artisan view:clear
```
  



## 缓存未清理：.env连接redis配置后，改为file,关闭redis-server，测试时仍然每次提示redis连接失败
原因解析：  
配置文件缓存  
  
解决：  
```
php artisan config:clear
```

## npm install时报错
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
  

## supervsor未关闭: 日志大量快速生成  Class 'Predis\Client' not found
解决思路：想想哪里启动了redis服务  
原因：supervsor未关闭，启动了redis服务  
执行：sudo supervisorctl stop laravel-worker:*  
  
## jwt组件User的trait未配置：jwt登录后测试resfulapi laravel的认证报错
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
## postman未加请求报文：postman测试/api/register跳转不返回数据
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
## 误操作修改了源码：Builder::getRelaztion does not exist. 
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


  
## 数据库join连接
  
        $query = \DB::connection('mysql_pay')->table('trade');  
        $query->join('trade_params', 'trade_params.trade_id', '=', 'trade.id');  
        $query->select(  
            'trade_platform', 'business_type', 'trade_result_time', 'amount', 'trade_no',  
            'bank_card_account', 'bank_card_no', 'trade_desc','trade.created_time'  


