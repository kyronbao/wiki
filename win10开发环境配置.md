安装chrome
打开shadowsocks 然后执行ChromeSetup.exe
显示我的电脑
桌面右击个性化，点主题，右边能看见桌面图标设置
关闭Microsoft OneDrive
右击任务栏，选择任务管理器，选择'启动' 禁用OneDrive

安装TortoiseSVN  记得设置commond line install (为了在phpstorm中设置svn)

安装phpstorm  
设置ide-eval-resetter-2.1.14.jar 破解
setting sbuversion 设置svn.exe的路径，然后重启phpstorm,在命令行执行svn up按提示输入用户密码svn账号密码

teamviewer
ky...b..@hotmail.com（该账号已不能再关联设备）
201313488@qq.com   ...REW.5   目前只允许一个用户登录，所以先登录页面https://login.teamviewer.com/LogOn  在右上角编辑账号哪里编辑删掉设备，再尝试

关掉登录需要密码
设置--账户--账户信息 改为本地用户登录
设置--账户--登录选项--关掉“需要通过windows hello登录Microsoft账户”  搜索框输入Netplwiz   关掉 “必须使用账户和密码”

安装git bash

安装notepad++


安装开发环境：

https://downloads.mysql.com/archives/installer/
选５.7 .36
Microsoft Windows
下载

https://windows.php.net/downloads/releases/archives/


nginx开启：
在解压的nginx目录中git bash执行
nginx
nginx结束：
在任务管理器找应用或后台进程关闭

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

php-cgi开启

方法一　创建start-php-fcgi.bat然后执行
@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\php-7.1.33;%PATH%
C:\php-7.1.33\php-cgi.exe -b 127.0.0.1:9123 -c C:\php-7.1.33\php.ini

方法二　在cmd执行
C:\php-7.1.33\php-cgi.exe -b 127.0.0.1:9123 -c C:\php-7.1.33\php.ini

方法三 在git bash执行
 php-cgi -b 127.0.0.1:9123 -c ./php.ini





## windows PHP配置
参考　https://stackoverflow.com/questions/4539670/php-fpm-for-windows

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


php8.0配置
报错　vcruntime140.dll 14.0 not compatible with PHP build
参考
https://stackoverflow.com/questions/59414170/vcruntime140-dll-14-0-not-compatible-with-php-build#
解决：
12

I had the same problem. After I downloaded the latest version of Microsoft Visual C++,
 I successfully solved this problem. You can download it here .
 https://support.microsoft.com/en-us/help/2977003/the-latest-supported-visual-c-downloads
 
 安装laravel 9
 
  composer create-project --prefer-dist laravel/laravel laravel "9.*"
 