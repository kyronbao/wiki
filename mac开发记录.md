## 工具
HyperSwitch 切换程序  
brew services start emacs  
## 启动自带的apache和php
参考  
    http://dwtedx.com/blog_418.html  
    http://php.net/manual/zh/install.macosx.bundled.php  
系统版本：OSX 10.11 El Capitan  
  
查看  
httpd -v  
```
php -v
```
  
Apache  
    配置  
	修改配置sudo vi /private/etc/apache2/httpd.conf  
            去掉# LoadModule php5_module libexec/httpd/libphp5.so注释  
            添加 在index.html后添加index.php  
	    修改Apache根目录  
	        /Library/WebServer/Documents改为/Users/user/Sites  
                    注：user为我的用户名  
    操作  
        sudo apachectl start|restart|stop  
    自动启动配置  
        参考  
            http://canlynet.iteye.com/blog/2006762  
            http://www.jianshu.com/p/9a01de9c5c09  
  
PHP测试  
    在/Users/user/Sites 目录下新建phpinfo.php  

## brew启动自带的apache,php,mysql  
参考  
    http://col.dog/2015/11/22/homebrew/  
    http://whlminds.com/2015/10/06/php-nginx-mysql-mac/  
  
本次测试安装nginx版本为  
1.10.2_1  
  
修改ngnix开机启动（nginx目录）  
> sudo chown root:wheel /usr/local/Cellar/nginx/1.10.2_1/bin/nginx  
> sudo chmod u+s  /usr/local/Cellar/nginx/1.10.2_1/bin/nginx  
> sudo chown -R $USER /usr/local/var/log/nginx/  
  
修改nginx配置vim /usr/local/etc/nginx/nginx.conf  
  
error_log       /usr/local/var/log/nginx/error.log warn;  
  
pid        /usr/local/var/run/nginx.pid;  
  
events {  
    worker_connections  256;  
}  
  
  
  
fastcgi_param             SCRIPT_FILENAME $document_root$fastcgi_script_name;  
  
测试  
    nginx -t  
  
  
  
mysql安装  
    brew install mysql  
        等待时间比较久  
    然后  
	launchctl load ~/Library/LaunchAgents/homebrew.mxcl.mysql.plist  
        mysql_secure_installation  
        两条命令会报错  
            解决：参考https://github.com/Homebrew/homebrew-versions/issues/1137  
                直接运行mysql -uroot -p  成功  
       最后mysql_secure_installation 按照提示配置  
  
  
  
