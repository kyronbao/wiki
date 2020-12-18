
## charles安装和配置
```
sudo vim /usr/share/applications/charles.desktop
```
https://www.tapd.cn/21766161/prong/stories/view/1121766161001007279  
[Desktop Entry]  
Version=1.0  
Name=charles  
Exec=/opt/charles/bin/charles  
Terminal=false  
Icon=/opt/charles/icon/64x64/apps/charles-proxy.png  
Type=Application  
Categories=Development  
## debian9/deepin15.11安装mysql-workbench
sudo apt install mysql-workbench
### debian9/deepin15.11的mysql-workbench报错
#### Could not store password: 于 gnome-keyring-daemon 联系时出错
sudo gedit /usr/bin/mysql-workbench  
将# WB_NO_GNOME_KEYRING=1改成export WB_NO_GNOME_KEYRING=1，  
