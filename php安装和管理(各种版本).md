## debian9/deepin15.11安装源  
配置源  
  
```
sudo apt install apt-transport-https ca-certificates
wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
sudo sh -c 'echo "deb https://packages.sury.org/php/ stretch main" > /etc/apt/sources.list.d/php.list'
```
  
```
sudo apt update (重要，不然安装不了php7.1)
sudo apt install php7.1 （重要,不然安装不了php7.1-gd）
```
  
其他参考Ubuntu16.04安装  

Archlinux  
## 卸载PHP7.3
查看已安装PHP和扩展  
```
pacman -Qs php
```
输出如下  
```
local/composer 1.8.6-1
    Dependency Manager for PHP
local/php 7.3.7-2
    A general-purpose scripting language that is especially suited to web
    development
local/php-fpm 7.3.7-2
    FastCGI Process Manager for PHP
local/php-gd 7.3.7-2
    gd module for PHP
local/php-grpc 1.22.0-1
    High performance, open source, general RPC framework that puts mobile and
    HTTP/2 first.
local/php-pear 1:1.10.15-1
    PHP Extension and Application Repository
local/phpmyadmin 4.9.0.1-1
    PHP and hence web-based tool to administrate MySQL over the WWW
```
卸载扩展和PHP  
```
sudo pacman -Rs php-fpm php-gd php-grpc php-pear
sudo pacman -Rs composer phpmyadmin
```
  
## 安装php7.1
安装原因(由于Yii2版本依赖的问题)  
```
PHP Fatal error:  Cannot use 'Object' as class name as it is reserved in /home/kyron/demos/demo-yii-shop/vendor/yiisoft/yii2/base/Object.php on line 77
```
```
git clone https://aur.archlinux.org/php71.git
```
  
进入目录，首先添加签名（参考https://aur.archlinux.org/packages/php71/）  
```
gpg --recv-keys A917B1ECDA84AEC2B568FED6F50ABC807BD5DCD0 528995BFEDFBA7191D46839EF9BA0ADA31CBD89E 1729F83938DA44E27BA0F4D3DBDB397470D12172

makepkg -si
```
安装中提示  
```
Packages (19) php71-7.1.28-1  php71-apache-7.1.28-1  php71-cgi-7.1.28-1
              php71-dblib-7.1.28-1  php71-embed-7.1.28-1  php71-enchant-7.1.28-1
              php71-fpm-7.1.28-1  php71-gd-7.1.28-1  php71-imap-7.1.28-1
              php71-intl-7.1.28-1  php71-mcrypt-7.1.28-1  php71-odbc-7.1.28-1
              php71-pgsql-7.1.28-1  php71-phpdbg-7.1.28-1  php71-pspell-7.1.28-1
              php71-snmp-7.1.28-1  php71-sqlite-7.1.28-1  php71-tidy-7.1.28-1
              php71-xsl-7.1.28-1

Total Installed Size:  69.99 MiB

:: Proceed with installation? [Y/n]
```
安装完执行php Tab提示  
```
php71         php-config71  php-fpm71
php-cgi71     phpdbg71      phpize71
```
可以观察到71，以和主版本区别  
  
为了方便使用，创建一些软链接  
```
sudo ln -s /usr/bin/php71 /usr/bin/php
sudo ln -s /usr/bin/php-fpm71 /usr/bin/php-fpm
```
  
注意、注意、要配置与Nginx的链接  
  
修改相应的这一行参数  
```
fastcgi_pass unix:/var/run/php71-fpm/php-fpm.sock;
```
  
