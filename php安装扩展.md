  * archlinux  

## 安装sqlserver驱动 deepin15.11/debian9
提示：执行下面命令时 如果提示依赖冲突，用sudo aptitude install unixodbc-dev,然后根据提示解决（备注操作经历：
按提示删除相应依赖 如： 输入1 2  然后 a 1    a2  然后 y 
）
    sudo apt-get install unixodbc-dev
	
步骤

sudo pecl install sqlsrv

sudo pecl install pdo_sqlsrv

安装odbc
https://docs.microsoft.com/en-us/sql/connect/odbc/linux-mac/installing-the-microsoft-odbc-driver-for-sql-server?view=sql-server-2017#debian17
```
sudo su
curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -

#Download appropriate package for the OS version
#Choose only ONE of the following, corresponding to your OS version

#Debian 8
curl https://packages.microsoft.com/config/debian/8/prod.list > /etc/apt/sources.list.d/mssql-release.list

#Debian 9(deepin15.11对应版本)
curl https://packages.microsoft.com/config/debian/9/prod.list > /etc/apt/sources.list.d/mssql-release.list

#Debian 10
curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list

exit
sudo apt-get update
sudo ACCEPT_EULA=Y apt-get install msodbcsql17
# optional: for bcp and sqlcmd
sudo ACCEPT_EULA=Y apt-get install mssql-tools
echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile
echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc
source ~/.bashrc
# optional: for unixODBC development headers
sudo apt-get install unixodbc-dev
# optional: kerberos library for debian-slim distributions
sudo apt-get install libgssapi-krb5-2
```
记得重启
sudo systemctl restart php7.3-fpm
sudo systemctl restart nginx


## 安装grpc扩展(pacman安装)
搜索 sudo pacman -Ss php-grpc  
安装 sudo pacman -S php-grpc  
扩展地址  
/usr/lib/php/modules  
配置文件修改  
```
sudo vim /etc/php/conf.d/grpc.ini 取消;
```
查看是否成功  
```
php -m | grep grpc
```
  
which grpc_php_plugin  
/usr/bin/grpc_php_plugin  
## 安装pecl记录
通过wiki知道php-pear在aur中  
```
git clone https://aur.archlinux.org/php-pear.git
cd php-pear/
makepkg -si
```
  
提示  
==> Verifying source file signatures with gpg...  
    install-pear-nozlib-1.10.15.phar ... FAILED (unknown public key 72A321BAC245F175)  
==> ERROR: One or more PGP signatures could not be verified!  
解决  
gpg --recv-keys 72A321BAC245F175  
再次安装  
```
makepkg -si
```
测试  
pecl version  
  
PEAR Version: 1.10.9  
PHP Version: 7.3.7  
Zend Engine Version: 3.3.7  
Running on: Linux ThinkPad 5.2.0-arch2-1-ARCH #1 SMP PREEMPT Mon Jul 8 18:18:54 UTC 2019 x86_64  
## 安装protobuf(pecl安装)
由于pacman -Ss php-protobuf查询不到，所以pecl安装  
```
sudo pecl install protobuf
```
按提示先更新pecl  
pecl channel-update pecl.php.net  
查看protobuf.io没有x权限，增加权限  
```
chmod +x /usr/lib/php/modules/protobuf.so
```
增加配置文件  
```
sudo vim /etc/php/conf.d/protobuf.ini
```
extension=protobuf.so  
查看是否安装成功  
```
php info protobuf
```
  
## 安装swoole
参考swoole Ubuntu版安装  
  
安装redis  
```
sudo pacman -S redis
```
  
安装libhiredis  
```
wget https://github.com/redis/hiredis/releases/tag/v0.14.0
./configue
make
sudo make install
```
  
  
安装swoole  
```
./configure --with-php-config=/usr/bin/php-config71 --enable-async-redis
```
  
解决报错 libhiredis.so.0.14: cannot open shared object file: No such file or directory in Unknown on line 0  
环境变量添加  
```
vim .bash_profile
#
export LD_LIBRARY_PATH=$LD_LIBRARY_PATH:/usr/local/lib
```
参考 https://wiki.swoole.com/wiki/page/p-redis.html 评论  
## 安装xdebug
下载  
  
在 https://xdebug.org/download.php 下载最新稳定版源码包  
```
wget https://xdebug.org/files/xdebug-2.7.2.tgz
```
解压后参考README.rst  
```
phpize71
./configure --enable-xdebug
make clean
make
sudo make install
```
修改 php.ini，添加  
```
zend_extension="xdebug.so"
```
  
