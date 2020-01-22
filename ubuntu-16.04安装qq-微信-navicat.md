## qq安装													   :ubuntu 16.04:
wineQQ国际版安装方法  
winQQ国际版是UbuntuKylin给出的Linux下QQ替代方案，博主比较推荐这种方法，简单不折腾。  
首先，到UbuntuKylin官网去下载winqq的安装包，下载地址如下：  
  
winQQ国际版下载地址 http://www.ubuntukylin.com/application/show.php?lang=cn&id=279  
解压后有三个文件，使用下面的命令安装：  
  
```
sudo dpkg -i ./fonts-wqy-microhei_0.2.0-beta-2_all.deb
sudo dpkg -i ./ttf-wqy-microhei_0.2.0-beta-2_all.deb
sudo dpkg -i ./wine-qqintl_0.1.3-2_i386.deb
```
  
注意：由于有依赖关系，所以必须按照上面的顺序执行命令  
如果安装最后一个包的时候失败了，则可以执行下面的命令后再试：  
```
sudo apt-get install -f
```
  
安装完毕后，在dash中搜索qq就可以打开了。这个软件安装后，可能会有软件依赖冲突，如果有依赖冲突则无法安装其他软件，使用下面的命令检测是否有依赖冲突：  
```
sudo dpkg --configure -a
```
执行命令，没有任何结果，则表示没有软件依赖冲突。如果冲突列表中有wine-qqintl的字样  
则卸载wineqq，重新按照上面步骤安装，卸载命令如下：  
```
sudo dpkg -r  wine-qqintl
```
  
参考  
- http://blog.csdn.net/fuchaosz/article/details/51919607
- http://www.linuxprobe.com/ubuntu-wine-qq.html
  
## 微信安装													   :ubuntu 16.04:
下载地址  
https://github.com/geeeeeeeeek/electronic-wechat/releases  
解压后进入目录执行 =./electronic-wechat= 启动  
  
运行后界面停留在Starting APP那里 https://github.com/geeeeeeeeek/electronic-wechat/issues/603  
问题已解决，我是先把代理关闭（在Ubuntu->系统设置->网络->网络代理中把方法一栏方法设置为“None”），再重新启动一次WeChat，以后就都可以用了  
  
下载微信图标到/opt/wechat/wechat.png  
添加快捷方式  
```
sudo vim  /usr/share/applications/wechat.desktop
```
[Desktop Entry]  
Encoding=UTF-8  
Version=1.0  
Name=wechat  
GenericName=wechat  
Exec=/opt/wechat/electronic-wechat  
Terminal=false  
Icon=/opt/wechat/wechat.png  
Type=Application  
Comment=wechat_web  
Categories=Application;  
  
重启gnome-shell  
在dash测试输入wechat看不到图标时,按 =Alt+F2 r=  
  
参考 http://blog.csdn.net/yato0514/article/details/78534892  
  
## navicat安装												   :ubuntu 16.04:
```
wget http://download3.navicat.com/download/navicat112_premium_cs_x64.tar.gz
```
解压文件后执行以下命令  
./start_navicat  
  
修改界面的乱码  
打开start_navicat文件，会看到 export LANG="en_US.UTF-8" 将这句话改为 export LANG="zh_CN.UTF-8"  
  
  
添加navicat快捷方式  
下载图标到/opt/navicat/navicat.png  
```
cd /usr/share/applications
```
  
```
sudo vim navicat.desktop
```
[Desktop Entry]  
Encoding=UTF-8  
Name=Navicat Premium  
Comment=The Smarter Way to manage dadabase  
Exec=/bin/sh "/opt/navicat/start_navicat"  
Icon=/opt/navicat/navicat.png  
Categories=Application;Database;MySQL;navicat  
Version=1.0  
Type=Application  
Terminal=0  
  
重启gnome-shell 按 =Alt+F2 r=  
然后dash输入navicat就可以看到我们刚才加的图标了  
  
破解方案：  
第一次执行start_navicat时，会在用户主目录下生成一个名为.navicat的隐藏文件夹。  
rm ~/.navicat64/system.reg  #  或者删除rm -rf ~/.navicat64/  
  
把此文件删除后，下次启动navicat 会重新生成此文件，15天试用期会按新的时间开始计算。  
  
  
参考https://kelvin.mbioq.com/2016/12/03/install-premium-navicat-on-ubuntu1604.html#ci_title4  
