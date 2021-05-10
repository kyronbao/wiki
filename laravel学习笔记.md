## 学习资料
进阶  
- https://laravel-news.com/ 最新情报
- [Laravel - 从百草园到三味书屋 "From Apprentice To Artisan"目录](https://my.oschina.net/zgldh/blog/389246) Laravel作者贡献，感谢翻译
  
- http://www.laravelbestpractices.com/
  
项目  
- https://github.com/bitnami/bitnami-docker-laravel 部署laravel到Kubernetes?
  
 入门  
- http://laravelacademy.org
- [Laravel 5.1 中文文档](http://laravelacademy.org/laravel-docs-5_1)
- [Laravel 5.1 基础教程](http://laravelacademy.org/laravel-tutorial-5_1)
- https://laravel.com/docs/5.1
- https://laravel.com/api/5.6/
书籍推荐  
- [[https://www.quora.com/Which-is-the-best-book-for-laravel]]
- [[https://michaelbrooks.co.uk/top-5-laravel-books/]]
- [[https://www.onlinebooksreview.com/articles/best-10-books-to-learn-laravel-5-and-building-practical-applications]]
 博客  
- http://blog.ifeeline.com/
 巨多资源  
- [Laravel 精选资源大全（持续更新）](http://laravelacademy.org/post/153.html)
 扩展  
- https://juejin.im/post/59eb585451882542f03849d1 laravel-admin
文章  
- [Laravel 如何设计微服务架构，及如何进行微服务间沟通？](https://laravel-china.org/topics/9199/how-does-laravel-design-a-microservice-architecture-and-how-to-communicate-between-microservices)
- [ Laravel 的中大型專案架構](https://oomusou.io/laravel/architecture/)
- [Laravel 中的 Pipeline — 管道设计范式](https://laravel-china.org/topics/7543/pipeline-pipeline-design-paradigm-in-laravel)
- [管道模式原理](https://laravel-china.org/articles/5206/the-use-of-php-built-in-function-array-reduce-in-laravel)
- https://leoyang90.gitbooks.io/laravel-source-analysis/content/ 源码分析
- [Laravel Queue——消息队列任务与分发源码剖析](https://laravel-china.org/articles/7037/laravel-queue-analysis-of-message-queue-tasks-and-distribution-source-code)
- [How to Create a Custom Authentication Guard in Laravel](https://code.tutsplus.com/tutorials/how-to-create-a-custom-authentication-guard-in-laravel--cms-29667)
缓存  
- https://github.com/spatie/laravel-responsecache Speed up a Laravel app by caching the entire response
- [Speed up a Laravel app by caching the entire response](https://murze.be/speed-up-a-laravel-app-by-caching-the-entire-response)
  
[Creating a Caching User Provider for Laravel](https://matthewdaly.co.uk/blog/2018/01/12/creating-a-caching-user-provider-for-laravel/)  
  
[laravel model caching](https://laravel-news.com/laravel-model-caching)  
  
[Caching in Laravel with Speed Comparisons](https://scotch.io/tutorials/caching-in-laravel-with-speed-comparisons#responses-without-cache)  
  
[Larave + Cache](https://medium.com/@ricardoruwer/laravel-cache-d9f4eae29ac1)  
  

## 使用Lumen还是Laravel?
Lumen是Laravel的轻量级框架，那么开发Api使用Laravel还是Lumen呢？  
  
最近做个项目，打算提供前端页面和后台管理的API，后台使用Cookie管理状态，使用Lumen了搭建了一波。说一下遇到的问题，Lumen测试组件不支持Cookie测试，于是使用了 [lumen-testing](https://github.com/albertcht/lumen-testing) 代替了，然后使用sqlite内存测试时，需要创建Migration表来支持测试，然后呢，使用不了 =Use DatabaseMigrations= ...，折腾...  
  
那么开发API到底该选用Lumen还是Laravel呢？  
  
参考了下  
- https://laracasts.com/discuss/channels/general-discussion/lumen-or-laravel-for-big-apis
- https://www.quora.com/Is-it-good-to-use-Laravel-for-API-development
  
总结：  
- 当你要使用的包Lumen没有时，使用Laravel
- 如果开发的项目较大，需求不太确定，用Laravel
- 如果需求确定，只提供少量API服务，选Lumen，所以才称为轻量级
- 如果从性能纠结，PHP也有其他更快的框架服务选择的
  
## Scope
Scope([查询作用域](http://laravelacademy.org/post/138.html))，可以在模型层封装部分条件，在控制层可以实现复用。  

## Repository 仓库模式
Repository Pattern仓库模式在模型层和控制层中间，通过将模型注入仓库，优点有：  
- 可以通过Repository封装一个基类，增加模型层的公共方法，方便复用；
- 多个模型交互，可以一起注入一个仓库，在仓库中编写部分逻辑，实现代码分离；
- 仓库可以定义契约接口，面向接口编程。
  
参考  
- [为什么要学习Repository Pattern(仓库模式)](https://segmentfault.com/a/1190000004875930) 解释了仓库模式的作用
- [[http://farll.com/2014/09/php-design-pattern-repository/]] 实现了MemoryStorage和Post数据映射层之间的Repository的PHP代码实例，代码的分层思想感觉有点乱。
- [Laravel 5 中使用仓库(Repository)模式](https://github.com/lanceWan/INote/blob/master/Laravel/Laravel%205%20%E4%B8%AD%E4%BD%BF%E7%94%A8%E4%BB%93%E5%BA%93(Repository)%E6%A8%A1%E5%BC%8F.md) 言简意赅
- https://github.com/andersao/l5-repository Laravel5的仓库组件 [官网](http://andersonandra.de/l5-repository/)

## 测试
Laravel5.1测试  
Laravel自带了测试程序，测试案例的运行：  
```
./vender/bin/phpunit
```
坑：Ubuntu下安装phpunit后，运行会报错。不必自己安装phpunit。  
  
测试驱动开发的优点  
对开发中需要频繁验证的步骤建立测试可以提高效率；  
当项目越来越大时，良好测试覆盖的项目保证了重构时的编程的可靠性；  
  
个人对测试实践的理解：  
对需要重构的项目尽可能的覆盖测试；  

## 错误日志 
```
// app/Exceptions/Handler.php:18
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];
```
通过 =User::find(100)= 会打印并记录日志；  
通过 =User::findorfailed(100)= 不记录日志，只在视图显示日志，因为返回 =ModelNotFoundException= 。  
  
示例代码  
```
use Log;

Log::info('Showing user profile for user: '.$user->name);
Log::info('User login info:', ['id' => $user->id, 'name' => $user->name]);

Log::emergency($error);
Log::alert($error);
Log::critical($error);
Log::error($error);
Log::warning($error);
Log::notice($error);
Log::info($error);
Log::debug($error);

abort(404, '未找到。。。');
```
## 缓存
  
### 文章详情页缓存简单实现
参考 [[http://laravelacademy.org/post/1688.html]]  
  
获取文章详情时首先查询缓存，没有命中时，在数据库中查找，具体实现见PostCachedController，  
片段如下：  
```
if(!$post){
    $post = Post::find($id);
    if(!$post)
        exit('指定文章不存在！');
    Cache::put('post_'.$id,$post,60*24*7);
}

if(!Cache::get('post_views_'.$id))
    Cache::forever('post_views_'.$id,0);
$views = Cache::increment('post_views_'.$id);
Cache::forever('post_views_'.$id,$views);
```
  
在保存文章和删除文章时对缓存更新，可以在AppServiceProvider的boot方法加入：  
```
//保存之后更新缓存数据
Post::saved(function($post){
    $cacheKey = 'post_'.$post->id;
    $cacheData = Cache::get($cacheKey);
    if(!$cacheData){
        Cache::add($cacheKey,$post,60*24*7);
    }else{
        Cache::put($cacheKey,$post,60*24*7);
    }
});

//删除之后清除缓存数据
Post::deleted(function($post){
    $cacheKey = 'post_'.$post->id;
    $cacheData = Cache::get($cacheKey);
    if($cacheData){
        Cache::forget($cacheKey);
    }
    if(Cache::get('post_views_'.$post->id))
        Cache::forget('post_views_'.$post->id);
});
```
  

## 用户认证  
参考文档  
- https://laravel-china.org/docs/laravel/5.6/authentication/1379
- [用户认证](http://laravelacademy.org/post/163.html)
 5.6  
首先 php artisan make:auth  
  
在路由文件web.php中创建了Auth::routes();  
查看Auth中源码  
```
public static function routes()
{
    static::$app->make('router')->auth();
}
```
  
具体实现可见Illuminate/Routing/Router.php:1129  
```
/**
 * Register the typical authentication routes for an application.
 *
 * @return void
 */
public function auth()
{
    // Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    $this->post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');
}
```
  
```
protected function attemptLogin(Request $request)
{
    return $this->guard()->attempt(
        $this->credentials($request), $request->filled('remember')
    );
}
```
  
追踪 =$this->guard()=  
vendor/laravel/framework/src/Illuminate/Auth/AuthManager.php:118  
```
/**
 * Create a session based authentication guard.
 *
 * @param  string  $name
 * @param  array  $config
 * @return \Illuminate\Auth\SessionGuard
 */
public function createSessionDriver($name, $config)
{
    $provider = $this->createUserProvider($config['provider'] ?? null);

    $guard = new SessionGuard($name, $provider, $this->app['session.store']);

    // When using the remember me functionality of the authentication services we
    // will need to be set the encryption instance of the guard, which allows
    // secure, encrypted cookie values to get generated for those cookies.
    if (method_exists($guard, 'setCookieJar')) {
        $guard->setCookieJar($this->app['cookie']);
    }

    if (method_exists($guard, 'setDispatcher')) {
        $guard->setDispatcher($this->app['events']);
    }

    if (method_exists($guard, 'setRequest')) {
        $guard->setRequest($this->app->refresh('request', $guard, 'setRequest'));
    }

    return $guard;
}
```
  
  
vendor/laravel/framework/src/Illuminate/Auth/CreatesUserProviders.php:79  
```
protected function createEloquentProvider($config)
{
    return new EloquentUserProvider($this->app['hash'], $config['model']);
}
```
其中 $request->filled('remember')  
检查请求字段是否包含remember  
  
vendor/laravel/framework/src/Illuminate/Auth/SessionGuard.php:347  
```
    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array  $credentials
     * @param  bool   $remember
     * @return bool
     */
    public function attempt(array $credentials = [], $remember = false)
    {
        $this->fireAttemptEvent($credentials, $remember);

        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

        // If an implementation of UserInterface was returned, we'll ask the provider
        // to validate the user against the given credentials, and if they are in
        // fact valid we'll log the users into the application and return true.
        if ($this->hasValidCredentials($user, $credentials)) {
            $this->login($user, $remember);

            return true;
        }

        // If the authentication attempt fails we will fire an event so that the user
        // may be notified of any suspicious attempts to access their account from
        // an unrecognized user. A developer may listen to this event as needed.
        $this->fireFailedEvent($user, $credentials);

        return false;
    }
```
  
  
 5.1版实践  
注：Laravel 5.2后可以用php artisan make:auth来构建，很便捷。  
  
### 跳转没有效果问题记录
$redirectPath  
作用是登录成功后跳转路由，在AuthController中设置$redirectPath后，经过测试，  
并没有实际的效果。  
  
登录跳转相关知识点  
未登录用户访问未授权页面，在auth中间件Authenticate中设置。  
  
### 手动认证用户
因为Laravel自带的登录后跳转不太灵光，在AuthController手动实现：  
```
    /**
     * 自定义处理登录认证逻辑
     *
     * @return Response
     */
    public function postLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        if (\Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            // 重定向到登录之前用户想要访问的URL，在目标URL无效的情况下备用URI将会传递给该方法
            return redirect()->intended('/user/profile');
        }

        return redirect()->route('login');
    }
```
注意：  
使用了Auth门面；  
登录页面路由使用了重命名as：  
```
Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
```
  
### 记住用户 上例代码中前端传过来的$remember为On/false，待研究。
  
  
### 重置密码
参考  
[实例教程 —— 使用Laravel内置组件快速实现密码重置](http://laravelacademy.org/post/1290.html)  
  
调试记录  
#### 点击发送重置邮件后无反应
排查是否已注册过该邮箱  
  
#### 报错无法连接主机mailtrap.io，如下：
```
Swift_TransportException in StreamBuffer.php line 268: Connection could not be established with host mailtrap.io
```
检查.env、config/email.php都已修改相关host值，google后，发现是配置缓存问题：  
https://stackoverflow.com/questions/42829812/swift-transportexception-in-streambuffer-php-line-268  
解决  
```
php artisan config:clear
```
注意还需要重启web服务器  
  
#### 报错Expected response code 250 but got code "554"
具体报错:  
```
Swift_TransportException in AbstractSmtpTransport.php line 383:
Expected response code 250 but got code "554", with message "554 DT:SPM 126 smtp5,jtKowAAnI4CgTxpbogAOAA--.26S2 1528450981,please see http://mail.163.com/help/help_spam_16.htm?ip=112.97.59.183&hostid=smtp5&time=1528450981
```
进入提示连接排查，504指邮件是垃圾邮件或不合法，是网易的服务器限制了  
  
解决方法：  
使用收费邮箱或自建邮箱服务器  
  
### 社会化登录认证
参考：  
- [实例教程 —— 使用Socialite实现GitHub登录认证](http://laravelacademy.org/post/1305.html)
- [社交媒体登录认证提供者大全 —— Socialite Providers，支持微博、微信、QQ等](http://laravelacademy.org/post/1321.html)
```
composer require laravel/socialite
```
发现最新版本的组件需php ^7.1.3的支持，待以后测试  
  
  
  
实践参考  
- https://www.jb51.net/article/130036.htm Laravel5.5中利用Passport实现Auth认证的方法
- https://www.jb51.net/article/121401.htm Laravel中的Auth模块详解(基于5.4版)
- https://segmentfault.com/a/1190000012509079 Laravel5.5 基于内置的Auth实现前后台登陆


## 消息通知 
打印 app('Illuminate\Contracts\Notifications\Dispatcher')可知为对象 ChannelManger  
位于  
vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php:30  
  
默认驱动为  
```
protected function createDatabaseDriver()
{
    return $this->app->make(Channels\DatabaseChannel::class);
}
```
  
具体实现  
vendor/laravel/framework/src/Illuminate/Notifications/Channels/DatabaseChannel.php:53  
```
protected function buildPayload($notifiable, Notification $notification)
{
    return [
        'id' => $notification->id,
        'type' => get_class($notification),
        'data' => $this->getData($notifiable, $notification),
        'read_at' => null,
    ];
}
```

## 压力测试  
 ab -c100 -n1000 http://laratice.cc/post/1  
```

This is ApacheBench, Version 2.3 <$Revision: 1706008 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking laratice.cc (be patient)
Completed 100 requests
Completed 200 requests
Completed 300 requests
Completed 400 requests
Completed 500 requests
Completed 600 requests
Completed 700 requests
Completed 800 requests
Completed 900 requests
Completed 1000 requests
Finished 1000 requests


Server Software:        nginx/1.10.3
Server Hostname:        laratice.cc
Server Port:            80

Document Path:          /post/1
Document Length:        201 bytes

Concurrency Level:      100
Time taken for tests:   5.042 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      1164012 bytes
HTML transferred:       201000 bytes
Requests per second:    198.34 [#/sec] (mean)
Time per request:       504.190 [ms] (mean)
Time per request:       5.042 [ms] (mean, across all concurrent requests)
Transfer rate:          225.46 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.6      0       3
Processing:    14  479  87.2    496     623
Waiting:       14  479  87.2    496     623
Total:         17  479  86.7    496     623

Percentage of the requests served within a certain time (ms)
  50%    496
  66%    507
  75%    513
  80%    517
  90%    538
  95%    562
  98%    574
  99%    581
 100%    623 (longest request)
```
## 框架和业务结构的设计例子－用户登录注册
用户注册完成后代码：  
```
return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
```
vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php:37  
注：这里用到一个PHP三元运算的简化语法。  
  
注册成功后预留给客户端一个方法registered()，可以留给业务端中实现具体逻辑，如果没有实现的话则跳转。  
  
举个例子，在控制器实现注册后保存token，返回用户json数据：  
```
protected function registered(Request $request, $user)
{
    $user->generateToken();

    return response()->json(['data' => $user->toArray()], 201);
}
```
## 任务调度 
- https://laravel-china.org/docs/laravel/5.7/scheduling/2287
- [How to create and monitor scheduled tasks in Laravel applications](https://medium.com/@tik/how-to-create-and-monitor-scheduled-tasks-in-laravel-applications-784d4f7f8084)
  - 怎么在laravel创建任务，介绍了作者个人管理调度的一个项目
- [crontab](https://linuxtools-rst.readthedocs.io/zh_CN/latest/tool/crontab.html)
  
任务调度可以执行一些按计划定期执行的任务  
优点  
  - 命令行方便启动
  - 代码易管理
  
源码见 laratice57  
  
创建任务  
```
php artisan make:command SendMail
```
在app/Console/Commands 下会创建任务文件  
  
修改  
```
    protected $signature = 'mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '邮箱发送测试';
```
此时执行  
```
php artisan list
```
可以发现 mail:send  
  
然后在handle()方法中写可能批量执行的逻辑  
  
crontab管理  
查看  
```
sudo crontab -l
```
编辑  
```
sudo crontab -e
```
管理  
```
sudo /etc/init.d/cron start|restart|stop
```
  
打印cron日志  
```
sudo cron -e
```
* * * * * php /home/kyronbao/laravel57/artisan schedule:run >> /home/kyronbao/cron-laravel.log  
日志查看  
tail -f /var/log/cron.log  
tail -f /home/kyronbao/cron-laravel.log  
tail -f laravel.log  
  
需要注意事项  
- 当任务没有执行时，需要打印cron日志查看
- artisan需要有执行权限
  

## debug调试利器使用
Laravel 5.5安装  
```
composer require barryvdh/laravel-debugbar --dev
```
安装完刷新页面就ok了  
  
复制配置文件  
```
php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
```
  
打印  
```
debug($arr, $str);
```
  
测试一段程序消耗时间  
```
start_measure('render','Time for rendering');
    //...
stop_measure('render');
```
or  
```
Debugbar::measure('My long operation', function() {
    // Do something…
});
```
使用第二种时间测试更精确些  
  
Laravel开始到现在消耗实践  
```
Debugbar::addMeasure('now', LARAVEL_START, microtime(true));
```
  
参考  
- https://github.com/barryvdh/laravel-debugbar

## Eloquent ORM
  
实践了以下功能  
HTTP 路由、HTTP 控制器、迁移、填充数据、关联关系  
  
通过Eloquent ORM的关联关系功能实现了数据库映射的功能，具体有  
一对一：User和UserAccount一一对应  
一对多：User一对多Post/Post一对多Comment  
```
这里提一下怎么记忆hasMany(), belongsTo()里面的id foreignKey
举例来说，
order
id, name   表中没有order_id, 使用hasMany(OrderDetail, order_id)
order_detail
id, order_id  表中含有order_id，使用belongsTo(Order, order_id)
```
  
多对多：Role可以有多个User，同时User也可以有多个Role，通过中间表role_user关联  
远层一对多：Country一对多User，User下一对多Post  
多态关联：比如文章、视频和评论的关系，Post可以有多个Comment，Vidoe也可以有多个Comment，  
- Comment的数据都保存在comments表中，含有item_id、item_type(数据格式App\Models\Post)来实现和Post、Video的映射关系
多对多多态关联：比如文章、视频和标签的关系，Post多对多Tag，Video也多对多Tag，通过中间表taggable实现，  
具体字段为taggable_id,taggable_type(数据格式App\Models\Post),tag_id  
  
另外也实践了渴求式加载、save()、create()、associate()、attach()方法  
  
参考资料  
[[ Laravel 5.1 文档 ] Eloquent ORM —— 关联关系](http://laravelacademy.org/post/140.html#polymorphic-relations])  
[实例教程 —— 关联关系及其在模型中的定义（一）](http://laravelacademy.org/post/1095.html)  
[实例教程 —— 关联关系及其在模型中的定义（二）](http://laravelacademy.org/post/1174.html)  
  
## 访问器 & 修改器
预处理数据，可以在显示和保存数据时处理数据  
例如：用户名first_name的大小写处理，金钱数据的处理等  
密码预处理的demo  
  
    public function setPasswordAttribute($value){  
        $this->attributes['password']=Hash::make($value);  
    }  
  
## 日期修改器
定义模型的日期字段，日期属性可以使用Carbon的方法  
  
    $user->disabled_at->getTimestamp()  
  
## 数组转化
模型的属性可以保存为json,打印显示为array  
例如：示例Post模型的addition属性，图片的附加参数，有些模型可能会有很多附加参数，  
但没必要每个字段都在数据库中保存，可以通过json格式保存  
  
## 序列化
由于模型和集合在转化为字符串的时候会被转化为JSON，你可以从应用的路由或控制器中直接返回Eloquent对象  
  
    $user = User::with('roles')->first();  
    var_dump($user->toArray());  // array  
    var_dump($user->toJson());   // string  
    return $user;                // json  
  
    $users = User::all();  
    var_dump($users->toArray()); // array  
    var_dump($users->toJson());  // string  
    return $users;               // json  
  