* ubuntu  
ubuntu 扩展地址/usr/lib/php/  
  
  
## Ubantu php扩展模块开启
如果安装php7.2-cli，会安装相关的一些扩展，具体如下：  
  
```
sudo apt install php7.2-cli --fix-missing
```
  
The following additional packages will be installed:  
  libapache2-mod-php7.2 php7.2-bcmath php7.2-cli php7.2-common php7.2-curl php7.2-dev  
  php7.2-fpm php7.2-gd php7.2-json php7.2-mbstring php7.2-mysql php7.2-opcache  
  php7.2-readline php7.2-sqlite3 php7.2-xml  
  
  
相关命令  
phpenmod -s cli mbstring  
phpenmod -s fpm mbstring  
  
phpenmod -v 7.2 mbstring  
- https://tecadmin.net/enable-disable-php-modules-ubuntu/
  
实践  
安装ast模块  
```
sudo vim /etc/php/7.1/mods-available/ast.ini
```
extension=ast.so  
  
phpenmod -v 7.1 ast  
  
  
## 安装phpize7.2
```
sudo apt install php7.2-dev
# 显示如下信息
The following additional packages will be installed:
  libapache2-mod-php7.2 php7.2-cli php7.2-common php7.2-fpm php7.2-gd
  php7.2-json php7.2-mbstring php7.2-mysql php7.2-opcache php7.2-readline
  php7.2-xml
The following NEW packages will be installed:
  php7.2-dev
The following packages will be upgraded:
  libapache2-mod-php7.2 php7.2-cli php7.2-common php7.2-fpm php7.2-gd
  php7.2-json php7.2-mbstring php7.2-mysql php7.2-opcache php7.2-readline
  php7.2-xml
...
update-alternatives: using /usr/bin/php-config7.2 to provide /usr/bin/php-config (php-config) in auto mode
update-alternatives: using /usr/bin/phpize7.2 to provide /usr/bin/phpize (phpize) in auto mode
Processing triggers for php7.2-fpm (7.2.7-1+ubuntu16.04.1+deb.sury.org+1) ...
NOTICE: Not enabling PHP 7.2 FPM by default.
NOTICE: To enable PHP 7.2 FPM in Apache2 do:
NOTICE: a2enmod proxy_fcgi setenvif
NOTICE: a2enconf php7.2-fpm
NOTICE: You are seeing this message because you have apache2 package installed.
# 测试
phpize7.2 -v
```
  
## 方法一 php官方安装方式
参考  
- http://php.net/manual/en/install.pecl.phpize.php 扩展安装时若多个php版本 --with-php-config=/usr/bin/php-config5.6
- http://php.net/manual/en/install.pecl.php-config.php php-config is a simple shell script for obtaining information about the installed PHP configuration
- http://php.net/manual/en/extensions.alphabetical.php php官方扩展地址
- http://php.net/manual/en/install.pecl.php php
  
执行 phpize 后按提示  
```
sudo apt install php7.0-dev
```
  
例如  
安装php5.6版扩展sphinx  
```
wget -c http://pecl.php.net/get/sphinx-1.3.3.tgz
tar zxvf sphinx-1.3.3.tgz
cd sphinx-1.3.3
sudo apt install php5.6-dev  #  安装phpize5.6等
/usr/bin/phpize5.6
./configure --with-sphinx=/opt/sphinx/libsphinxclient/ --with-php-config=/usr/bin/php-config5.6
make
sudo make install
# 成功后显示
Installing shared extensions:     /usr/lib/php/20131226/

配置php.ini
sudo vim /etc/php/5.6/apache2/php.ini
[Sphinx]
extension = sphinx.so
```
  
## 方法二 ubuntu 包安装方式
查看相关扩展  
```

apt-cache search php- | less
# or
apt-cache pkgnames | grep php-/php7.0

# 查看扩展详细信息
apt-cache show php-mysql  # 查得对应php版本为7.0

# 例如
# php7.0扩展安装mysql
sudo apt install php7.0-mysql
sudo systemctl restart apache2.service
# apache2启动后验证phpinfo()参数

# 安装5.6版pdo和mysql驱动
sudo apt install php5.6-mysql

sudo vim /etc/php/5.6/apache2/php.ini
# 去掉下面一行的前面;符号
;extension=php_pdo_mysql.so
# 重启apache，验证
```
  
  
*扩展卸载*  
重新注释php.ini的相关的扩展，重启apache2  
  
