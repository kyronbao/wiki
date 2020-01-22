* Apache2安装  
```
sudo apt-get install apache2

# 测试
sudo apache2ctl configtest

sudo vim /etc/apache2/apache2.conf
# 最后一行添加
ServerName server_domain_or_IP

# 默认网址
vim /etc/apache2/sites-available/000-default.conf
sudo apache2ctl configtest

sudo systemctl restart apache2

# 查看防火墙
sudo ufw status

sudo ufw app list
Available applications:
  Apache
  Apache Full
  Apache Secure
  CUPS

# 查看其中的一项
sudo ufw app info "Apache Full"
# 开启
sudo ufw allow in "Apache Full"
# 再次查看
sudo ufw status

```
  
参考 https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04  
<2017-12-24 日>  
* 安装Apche2的PHP模块  
```
apt-cache search libapache2-mod-php
sudo apt install libapache2-mod-php7.0
# 显示
The following additional packages will be installed:
  php7.0 php7.0-cli php7.0-common php7.0-dev php7.0-fpm php7.0-json php7.0-mysql php7.0-opcache
  php7.0-readline php7.0-xml
The following NEW packages will be installed:
  libapache2-mod-php7.0

sudo vim /etc/apache2/mods-enabled/dir.conf

# 将DirectoryIndex参数 index.php 移到前面
<IfModule mod_dir.c>
    DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>
```
  
```
sudo vim /var/www/html/index.php
```
  
<?php  
phpinfo();  
  
```
sudo systemctl restart apache2
```
  
# 访问 http://localhost  
  
apache报错排查  
apache2重启后无法使用  
诊断  
```
sudo systemctrl status apache2
# 显示
module php7_module is already loaded, skipping
```
解决方法  
搜索ubuntu16 failed  
参考https://askubuntu.com/questions/777672/apache2-restart-failed-in-ubuntu-16-04  
```
sudo a2dismod php7.0
```
原因分析  
启动了多个php版本  
  
* Apache2虚拟域名设置  
添加虚拟域名步骤为：  
复制一份 =sites-available= 下的配置文件，修改为相应自己参数，例如：  
```
Servername Laramulti.cc

ServerAdmin webmaster@localhost
DocumentRoot /var/www/laramulti/public

ErrorLog ${APACHE_LOG_DIR}/laramulti.error.log
CustomLog ${APACHE_LOG_DIR}/laramulti.access.log combined
```
  
执行 =sudo a2ensite= 选择自己刚编辑的网站，此命令实际上添加了一条软链接从 =sites-enabled= 指向 =sites-available=  
  
编辑 =/etc/hosts= 指向相应的域名  
  
默认代码根目录在=/var/www=下，如果需要自定义目录，需要在修改配置文件=/etc/apache2/papche2.conf=添加白名单，参考  
```
#<Directory /srv/>
#       Options Indexes FollowSymLinks
#       AllowOverride None
#       Require all granted
#</Directory>
```
  
* Ubuntu版apache2配置文件位置和工具  
阅读apache2提供的测试页面提供了基本配置使用的很多信息,安装成功后访问 http://localhost 查看详情。  
  
网站资源跟目录位于 =/var/www/html=  
配置文件目录 =/etc/apache2= ,如下  
```
/etc/apache2/
|-- apache2.conf
|       `--  ports.conf
|-- mods-enabled
|       |-- *.load
|       `-- *.conf
|-- conf-enabled
|       `-- *.conf
|-- sites-enabled
|       `-- *.conf
```
其他相应的工具有= a2enmod, a2dismod, a2ensite, a2dissite, and a2enconf, a2disconf=  
  
<2017-12-17 日>  
  
* 修改端口  
```
sudo vim /etc/apache2/sites-available/000-default.conf
# 修改80为8080

sudo vim /etc/apache2/ports.conf
# 修改80为8080