* Ubuntu 16.04  
## PHP各版本安装
```
# 查看库中版本号
sudo apt-cache show php
sudo apt-cache show php-mysql
# 默认源为7.0版


php -h 帮助
php -i 查看php信息
php -m 查看已安装扩展
php --ini Show configuration file names

# *php各种版本安装*

sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
#sudo apt-get upgrade
sudo apt-get install php7.0   # for PHP 7.0
sudo apt-get install php5.6   # for PHP 5.6
sudo apt-get install php5.5   # for PHP 5.5


sudo apt-get install php7.1 php7.1-dev \
php7.1-fpm \
php7.1-mysql \
php7.1-pdo

备注:phpize依赖php7.1-dev
debian9中安装依赖

laravel/lumen 需要的扩展
即composer install的时候按提示所安装的扩展
sudo apt install php7.1-dom php7.1-mbstring php7.1-curl php7.

(这里备注一下ubuntu环境下安装laravel的php扩展：sudo apt install php-dom php-mbstring php-curl php-zip php-gd)
(debian9/deepin15.11需要的扩展：sudo apt install php7.1-cli php7.1-common php7.1-gd
坑：安装php7.1-gd时死活找不到源,最后安装php7.1 php7.1-cli php7.1-common后问题解决，可以找到源了，莫名的原因
)

yii 需要的扩展
首先 comoser install
按提示sudo apt install php7.1-xml 等扩展

https://github.com/YunhanPHP/overview 需要的扩展
php7.1-zip [ast 0.1.5](https://pecl.php.net/package/ast/0.1.5)

修改/run/php/php7.1-fpm.sock权限
sudo chown kyronbao:kyronbao /run/php/php7.1-fpm.sock

sudo vim /etc/php/7.1/fpm/pool.d/www.conf
user = kyronbao
group = kyronbao

listen.owner = kyronbao
listen.group = kyronbao

0660 改成0666
```
  
  
  
  
  
## Apache PHP切换其他版本
```

Apache:-
sudo a2dismod php7.0
sudo a2enmod php5.6
sudo service apache2 restart
```
  
报错调试  
```
sudo systemctl restart apache2.service
Job for apache2.service failed because the control process exited with error code. See "systemctl status apache2.service" and "journalctl -xe" for details.
```
解决  
按提示依次执行  
```

systemctl status apache2.service
journalctl -xe
sudo apache2ctl configtest
# 提示
apache2: Syntax error on line 140 of /etc/apache2/apache2.conf: Syntax error on line 3 of /etc/apache2/mods-enabled/php5.6.load: Cannot load /usr/lib/apache2/modules/libphp5.6.so into server: /usr/lib/apache2/modules/libphp5.6.so: cannot open shared object file: No such file or directory
Action 'configtest' failed.
The Apache error log may have more information.

# 可能时apache扩展php5.6未安装，测试后成功
sudo apt install libapache2-mod-php5.6
# 再次重启apache2未报错
sudo systemctl restart apache2.service
```
  
## 切换命令行默认为其他PHP版本
Command Line:-  
```
sudo update-alternatives --set php /usr/bin/php7.2
sudo update-alternatives --set phar /usr/bin/phar7.2
sudo update-alternatives --set phar.phar /usr/bin/phar.phar7.2
sudo update-alternatives --set phpize /usr/bin/phpize7.2
sudo update-alternatives --set php-config /usr/bin/php-config7.2
```
  
参考 https://tecadmin.net/switch-between-multiple-php-version-on-ubuntu/  
  
安装后未找到/usr/bin/phpize5.6，无法安装扩展，问题解决  
解决思路  
浏览笔记记录，在默认未安装php5.6时，执行 phpize 提示sudo apt install php7.0-dev，  
证明phpize在php7.0-dev中  
所以phpize5.6应该在php5.6-dev中  
执行 =sudo apt install php5.6-dev= 后问题解决  
  
其他可参考ubuntu php仓库  
1. If you are using php-gearman, you need to add ppa:ondrej/pkg-gearman  
2. If you are using apache2, you are advised to add ppa:ondrej/apache2  
3. If you are using nginx, you are advise to add ppa:ondrej/nginx-mainline  
   or ppa:ondrej/nginx  
  
  
  
  



