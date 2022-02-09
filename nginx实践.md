
## window安装配置
nginx开启：
在解压的nginx目录中git bash执行
nginx
nginx结束：
在任务管理器找应用或后台进程关闭
配置laravel的server
```
	# laravel
	server {
		listen 8080;
		listen [::]:8080;
		server_name  localhost;
		root D:\demo\laravel\public;

		add_header X-Frame-Options "SAMEORIGIN";
		add_header X-Content-Type-Options "nosniff";

		index index.php;

		charset utf-8;
		
		location / {
			try_files $uri $uri/ /index.php?$query_string;
		}

		location = /favicon.ico { access_log off; log_not_found off; }
		location = /robots.txt  { access_log off; log_not_found off; }

		error_page 404 /index.php;

		location ~ \.php$ {
			fastcgi_pass 127.0.0.1:9123;
			fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
			include fastcgi_params;
		}

		location ~ /\.(?!well-known).* {
			deny all;
		}

    }
```
 顺便安装laravel 9测试
 
  composer create-project --prefer-dist laravel/laravel laravel "9.*"

参考　https://stackoverflow.com/questions/35510974/nginx-service-not-starting-on-windows-10-nginx-alert-could-not-open-error-l
 (Run cmd as administrator)
```
cd c:\
unzip nginx-1.13.8.zip
cd nginx-1.13.8
start nginx
Go to: http://localhost:80 -> test install

Goback to console cmd: "nginx -s stop"

Run for next time:

Config with file: "C:\nginx-1.13.8\conf\nginx.conf"
Open cmd as administrator
Run bash: "cd C:\nginx-1.13.8"
Run nginx with bash: "start nginx" . If you run with bash: "nginx", will get trouble for exit nginx.
And

nginx -s stop #fast shutdown

nginx -s quit #graceful shutdown

nginx -s reload #changing configuration, starting new worker processes with a new configuration, graceful shutdown of old worker processes

nginx -s reopen #re-opening log files
```
## fcgiwrap是什么  
所以如果我们需要通过 cgi 程序（shell、perl、c/c++ 等）来编写网站后台的话，就需要 fcgiwrap 这个通用的 fastcgi 进程管理器来帮助 nginx 处理 cgi  
- https://www.zfl9.com/nginx-fcgi.html
 