参考  
- [[https://help.ubuntu.com/lts/serverguide/php.html]]
- https://askubuntu.com/questions/795629/install-php-extensions-in-ubuntu-16-04
- https://launchpad.net/~ondrej/+archive/ubuntu/php?field.series_filter=xenial
## 安装扩展phpredis
- https://pecl.php.net/package/redis
- https://github.com/phpredis/phpredis/#installation
关于igbinary  
- https://blog.longwin.com.tw/2017/10/php-igbinary-replace-serializer-2017/
phpize  
./configure [--enable-redis-igbinary] [--enable-redis-lzf [--with-liblzf[=DIR]]]  
make && make install  
  
Libraries have been installed in:  
   /home/kyronbao/Downloads/redis-4.1.1/redis-4.1.1/modules  
  
If you ever happen to want to link against installed libraries  
in a given directory, LIBDIR, you must either use libtool, and  
specify the full pathname of the library, or use the '-LLIBDIR'  
flag during linking and do at least one of the following:  
   - add LIBDIR to the 'LD_LIBRARY_PATH' environment variable
     during execution  
   - add LIBDIR to the 'LD_RUN_PATH' environment variable
     during linking  
   - use the '-Wl,-rpath -Wl,LIBDIR' linker flag
   - have your system administrator add LIBDIR to '/etc/ld.so.conf'
  
See any operating system documentation about shared libraries for  
more information, such as the ld(1) and ld.so(8) manual pages.  
----------------------------------------------------------------------
Installing shared extensions:     /usr/lib/php/20170718/  
  
设置php.ini  
```
sudo vim /etc/php/7.2/fpm/php.ini
```
添加  
[redis]  
extension=redis.io  
  
/etc/init.d/php7.2-fpm restart  
## 安装扩展mcrypt
- https://pecl.php.net/package/mcrypt
安装时发现需要libmcrypt,  
这里下载安装  
- https://nchc.dl.sourceforge.net/project/mcrypt/Libmcrypt/2.5.8/libmcrypt-2.5.8.tar.gz
  
然后安装mcrypt  
[mcrypt]  
extension=mcrypt.so  
  
## 安装php7.0-fpm安装yaf
首先查看本地php系列的程序，确定为7.0版本  
```
php-fpm -v
php -v
php-config -v
```
  
安装yaf  
  
```
wget https://pecl.php.net/get/yaf-3.0.7.tgz
#解压进入目录后
./configure --with-php-config=/usr/bin/php-config7.0
make
make install
```
安装信息  
```
Libraries have been installed in:
   /home/kyronbao/Downloads/yaf-3.0.7/modules

If you ever happen to want to link against installed libraries
in a given directory, LIBDIR, you must either use libtool, and
specify the full pathname of the library, or use the '-LLIBDIR'
flag during linking and do at least one of the following:
   - add LIBDIR to the 'LD_LIBRARY_PATH' environment variable
     during execution
   - add LIBDIR to the 'LD_RUN_PATH' environment variable
     during linking
   - use the '-Wl,-rpath -Wl,LIBDIR' linker flag
   - have your system administrator add LIBDIR to '/etc/ld.so.conf'

See any operating system documentation about shared libraries for
more information, such as the ld(1) and ld.so(8) manual pages.
----------------------------------------------------------------------
Installing shared extensions:     /usr/lib/php/20151012/
```
重启php-fpm  
```
/etc/init.d/php7.0-fpm restart
```
  
<2018-01-29 一>  
<2018-06-21 四> 安装yaf  
## 安装swoole 4.01
扩展地址 https://pecl.php.net/package/swoole  
  
如果要安装异步redis客户端  
- https://wiki.swoole.com/wiki/page/p-redis.html
```
sudo apt install libhiredis-dev
```
目前最新版 4.01  
```
wget https://pecl.php.net/get/swoole-4.0.1.tgz
```
解压后进入目录，这里PHP为7.2版本  
  
```
/usr/bin/phpize7.2

./configure --with-php-config=/usr/bin/php-config7.2 --enable-async-redis
make
sudo make install
```
  
编辑配置  
```
sudo vim /etc/php/7.2/mods-available/swoole.ini
# 编辑以下内容
; configuration for php swoole module
; priority=20
extension=swoole.so
```
  
创建连接  
```
sudo ln -s /etc/php/7.2/mods-available/swoole.ini /etc/php/7.2/cli/conf.d/20-swoole.ini
sudo ln -s /etc/php/7.2/mods-available/swoole.ini /etc/php/7.2/fpm/conf.d/20-swoole.ini
```
  
=php -m= 查看安装是否成功  
## 安装ast 0.1.5
通过[yunhanphp/lumen-installer](https://github.com/YunhanPHP/overview/blob/master/init/new-project.md) 安装lumen时，提示报错  
phan/phan 0.12.14 requires ext-ast ^0.1.5  
查询可知 最新版本为1.0  
- https://pecl.php.net/package/ast
- https://github.com/nikic/php-ast
