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
