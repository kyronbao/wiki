  
因为要安装微信小程序工具，发现怎么都装不了wine，最终解决如下  
  
- http://ubuntuhandbook.org/index.php/2017/01/install-wine-2-0-ubuntu-16-04-14-04-16-10/
  
首先 在/etc/apt/source.list 和 /etc/apt/source.list.d目录下 删除所有跟wine相关的源  
  
```
sudo add-apt-repository ppa:ricotz/unstable
sudo apt update
sudo apt install wine-stable
```
由于我也修改了php私人源文件的名字，所以这里提示也会删除php的相关安装  
  
Reading package lists... Done  
Building dependency tree  
Reading state information... Done  
The following packages were automatically installed and are no longer required:  
  brasero-cdrkit dh-php dleyna-renderer libargon2-0 libpcre3-dev libpcre32-3 libpcrecpp0v5 libssl-dev libssl-doc php5.6-opcache php5.6-readline  
  php7.1-opcache php7.1-readline php7.2-opcache php7.2-readline pkg-php-tools shtool xml2  
Use 'sudo apt autoremove' to remove them.  
The following additional packages will be installed:  
  fonts-wine libcapi20-3 libopenal-data libopenal1 libosmesa6 libwine wine64  
Suggested packages:  
  isdnutils-doc ttf-mscorefonts-installer winbind winetricks playonlinux wine-binfmt dosbox libwine-gecko-2.47 wine64-preloader  
Recommended packages:  
  wine32  
The following packages will be REMOVED:  
  brasero dconf-editor gnome-photos php5.6-cli php5.6-dev php7.1-cli php7.1-dev php7.1-gd php7.2-cli php7.2-dev  
The following NEW packages will be installed:  
  fonts-wine libcapi20-3 libopenal-data libopenal1 libosmesa6 libwine wine-stable wine64  
0 upgraded, 8 newly installed, 10 to remove and 6 not upgraded.  
Need to get 26.2 MB/27.5 MB of archives.  
After this operation, 183 MB of additional disk space will be used.  
  
最后测试，果然发现我的PHP版本从php7.2变为了php7.0  
  
安装  
wine --version  
提示  
it looks like wine32 is missing, you should install it.  
as root, please execute "apt-get install wine32"  
wine-3.0.5 (Ubuntu 3.0.5-0ubuntu1~16.04~ricotz0)  
  
参考  
- https://linuxconfig.org/install-wine-on-ubuntu-18-04-bionic-beaver-linux
  
wine64 --version  
提示正确  
wine-3.0.5 (Ubuntu 3.0.5-0ubuntu1~16.04~ricotz0)  
  
折腾了两天，一直安装不成功wine32  
最后，参考这里  
- https://wiki.winehq.org/Ubuntu
Compiling WoW64  
Ubuntu's implementation of Multiarch is still incomplete, so for now you can't simply install 32-bit and 64-bit libraries alongside each other. If you're on a 64-bit system, you'll have to create an isolated environment for installing and building with 32-bit dependencies. See Building Biarch Wine On Ubuntu for detailed instructions for Ubuntu using LXC, and Building Wine for general information.  
  
在64位系统需要LXC 即linux容器才行  
  
又折腾了下  
  
首先修改了wine软链到wine64  
  
参考  
- http://www.fdlly.com/p/1446699962.html
- https://jingyan.baidu.com/article/d169e1867ba57f436611d8d2.html
解决了  
000f:fixme:service:scmdatabase_autostart_services Auto-start service L"MountMgr" failed to start: 2  
000f:fixme:service:scmdatabase_autostart_services Auto-start service L"WineBus" failed to start: 2  
这个问题  
  
现在启动./bin/wxdt 或者 wine64 name.exe时报错 Wine: Bad EXE format  
