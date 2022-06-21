
## deepin15.11/debian9.0 编译安装php7.1

sudo apt install libjpeg-dev libpng-dev libwebp-dev libfreetype6-dev  libmcrypt-dev libreadline-dev




./configure \
--prefix=/usr/local/php7.1 \
--with-config-file-path=/usr/local/php7.1/etc \
--with-mcrypt \
--with-mhash \
--with-curl \
--with-freetype-dir \
--with-fpm-group=www-data \
--with-fpm-user=www-data \
--with-gd \
--with-webp-dir \
--with-jpeg-dir \
--with-gettext \
--with-iconv \
--with-imap-ssl \
--with-openssl \
--with-png-dir \
--with-mysqli=mysqlnd \
--with-pdo-mysql=mysqlnd \
--with-pear \
--with-readline \
--with-pcre-regex \
--with-zlib \
--with-zlib-dir \
--enable-bcmath \
--enable-calendar \
--enable-fpm \
--enable-ftp \
--enable-inline-optimization \
--enable-mysqlnd \
--enable-mbregex \
--enable-mbstring \
--enable-gd-native-ttf \
--enable-opcache \
--enable-pcntl \
--enable-sockets \
--enable-soap \
--enable-sockets \
--enable-sysvmsg \
--enable-sysvsem \
--enable-sysvshm \
--enable-shmop \
--enable-session \
--enable-xml \
--enable-zip


参考文件，参考这里后面的配置
https://www.cnblogs.com/lalalagq/p/9973716.html


php编译过程中报错:  PEAR package PHP_Archive not installed: generated phar will require PHP's phar extension be enabled

解决： 建议直接忽略，在 make install时会自动安装

下面这些会报错，不配置
--with-xpm-dir \
--with-jpeg-dir \
--with-libxml-dir \
--with-bz2 \
--with-xmlrpc \
--disable-rpath 
--disable-debug 
--disable-fileinfo 

## windows安装php7.1 php8.0
下载地址：
https://windows.php.net/downloads/releases/archives/

php-cgi开启:

方法一　创建start-php-fcgi.bat然后执行
@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\php-7.1.33;%PATH%
C:\php-7.1.33\php-cgi.exe -b 127.0.0.1:9123 -c C:\php-7.1.33\php.ini

方法二　在cmd执行
C:\php-7.1.33\php-cgi.exe -b 127.0.0.1:9123 -c C:\php-7.1.33\php.ini

方法三 在git bash执行
 php-cgi -b 127.0.0.1:9123 -c ./php.ini


 windows PHP配置
参考　https://stackoverflow.com/questions/4539670/php-fpm-for-windows
```
３　Edit the php.ini file as needed. What I did:
# nginx security setting
cgi.fix_pathinfo=0

extension_dir = "C:\php-5.3.10-Win32-VC9-x86\ext"
或者　extension_dir = "ext"　去取注释
enable the following modules by uncommenting them:

extension=php_curl.dll
extension=php_mbstring.dll
extension=php_mysqli.dll
４　Create a .bat file somewhere, e.g. start-php-fcgi.bat in webserver directory or in the PHP directory:

@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\php-5.3.10-Win32-VC9-x86;%PATH%
C:\php-5.3.10-Win32-VC9-x86\php-cgi.exe -b 127.0.0.1:9123 -c C:\php-5.3.10-Win32-VC9-x86\php.ini
５　Double click the .bat file to start php-fpm. A window will popup and stay open while its running. Its kind of annoying, but just haven't looked into setting it up as service yet.

６　Configure your webserver. If you wish to use it with nginx, here a config sample for 127.0.0.1:9123:

location ~ \.php$ {
    fastcgi_pass    127.0.0.1:9123;
    fastcgi_index   index.php;
    fastcgi_param   SCRIPT_FILENAME  $document_root$fastcgi_script_name;
    include         fastcgi_params;
}

```
php8.0配置
报错　vcruntime140.dll 14.0 not compatible with PHP build
参考
https://stackoverflow.com/questions/59414170/vcruntime140-dll-14-0-not-compatible-with-php-build#
解决：
12

I had the same problem. After I downloaded the latest version of Microsoft Visual C++,
 I successfully solved this problem. You can download it here .
 https://support.microsoft.com/en-us/help/2977003/the-latest-supported-visual-c-downloads
 
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
# archlinux
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
  
# Ubuntu 16.04  
## PHP各版本安装
```
 查看库中版本号
sudo apt-cache show php
sudo apt-cache show php-mysql
 默认源为7.0版


php -h 帮助
php -i 查看php信息
php -m 查看已安装扩展
php --ini Show configuration file names

 *php各种版本安装*

sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
#sudo apt-get upgrade
sudo apt-get install php7.0   # for PHP 7.0
sudo apt-get install php5.6   # for PHP 5.6
sudo apt-get install php5.5   # for PHP 5.5


sudo apt-get install php7.1 php7.1-dev php7.1-fpm php7.1-mysql php7.1-pdo

备注:phpize依赖php7.1-dev
debian9中安装依赖

laravel/lumen 需要的扩展
即composer install的时候按提示所安装的扩展
sudo apt install php7.1-dom php7.1-mbstring php7.1-curl

(这里备注一下ubuntu环境下安装laravel的php扩展：sudo apt install php-dom php-mbstring php-curl php-zip php-gd php-mysql)
(debian9/deepin15.11需要的扩展：sudo apt install php7.1-cli php7.1-common php7.1-gd php7.1-redis
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
  
  
  
  
  
## Nginx PHP切换版本需要注意
nginx php-fpm都要重启
sudo systemctl restart nginx
sudo systemctl restart php8.0-fpm

备注：
假如没有重启fpm
会出现 cli环境的php8.0有redis但是fpm环境提示没有redis扩展的情况
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
 提示
apache2: Syntax error on line 140 of /etc/apache2/apache2.conf: Syntax error on line 3 of /etc/apache2/mods-enabled/php5.6.load: Cannot load /usr/lib/apache2/modules/libphp5.6.so into server: /usr/lib/apache2/modules/libphp5.6.so: cannot open shared object file: No such file or directory
Action 'configtest' failed.
The Apache error log may have more information.

 可能时apache扩展php5.6未安装，测试后成功
sudo apt install libapache2-mod-php5.6
 再次重启apache2未报错
sudo systemctl restart apache2.service
```
  
## 切换命令行默认为其他PHP版本
Command Line:-  
```
sudo update-alternatives --set php /usr/bin/php7.3
sudo update-alternatives --set phar /usr/bin/phar7.3
sudo update-alternatives --set phar.phar /usr/bin/phar.phar7.3
sudo update-alternatives --set phpize /usr/bin/phpize7.3
sudo update-alternatives --set php-config /usr/bin/php-config7.3
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
  
  
  
  