## 检查apache2，关闭服务
```
sudo sysv-rc-conf
sudo systemctl stop apache2.service
```
sysv-rc-conf使用空格键选择和取消  
## Ubuntu 16.04安装nginx
```
sudo apt install nginx
sudo systemctl start nginx
```
开启防火墙  
```
sudo ufw app list
sudo ufw allow 'Nginx HTTP'
sudo ufw status
```
测试是否安装成功 访问 http://localhost:8080/  
```
systemctl status nginx
nginx -V
nginx version: nginx/1.10.3 (Ubuntu)
```
管理  
```
sudo systemctl start|stop|reload|enable|disable nginx
```
reload不断开链接重启 enable开机自动启动  
```
Server Configuration
/etc/nginx: The Nginx configuration directory.
/etc/nginx/nginx.conf:
/etc/nginx/sites-available/:虚拟站点配置文件
/etc/nginx/sites-enabled/: available的链接，有链接文件时网站生效
/etc/nginx/snippets: 包含fastcgi-php.conf
Server Logs
/var/log/nginx/access.log:
/var/log/nginx/error.log:
```
修改配置文件后reload报错后按提示执行 =sudo systemctl status nginx= 后 *放大* terminal可见提示错误信息  
  
  
参考  
- [How To Create Temporary and Permanent Redirects with Nginx](https://www.digitalocean.com/community/tutorials/how-to-create-temporary-and-permanent-redirects-with-nginx)
- [How To Install Nginx on Ubuntu 16.04](https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-16-04)
- [How to Install Nginx Latest Version on Ubuntu 16.04 and Ubuntu 16.10](https://www.linuxbabe.com/nginx/nginx-latest-version-ubuntu-16-04-16-10) ubuntu上安装最新版本的nginx
  
## 配置php
```
　# 查看默认php-fpm源版本
sudo apt show php-fpm
　# 为了方便，这里安装7.0版本
sudo apt-get install php7.0-fpm
```
修改配置文件，防止一个可能的安全漏洞，参考[大牛laruence的分析](http://www.laruence.com/2010/05/20/1495.html)，  
```
sudo vim /etc/php/7.0/fpm/php.ini
# 去掉注释修改1为0
cgi.fix_pathinfo=0

sudo systemctl restart php7.0-fpm
```
修改配置文件  
```
sudo vim /etc/nginx/sites-available/default
#参考如下内容
server {
    listen 80 default_server;
    listen [::]:80 default_server;

    root /var/www/html;
    index index.php index.html index.htm index.nginx-debian.html;

    server_name server_domain_or_IP;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}

# 测试
sudo nginx -t

sudo systemctl reload nginx
```
  
在根目录测试创建phpinfo文件，浏览器检查是否安装成功  
  
  
参考  
- [How To Install Linux, Nginx, MySQL, PHP (LEMP stack) in Ubuntu 16.04](https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-in-ubuntu-16-04)
  - https://www.cnblogs.com/buffer/archive/2011/07/24/2115552.html 介绍了作者的一些nginx方面的实践
## 配置虚拟主机
命令  
使用  
  
  
```

sudo mkdir -p /var/www/test.com

# $USER:$USER指当前登录的用户，实际部署生产时根据具体情况配置
sudo chown -R $USER:$USER /var/www/test.com

sudo chmod -R 755 /var/www/test.com

```
  
创建测试文件  
```
vim /var/www/test/index.php

<?php
phpinfo();
```
  
编写虚拟主机文件  
```
sudo cp /etc/nginx/sites-available/example.com /etc/nginx/sites-available/test.com
sudo vim /etc/nginx/sites-available/test.com
　# 参考下面内容修改

        listen 80;
        root /var/www/test;
        index index.php;
        server_name test.com www.test.com;

        access_log /var/log/nginx/test.access.log;
        error_log /var/log/nginx/test.error.log;

```
注意：去掉 =listen= 后面的 =default_server= ，=default_server= 在配置文件中必须唯一，指当请求无法匹配配置文件域名时，默认的匹配的端口为80。  
  
创建软链启用，注意必须为绝对路径  
```
sudo ln -s /etc/nginx/sites-available/test.com /etc/nginx/sites-enabled/
```
  
修改server_names_hash_bucket_size参数，防止域名过长报错  
```
sudo vim /etc/nginx/nginx.conf
# 去掉server_names_hash_bucket_size前面的注释
http {
    . . .

    server_names_hash_bucket_size 64;

    . . .
}
```
测试并重启nginx  
```
sudo nginx -t

sudo systemctl restart nginx
```
  
在浏览器测试 http://test.com  
  
## 配置https
  
参考  
- [wikipedia.org/zh-cn/傳輸層安全性協定](https://zh.wikipedia.org/zh-cn/%E5%82%B3%E8%BC%B8%E5%B1%A4%E5%AE%89%E5%85%A8%E6%80%A7%E5%8D%94%E5%AE%9A)
- http://www.ruanyifeng.com/blog/2014/02/ssl_tls.html
  
- https://cloud.tencent.com/document/product/400/4143#NginxCertificateOfDeployment 腾讯云下载证书后的文档（实际参考这个）
- https://www.tecmint.com/fix-400-bad-request-in-nginx/ 400 Bad Request The plain HTTP request was sent to HTTPS port
  
收费证书较便宜的  
- https://store.wotrus.com/ 的DV SSL版
  
其他  
- https://blog.csdn.net/w410589502/article/details/72833283#commentBox 介绍了生成证书的方法
https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=10_4 旧版本微信文档  
https://www.jianshu.com/p/9b9e789f5eae 微信支持，且只支持ssl_protocols TLSv1 TLSv1.1 TLSv1.2;所以，你需要把SSL V2，SSL V3这些协议都删掉  
  
  
证书安装目录  
/etc/nginx/  
  
```
server{
  listen 80;
  server_name kyronbao.com;
  return 301 https://kyronbao.com$request_uri;
}

server {
  listen 443;
  server_name  kyronbao.com;

  ssl on;
  ssl_certificate      1_kyronbao.com_bundle.crt;
  ssl_certificate_key  2_kyronbao.com.key;
  ssl_session_timeout 5m;
  ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
  ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:HIGH:!aNULL:!MD5:!RC4:!DHE;
  ssl_prefer_server_ciphers on;
  index index.php index.html index.htm;
  root /home/ubuntu/blog/public; # default Laravel's entry point for all requests

  access_log /var/log/nginx/access.log;
  error_log /var/log/nginx/error.log;

  location / {
    # try to serve file directly, fallback to index.php
     try_files $uri /index.php?$args;
  }

  location ~ \.php$ {
    fastcgi_index index.php;
    fastcgi_pass unix:/run/php/php7.3-fpm.sock;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_param PATH_INFO $fastcgi_path_info;
    include fastcgi_params;
  }
}

```
  
注意设置proxy_set_header Host $host; #重新设置host 传递给服务器，  
不设置的话在后端真实服务器上的css,js等文件可能不能解析  
  
## 配置反向代理
参考  
- https://segmentfault.com/a/1190000012184828#articleHeader4 后端服务器按权重配置
- https://www.jianshu.com/p/062a0201e664 介绍了代理转发到后端可以用http的原因和内部加密的方案
- https://blog.csdn.net/qq_33404395/article/details/80577433 介绍了些nginx的参数
  
浏览器在https时报错blocked:mixed-content 解决方法  
- https://segmentfault.com/q/1010000005872734
```
pstream blog_server {
  # docker-compose配置的nginx容器静态地址
  server 172.29.0.4:8081;
}

server{
  listen 80;
  server_name kyronbao.com;
  return 301 https://kyronbao.com$request_uri;
}

server {
  listen 443;
  server_name  kyronbao.com;

  ssl on;
  ssl_certificate      1_kyronbao.com_bundle.crt;
  ssl_certificate_key  2_kyronbao.com.key;
  ssl_session_timeout 5m;
  ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
  ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:HIGH:!aNULL:!MD5:!RC4:!DHE;
  ssl_prefer_server_ciphers on;

  access_log /var/log/nginx/access.log;
  error_log /var/log/nginx/error.log;

  location / {
    proxy_pass http://blog_server;
    proxy_set_header Host $host; #重新设置host 传递给服务器
  }

}


```
## 静态博客配置跳转路由规则
```
sudo vim /etc/nginx/sites-available/default
```
添加下面的一行代码，后重启nginx  
找到server_name _;  
```
　# 默认localhost/blog/ 跳转localhost/blog/index.html
rewrite ^/blog/$ /blog/index.html redirect;

　# 默认localhost 跳转localhost/blog/index.html
rewrite ^/$ /blog/index.html redirect;
```
  
  
## 修改用户
```
sudo vim /etc/nginx/nginx.conf
　# 找到www-data修改
sudo vim /etc/php/7.2/fpm/pool.d/www.conf
　# 找到www-data修改
user = kyronbao
group = kyronbao

listen.owner = kyronbao
listen.group = kyronbao
```
  
## 502
1 测试是否启动php-fpm  
  
2 本地测试时，每次都要设置laravel的目录bootstrap/cache和storage/logs权限，比较麻烦。所以修改nginx的用户为本地用户。  
当设置/etc/nginx/nginx.conf的user为kyronbao时，报错502 Bad Gateway  
原因：修改用户后应该也修改php7.2-fpm的用户配置  
  
## 504
https://easycloudsupport.zendesk.com/hc/en-us/articles/360002057472-How-to-Fix-504-Gateway-Timeout-using-Nginx  
## File not find
  
1 修改  
fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;  
  
2 检查权限  
  
/etc/nginx/nginx.conf 中 user  
  
/etc/php71/php-fpm.conf 中 user group  
  
## 13: Permission denied
  
```
vim /etc/nginx/nginx.conf
```
修改  
user root;  
解决  
  
## FastCGI sent in stderr: "Primary script unknown" while reading response header from upstream
  
解决方法  
  
1 查看fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;配置  
2 检查权限  
 /etc/nginx/nginx.conf  
 root  
  
 /etc/php/php-fpm/www.conf  
 user  
 group  
  
3 检查项目路径  
  
参考  
