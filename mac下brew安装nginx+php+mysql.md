  
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
  
  
  
  
