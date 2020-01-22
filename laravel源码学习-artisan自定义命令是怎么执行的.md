  
基于Laravel5.7版  
  
当在Laravel中创建好任务时，可以通过命令行来调用执行。比如  
```
php artisan mail:send
```
  
具体实现是怎样的呢？  
  
  
## 预先保存任务列表
在app中绑定kernel  
```
$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);
```
在artisan中解析  
```
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
```
  
kernel的具体实现如下  
```
public function __construct(Application $app, Dispatcher $events)
{
    if (! defined('ARTISAN_BINARY')) {
        define('ARTISAN_BINARY', 'artisan');
    }

    $this->app = $app;
    $this->events = $events;

    $this->app->booted(function () {
        $this->defineConsoleSchedule();
    });
}
```
  
这里defineConsoleSchedule()  
注册实例Schedule并解析执行  
## 注册实例Schedule并解析执行
Illuminate\Contracts\Console\Kernel中绑定了Schedule实例并解析执行  
```
protected function defineConsoleSchedule()
{
    $this->app->singleton(Schedule::class, function ($app) {
        return new Schedule;
    });

    $schedule = $this->app->make(Schedule::class);

    $this->schedule($schedule);
}
```
vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php:93  
  
如果需要自定义Laravel的实例，这里是一个很好的例子。  
## Schedule()方法的分析
App\Console\Kernel的Schedule()覆盖了父方法，功能为  
将命令保存到了Schedule类的events数组中  
  
例如  
```
$schedule->command('mail:send')->hourly();
```
把'mail:send'命令解析后保存到了Illuminate\Console\Scheduling\Schedule->event[]数组  
### 怎么解析执行命令语句的？
  
Application::formatCommandString($command)  
将mail:send解析为  
字符串 "'/usr/bin/php7.1' 'artisan' mail:send"  
  
vendor/laravel/framework/src/Illuminate/Console/Scheduling/Schedule.php:74  
### 任务周期的控制
  
比如$schedule->command('mail:send')->hourly()的->hourly()的是怎么实现的呢？  
  
通过解析将命令赋予Event的$expression = '* * * * *'属性。  
  
vendor/laravel/framework/src/Illuminate/Console/Scheduling/Event.php:14  
的Trait：ManagesFrequencies中  
  
至此，App\Console\Kernel中的执行步骤分析完毕  
## 加载Commands命令
查看Artisan里handle()的bootstrap()方法  
- 首先执行Laravel的一些初始化方法
- 然后执行commands()
  - 即App\Console\Kernel的commands()
```
protected function commands()
{
    $this->load(__DIR__.'/Commands');

    require base_path('routes/console.php');
}
```
## 将命令的实现闭包加载到Console\Application
查看load()  
  
首先将命令的实现闭包保存到Illuminate\Console\Application::$bootstrappers[]  
  
命令的具体实现闭包为 $artisan->resolve($command); 具体的实现在下一节分析  
```
Artisan::starting(function ($artisan) use ($command) {
                    $artisan->resolve($command);
                });
```
## 执行具体步骤
查看handle()的第二步骤  
$this->getArtisan()->run($input, $output)  
  
这里引用了Symfony的组件，封装了一层又一层，最后可以找到这里  
  
$statusCode = $this->execute($input, $output);  
  
vendor/symfony/console/Command/Command.php:255  
  
execute()方法的具体实现  
```
protected function execute(InputInterface $input, OutputInterface $output)
{
    return $this->laravel->call([$this, 'handle']);
}
```
vendor/laravel/framework/src/Illuminate/Console/Command.php:183  
  
