

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

## 流程图工具astah的安装配置
环境 debian9/deepin15.11

下载的破解文件astah-pro.jar替换位置/usr/lib/astah_professional/

由于astah-pro 依赖java1.8, 当本地java改为其他版本时 报错，可以配置下启动脚本

vim /usr/bin/astah-pro

定义$JAVA_LOCAL="/usr/lib/jvm/java-8-openjdk-amd64/jre/bin/java"
把里面的java命令改成用$JAVAL_LOCAL表示

参考
 https://blog.csdn.net/zxllynu/article/details/82289171