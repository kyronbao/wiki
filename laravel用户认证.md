  
参考文档  
- https://laravel-china.org/docs/laravel/5.6/authentication/1379
- [用户认证](http://laravelacademy.org/post/163.html)
* 5.6  
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
  
  
* 5.1版实践  
注：Laravel 5.2后可以用php artisan make:auth来构建，很便捷。  
  
## 跳转没有效果问题记录
$redirectPath  
作用是登录成功后跳转路由，在AuthController中设置$redirectPath后，经过测试，  
并没有实际的效果。  
  
登录跳转相关知识点  
未登录用户访问未授权页面，在auth中间件Authenticate中设置。  
  
## 手动认证用户
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
  
## 记住用户 上例代码中前端传过来的$remember为On/false，待研究。
  
  
## 重置密码
参考  
[实例教程 —— 使用Laravel内置组件快速实现密码重置](http://laravelacademy.org/post/1290.html)  
  
调试记录  
### 点击发送重置邮件后无反应
排查是否已注册过该邮箱  
  
### 报错无法连接主机mailtrap.io，如下：
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
  
### 报错Expected response code 250 but got code "554"
具体报错:  
```
Swift_TransportException in AbstractSmtpTransport.php line 383:
Expected response code 250 but got code "554", with message "554 DT:SPM 126 smtp5,jtKowAAnI4CgTxpbogAOAA--.26S2 1528450981,please see http://mail.163.com/help/help_spam_16.htm?ip=112.97.59.183&hostid=smtp5&time=1528450981
```
进入提示连接排查，504指邮件是垃圾邮件或不合法，是网易的服务器限制了  
  
解决方法：  
使用收费邮箱或自建邮箱服务器  
  
## 社会化登录认证
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
