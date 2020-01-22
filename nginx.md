  
fcgiwrap  
所以如果我们需要通过 cgi 程序（shell、perl、c/c++ 等）来编写网站后台的话，就需要 fcgiwrap 这个通用的 fastcgi 进程管理器来帮助 nginx 处理 cgi  
- https://www.zfl9.com/nginx-fcgi.html
  
  
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
