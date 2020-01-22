  
- https://pecl.php.net/package/yaf
- https://github.com/laruence/yaf
- http://www.laruence.com/manual/yaf.install.html
  
```
wget https://pecl.php.net/get/yaf-3.0.7.tgz
```
  
```
/usr/bin/phpize7.2
./configure --with-php-config=/usr/bin/php-config7.2
make
sudo make install
```
编辑配置文件  
```
sudo vim /etc/php/7.2/mods-available/yaf.ini
# 编辑以下内容
; configuration for php yaf module
; priority=20
extension=yaf.so
```
编辑fpm和cli配置  
  
```
sudo ln -s /etc/php/7.2/mods-available/yaf.ini /etc/php/7.2/cli/conf.d/20-yaf.ini
sudo ln -s /etc/php/7.2/mods-available/yaf.ini /etc/php/7.2/fpm/conf.d/20-yaf.ini
```
重启fpm  
```
sudo systemctl restart php7.2-fpm
```
  
=php -m= 查看安装是否成功  
  
