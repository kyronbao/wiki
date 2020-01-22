  
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
