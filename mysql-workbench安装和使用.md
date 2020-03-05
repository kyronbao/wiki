
## debian9/deepin15.11安装mysql-workbench
sudo apt install mysql-workbench
## debian9/deepin15.11的mysql-workbench报错
### Could not store password: 于 gnome-keyring-daemon 联系时出错
sudo gedit /usr/bin/mysql-workbench  
将# WB_NO_GNOME_KEYRING=1改成export WB_NO_GNOME_KEYRING=1，  
