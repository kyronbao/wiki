  
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
