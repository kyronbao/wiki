  
下载安装  
```
composer create-project laravel/laravel laravel-my --prefer-dist "5.6.*"
# 注：有dist和source两种安装方式，dist是强制使用压缩包，而source是使用源代码安装，如果是想从source安装，那么可以改成--prefer--source
composer require "maatwebsite/excel": "~2.1.0"
```
  
如果用使用chrome的Proxy SwitchyOmega，设置为direct或自动切换  
https://blog.csdn.net/qq_36428171/article/details/81209475  
初始化项目  
编写.env  
```
composer dump-autoload
php artisan key:genarate
# 调试时无法显示视图，修改storage目录权限
sudo chown -R www-data:www-data storage/
# 日志目录增加写权限
sudo chmod -R u+w storage/logs/
```
修改storage权限  
参考 https://stackoverflow.com/questions/30639174/how-to-set-up-file-permissions-for-laravel-5-and-others  
# sudo chmod 755 `find ./storage -type d`  
# sudo chmod 644 `find ./storage -type f`  
```
sudo chown -R www-data:www-data storage/
sudo usermod -a -G www-data:ubuntu ./storage
```
数据迁移  
```
php artisan migrate
```
  
取消database/seeds/DatabaseSeeder的run()中添加  
```
        factory('App\User')->create([
            'name' => 'KenyonBao',
            'email' => 'KenyonBao@qq.com',
            'password' => bcrypt('123456'),
        ]);
```
```
php artisan db:seed
```
  
加载默认用户验证系统  
```
php artisan make:auth
```
  
调试记录  
- 页面不显示，error.log没报错，laravel.log无消息
    - 检查chrome代理
  
  
安装laravel智能提示插件barryvdh/laravel-ide-helper  
坑  
  - 运行php artisan ide-helper:generate时报错
    - In Alias.php line 69:
    - Class App does not exist
