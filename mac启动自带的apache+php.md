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
