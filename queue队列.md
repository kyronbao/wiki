## Laravel
文档  
-laravelacademy
  - [5.1队列文档](http://laravelacademy.org/post/222.html)
  - [其他laravel版本队列相关文档](http://laravelacademy.org/?cat=1&s=%E9%98%9F%E5%88%97)
  - [Laravel 5.5 官方扩展包 —— 队列系统解决方案：Laravel Horizon](http://laravelacademy.org/post/8492.html)
- laravel-china
  - https://laravel-china.org/docs/laravel/5.7/queues/2286
文章  
- [Laravel Queue——消息队列任务与分发源码剖析](https://laravel-china.org/articles/7037/laravel-queue-analysis-of-message-queue-tasks-and-distribution-source-code)
- [Laravel 队列系列 —— 基于 Redis 实现任务队列的基本配置和使用](http://laravelacademy.org/post/2012.html)
  
其他  
- [Laravel事件系统实现登录日志的记录](https://www.shrimp6.com/2017/05/17/laravelshi-jian-xi-tong-shi-xian-deng-lu-ri-zhi-de-ji-lu/)
- https://github.com/php-enqueue/laravel-queue
  
### 测试流程
源码见laravel57  
  
开启supervisor  
开启redis  
  
查看测试效果  
- tail -f storage/logs/laravel.log
- 浏览器运行 http://laratice57.cc/send
### Supervisor安装和配置
- http://liyangliang.me/posts/2015/06/using-supervisor/
- http://supervisord.org/configuration.html
```
sudo apt-get install supervisor

sudo vim/etc/supervisor/conf.d/laravel-worker.conf
```
编辑内容如下  
```
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/kyronbao/laratice57/artisan queue:work redis --sleep=3 --tries=3
autostart=true
autorestart=true
user=kyronbao
numprocs=5
redirect_stderr=true
stdout_logfile=/home/kyronbao/laratice57/worker.log
```
备注：  
- numprocs=5，开启5个进程
- laravel5.7版 废弃了 --daemon选项
- user默认www-data
  
命令管理  
```
# Start all processes in a group
sudo supervisorctl start laravel-worker:*
# Reload the daemon’s configuration files, without add/remove (no restarts)
sudo supervisorctl reread
# Reload config and then add and remove as necessary (restarts programs)
sudo supervisorctl update
# sudo supervisorctl start laravel-worker:*
restart

# 启动服务端程序
sudo supervisord -c /etc/supervisor/supervisord.conf
# 进入shell客户端
sudo supervisorctl -c /etc/supervisor/supervisord.conf
# 可以执行restart laravel-worker:*等命令
```
备注：  
- supervisord 命令会占用端口，重启时需要先杀死原来的进程
- restart 命令不会重新读取新的配置文件
- 修改配置文件后重启执行update命令生效
  
  
查看日志  
```
tail -f /var/log/supervisor/supervisord.log
tail -f /home/kyronbao/laratice57/worker.log
```
  
测试  
  
测试  
### 5.1版实践的一些坑
控制器中可以使用dispatch()方法来发布任务，来自Controller的ispatchesJobs Trait  
```
$this->dispatch(new SendReminderEmail($user));
```
如果其他地方使用的话可以引用  
  
启动任务推荐使用 =queue:work --daemon= ，不用 =listen= ，参考 [一个Laravel队列引发的报警](https://huoding.com/2015/06/10/444)  
  
默认队列分类为 =default= ，如果设置为 =emails= ，  
```
public function sendReminderEmail(Request $request, $id)
{
    $user = User::findOrFail($id);
    $job = (new SendReminderEmail($user))->onQueue('emails');
    $this->dispatch($job);
}
```
开启任务时执行  
```
sudo php artisan queue:work --daemon  --queue=emails
```
  
## Laravel RabbitMQ
### Ubuntu16.04 安装默认版RabbitMQ
  
```
sudo apt-get install erlang-nox
```
  
Signing Key  
In order to use the repository, add RabbitMQ signing key to apt-key:  
  
apt-key adv --keyserver "hkps.pool.sks-keyservers.net" --recv-keys "0x6B73A36E6026DFCA"  
  
```
wget -O - "https://github.com/rabbitmq/signing-keys/releases/download/2.0/rabbitmq-release-signing-key.asc" | sudo apt-key add -
```
  
```
sudo apt-get install rabbitmq-server
```
  
启用 RabbitMQ web 管理插件  
```
sudo rabbitmq-plugins enable rabbitmq_management
```
  
重启服务器  
  
```
sudo systemctl restart rabbitmq-server
```
安装好 rabbitmq 之后，在 /etc/rabbitmq 目录下面默认没有配置文件，需要单独下载，可以到[这里下载](https://github.com/rabbitmq/rabbitmq-server/blob/master/docs/rabbitmq.conf.example)。  
  
下载之后，重命名为 rabbitmq.config，接着找到有 loopback_users的地方，去掉注释，修改为这样，注意！后面没有逗号！  
{loopback_users, []}  
  
把修改好的 rabbitmq.config 文件放到/etc/rabbitmq 目录下面。  
  
接着重启服务器  
  
```
sudo systemctl restart rabbitmq-server
```
  
参考 https://blog.csdn.net/nextyu/article/details/79250174  
常用命令  
这里有些概念需要明确一下，当启动 rabbitmq 之后，其实是启动了一个 Erlang 节点，然后 rabbitmq 作为应用程序运行在 Erlang 节点之上。通过下面命令的参数，也能反映出来这些差别。  
  
关闭 rabbitmq （但是没有关闭节点）  
  
```
rabbitmqctl stop_app
```
启动 rabbitmq  
```
rabbitmqctl start_app
```
关闭 rabbitmq 以及节点  
```
rabbitmqctl stop
```
由于上面的命令把 rabbitmq 以及节点都关闭了，所以要使用如下命令启动 rabbitmq，-detached 参数表示以守护程序的方式在后台运行  
  
```
rabbitmq-server -detached
```
  
### Laravel 配置
安装依赖  
```
sudo apt install php7.2-bcmath
composer require php-amqplib/php-amqplib
composer require enqueue/amqp-lib
composer require vladimir-yuldashev/laravel-queue-rabbitmq
```
  
启用bcmath模块  
```
sudo phpenmod -v 7.2 bcmath
sudo systemctl restart php7.2-fpm.service
```
  
报错调试  
PhpAmqpLib\Wire\bcadd()未找到  
需要启用bcmath模块  
### 在测试服务器停止rabbitmq
```
sudo sysv-rc-conf
sudo ps -ef|grep rabbitmq |grep -v grep|cut -c 11-15|xargs sudo kill -9
```
### 参考
- [laravel5 rabbitmq使用测试](https://www.phpsong.com/3163.html)
- [Laravel 使用 RabbitMQ 消息队列消费邮件](https://blog.csdn.net/qq_36431213/article/details/82778427?utm_source=blogxgwz1)
- [RabbitMQ 从入门到放弃系列笔记](https://laravelacademy.org/post/7401.html)
- [我为什么要选择RabbitMQ - yufeng.info](https://www.slidestalk.com/s/rabbitmq_yufeng_info_j2wmbk) @淘宝褚霸
- [到底什么时候该使用MQ？](http://blog.p2hp.com/archives/4368)
### 其他
