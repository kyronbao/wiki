## sublime安装和配置  
  
下载地址 https://www.sublimetext.com/3  
解压  
```
sudo tar jxvf sublime... -C /opt
sudo mv /opt/sublime_text_3 /opt/sublime_text
```
配置快捷方式  
```
sudo vim /usr/share/applications/sublime.desktop
# 编辑以内容
[Desktop Entry]
Version=1.0
Name=sublime
Exec=/opt/sublime_text/sublime_text
Terminal=false
Icon=/opt/sublime_text/Icon/128x128/sublime-text.png
Type=Application
Categories=Development

```
备注：或者可以在用户目录下创建快捷图标  
.local/share/applications  
  
  
输入中文配置  
- https://www.jianshu.com/p/bf05fb3a4709
```
sudo vim /opt/sublime_text/sublime_start_cn

#!/bin/bash
LD_PRELOAD=/opt/sublime_text/libsublime-imfix.so subl
```
添加执行权限  
```
sudo chmod +x /opt/sublime_text/sublime_start_cn
```
修改启动文件下面一行  
```
sudo vim /usr/share/applications/sublime.desktop

Exec=/opt/sublime_text/sublime_start_cn
```
  
配置refererce  setting-user  
{  
	"font_size": 10,  
	 "tab_size": ,  
    "translate_tabs_to_spaces": true  
}  
  
### Sublime代码格式化
```
1、打开设置快捷键的界面（分左右两块区域，左边为编辑器默认，通常为了保证不影响正常功能，左边的默认设置不作修改，而修改右边的User区域）：

Preferences → Key Bindings – User

2、在其中添加代码，快捷键组合可按需设置：

{"keys": ["ctrl+shift+r"], "command": "reindent" , "args":
{"single_line": false}}
```
- https://my.oschina.net/u/171860/blog/754867
  
### Sublime Text 3 Build 3176 Windows、MacOS、Linux破解方法
- https://blog.csdn.net/qq_35357588/article/details/81120101
修改电脑的hosts文件添加屏蔽记录  
  
文件位置：  
  
Windows : c:/windows/system32/drivers/etc/hosts  
  
Linux : /etc/hosts  
  
Mac : /Private/etc  
  
添加记录：  
  
 127.0.0.1       www.sublimetext.com  
127.0.0.1       license.sublimehq.com  
Sublime Text 3授权码：  
  
 ----- BEGIN LICENSE -----
sgbteam  
Single User License  
EA7E-1153259  
8891CBB9 F1513E4F 1A3405C1 A865D53F  
115F202E 7B91AB2D 0D2A40ED 352B269B  
76E84F0B CD69BFC7 59F2DFEF E267328F  
215652A3 E88F9D8F 4C38E3BA 5B2DAAE4  
969624E7 DC9CD4D5 717FB40C 1B9738CF  
20B3C4F1 E917B5B3 87C38D9C ACCE7DD8  
5F7EF854 86B9743C FADC04AA FB0DA5C0  
F913BE58 42FEA319 F954EFDD AE881E0B  
------ END LICENSE ------
如何禁用更新：  
  
设置 Preferences -> Settings-User  
  
添加 "update_check": false  
### 执行sudo apt update时提示
The following signatures couldn't be verified because the public key is not available: NO_PUBKEY C2518248EEA14886  
  
移除该源  
```
sudo mv /etc/apt/sources.list.d/webupd8team-ubuntu-sublime-text-3-xenial.list /tmp
```
再次sudo apt update 无提示  
### 默认的Sublime 3中没有Package Control
- https://blog.csdn.net/zbx931197485/article/details/79873721
原来Subl3安装Package Control很麻烦，现在简单的方法来了  
  
一、简单的安装方法  
  
使用Ctrl+`快捷键或者通过View->Show Console菜单打开命令行，粘贴如下代码：  
  
import urllib.request,os; pf = 'Package Control.sublime-package'; ipp = sublime.installed_packages_path(); urllib.request.install_opener( urllib.request.build_opener( urllib.request.ProxyHandler()) ); open(os.path.join(ipp, pf), 'wb').write(urllib.request.urlopen( 'http://sublime.wbond.net/' + pf.replace(' ','%20')).read())  
1  
如果顺利的话，此时就可以在Preferences菜单下看到Package Settings和Package Control两个菜单了。  
  
顺便贴下Sublime Text2 的代码：  
  
import urllib2,os; pf='Package Control.sublime-package'; ipp = sublime.installed_packages_path(); os.makedirs( ipp ) if not os.path.exists(ipp) else None; urllib2.install_opener( urllib2.build_opener( urllib2.ProxyHandler( ))); open( os.path.join( ipp, pf), 'wb' ).write( urllib2.urlopen( 'http://sublime.wbond.net/' +pf.replace( ' ','%20' )).read()); print( 'Please restart Sublime Text to finish installation')  
1  
二、手动安装  
  
可能由于各种原因，无法使用代码安装，那可以通过以下步骤手动安装Package Control：  
  
1.点击Preferences > Browse Packages菜单  
  
2.进入打开的目录的上层目录，然后再进入Installed Packages/目录  
  
3.下载Package Control.sublime-package并复制到Installed Packages/目录  
  
4.重启Sublime Text。  
### 支持react语法
