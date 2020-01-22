  
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
  
