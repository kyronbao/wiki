## composer install时提示svn的权限不足
使用compoer update 可以，不报错
## composer安装laravel及初始化项目  
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
 sudo chmod 755 `find ./storage -type d`  
 sudo chmod 644 `find ./storage -type f`  
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

## yiisoft/yii2 2.0.25 requires bower-asset/inputmask ~3.2.2 | ~3.3.5 -> no matching package found.
  
通过在包原站中查找  
https://packagist.org/providers/bower-asset/inputmask?query=bower-asset%2Finputmask  
  
最后在composer.json中安装  
"yidas/yii2-bower-asset": "~2.0.5",  
安装原因，上面这个包包含了需要的bower-asset/inputmask 包  
  
  
## 当依赖PHP7.2而本地安装PHP7.1时，
执行 composer update 可以对依赖进行降级  
## 记录一次composer安装时依赖冲突的解决方法
开发lumen的api应用时，发现test组件不支持cookie，github上有人开发了lumen-testing包可以使用，但是只支持5.7版本，而开发时使用的时lumen5.8版本，怎么临时处理版本冲突？  
  
首先fork该仓库，然后修改composer.json包名，修改里面的依赖关系  
最后 composer update 安装才可以（composer require总是不成功，一直提示安装缓存的5.7的旧版本）  
## 管理命令
  
  
设置国内镜像  
```
composer config -g repos.packagist composer https://mirrors.cloud.tencent.com/composer/
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```
  
- 中国镜像地址还原成默认地址
```
composer config -g repo.packagist composer https://packagist.org
```
  
- [正确的 Composer 扩展包安装方法](https://learnku.com/laravel/t/1901/correct-method-for-installing-composer-expansion-pack)
答案是：使用 composer require 命令  
如果安装开发版 composer require --dev  
  
- https://overtrue.me/articles/2017/08/about-composer-version-constraint.html
- [怎么在开发和正式环境发布composer](https://stackoverflow.com/questions/21721495/how-to-deploy-correctly-when-using-composers-develop-production-switch)
正式环境使用  
```
composer.phar install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader
```
--no-dev保证不安装dev下的包
  
设置全局path  
打印路径：composer global config bin-dir --absolute  
```
vim ~/.bash_profile
export PATH=${PATH}:~/.composer/vendor/bin/
```
  
## 安装 composer
```
sudo wget https://dl.laravel-china.org/composer.phar -O /usr/local/bin/composer
sudo chmod a+x /usr/local/bin/composer
```
  
### 官方版安装
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
  
```
mv composer.phar /usr/local/bin/composer # 安装sudo权限的composer
sudo mv  /usr/local/bin/composer /usr/bin/  # 安装为当前用户的全局
```
  
## ubuntu版本composer的一个坑
  
在安装 [YunhanPHP/overview](https://github.com/YunhanPHP/overview/blob/master/init/new-project.md) (lumen的一个开发环境扩展) 时报错  
slince/composer-registry-manager 2.0.0 requires composer-plugin-api ^1.1 -> no matching package found  
查资料  
- https://github.com/composer/composer/issues/2324
了解到是由于linux发行版安装的composer的问题  
所以删除composer后基于官方版本安装  
  
## 参考
- https://learnku.com/laravel/composer Composer 中文镜像 / Packagist 中国全量镜像正式发布！
- https://getcomposer.org/doc/00-intro.md#globally
- https://github.com/YunhanPHP/overview/blob/master/init/init.md
  
  
