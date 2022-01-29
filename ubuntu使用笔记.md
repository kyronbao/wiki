## 查看已安装各软件的大小
sudo dpkg-query -W --showformat='${Installed-Size} ${Package} ${Status}\n'|grep -v deinstall|sort -n|awk '{print $1" "$2}'
## 同一wifi下复制文件到Android手机
手机安装es文件浏览器  
开启远程管理器功能显示手机地址  
ubuntu电脑端打开filezilla  
填写ip地址和端口号即可登录  
## ubuntu 中文显示
http://blog.csdn.net/zhangchao19890805/article/details/52743380  
  
## Ubuntu连接无线上网慢的解决
装了Ubuntu 16.04 LTS后连接无线上网，发现出奇的慢。网上查找亲测有效的方法为：  
1、在终端运行：sudo gedit /etc/modprobe.d/iwlwifi.conf  
2、在打开的这个配置文件中空白处添加：options iwlwifi 11n_disable=1  
3、保存文件并重启。  
http://blog.csdn.net/mandagod/article/details/53959044  
## ubuntu server服务器初始配置								   :ubuntu 16.04:
  
参考 [Initial Server Setup with Ubuntu 16.04](https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu-16-04)  
  
  
  
  
  
## how to free swap当电脑运行慢时，有可能是内存不够，swap交换频繁，怎么办呢
参考 - https://askubuntu.com/questions/1357/how-to-empty-swap-if-there-is-free-ram  
使用monitor,top等工具查看时确实占用大量swap,但是具体应该查看vmstat 1 输出的si选项，如果数值不大或为0时，也顺其自然就好啦，  
  
## gnome总是变暗
gsettings set org.gnome.settings-daemon.plugins.power idle-brightness 100  
- https://askubuntu.com/questions/785867/how-to-fix-auto-dim
  
## terminal启动慢
- https://askubuntu.com/questions/911946/terminal-appears-with-much-delay-when-shortcut-is-used/912193
## Ubuntu合上盖子不进入休眠
- [Ubuntu16.04 笔记本合上盖子时不进入休眠](https://blog.csdn.net/ezhchai/article/details/80548130)
打开终端：  
```
sudo vim /etc/systemd/logind.conf
```
然后将其中的：  
  
#HandleLidSwitch=suspend  
改成：  
  
HandleLidSwitch=ignore  
然后重启服务：  
```
sudo restart systemd-logind
```
或者  
service systemd-logind restart  
或者直接重启  
```
sudo shutdown -r now
```
即可使设置生效  
  
## 快速关机 待机
```
sudo shutdown -h now
sudo pm-suspend
```
  
$sudo gedit /etc/systemd/system.conf  
and change the timeout by uncommenting  on  
DefaultTimeoutStartSec=10s  
DefaultTimeoutStopSec=10s  
  
Save and close, then run  
$sudo systemctl daemon-reload  
  
and try a shutdown.  
- https://www.experts-exchange.com/questions/29053621/Slow-shutdown-in-Ubuntu-16-04.html
  
## boot磁盘满
```
sudo df -h
sudo du -h /boot
sudo apt-get remove linux-image-    tab键
```
http://blog.csdn.net/wxyangid/article/details/53097208  
  
## 壁纸Variety
```
sudo add-apt-repository ppa:peterlevi/ppa
sudo apt-get update
sudo apt-get install variety
```
  
  
## 提示/var/目录空间不够
   sudo mv /var/cache/apt/archives/* ~/Desktop/newfold  
## ubuntu开机自动启动设置
如果只是想开机时执行一些命令在背景运行, 而不是用到复杂的开机服务(例如可以暂停重启什么功能的), 可以这么做:  
  - 编辑/etc/rc.local, 在 exit 0 前面加入你要执行的命令,脚本. 注意, 这个是很早的执行阶段, 可能PATH没有设置好, 所以最好用绝对路径!!!再说一次, 绝对路径! 包括脚本内!
  - sudo crontab -e 进入计划事务编辑模式, 编辑计划, 加入这么一句@reboot /path/to/script. 这个可以加载比较多的指令了, 如果没有正常运行, 请用绝对路径.
  - 如果要执行的命令没有背景运行模式, 可以用nohup command > /dev/null 2>&1 &
一般的开机服务是定义在/etc/init.d里的东东, 图形管理界面可以使用sysv-rc-conf, 命令行可以使用service命令.  
## unbuntu加快开机速度
  :systemd-analyze blame  
查看到  
         33.587s NetworkManager-wait-online.service  
         21.164s docker.service  
          8.088s mysql.service  
          5.018s plymouth-start.service  
         ...  
执行  
   :sudo systemctl disable NetworkManager-wait-online.service  
   :sudo systemctl disable docker.service  
参考  
