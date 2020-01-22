  
## 安装之前
  
刻录usb安装盘，linux下使用dd刻录  
  
电脑设置usb启动，ThinkPad启动时按F1  
  
联网(wifi)  
  
方法一 通过手机联网(最简单)  
连接手机 - 开启USB网络共享 - 然后dhcpcd配置动态路有  
  
方法二 wifi-menu联网  
wifi-menu  
dhcpcd  
  
方法三 其他工具  
wpa_supplicant联网（wifi）  
wpa_passphrase Tenda_8 "xiaSHA0755**" > /etc/wpa_supplicant/wpa_supplicant.conf  
wpa_supplicant -B -i wlp3s0 -c /etc/wpa_supplicant/wpa_supplicant.conf  
查看网卡连接情况  
ip link  
ip address show  
扫描附近热点  
iw dev wlp3s0 scan  
  
测试网络  
ping baidu.com  
  
# Install zh_CN font  
```
sudo pacman -S wqy-microhei
```
  
## 磁盘分区和挂载
可以使用fdisk查看硬盘设备  
fdisk -l  
  
常见有BIOS和UEFI启动方式（UEFI是新BIOS架构，自从UEFI出来后，老的BIOS架构便被成为legacy，  
如果硬盘大于2T，电脑支持UEFI可以采用这个新的方案分区，对应的分区label是gpt)  
这里我使用BIOS启动方式，如果硬盘是新的，需要建立MBR分区  
parted /dev/sdb  
mklable gpt (if BOIS/MBR: mklabel msdos)  
quit  
  
为了较为简便地进行分区，我们选用cfdisk来进行分区。  
执行  
cfdisk  
进入界面，根据情况选择分区表，下面是我们的分区方案：  
设置一个分区 100M～3G（标记为boot）  
/dev/sdb1  
设置一个分区 大小与你的内存相等  
/dev/sdb2  
将剩余的空间都用于一个分区  
/dev/sdb3  
保存分区，退出  
  
在我们格式化之前，我们需要重启  
reboot  
或者执行下面命令强制让内核重新找一次分区表  
partprobe  
  
然后格式化硬盘：  
mkfs.vfat -F32 /dev/sdb1 (if BOIS/MBR:  mkfs.ext4 /dev/sdb1)  
mkswap /dev/sdb2  
mkfs.ext4 /dev/sdb3  
  
挂载分区  
swapon /dev/sdb2  
mount /dev/sdb3 /mnt  
  
```
mkdir -p /mnt/boot/efi
```
mount /dev/sdb1 /mnt/boot/efi  
至此，这部分完毕  
  
## 安装ArchLinux：
为了加速安装，我们添加清华大学的软件源  
```
vim /etc/pacman.d/mirrorlist
```
在开头添加：  
Server = http://mirrors.tuna.tsinghua.edu.cn/archlinux/$repo/os/$arch  
更新软件源  
pacman -Sy  
  
安装系统  
pacstrap /mnt base base-devel  
安装完成后建立挂载关系  
genfstab -U /mnt >> /mnt/etc/fstab  
检查挂载文件  
```
vim /mnt/etc/fstab
```
自此，系统就安装好了，但因为没有安装引导程序，切勿重启  
  
首先我们进入新安装的系统  
arch-chroot /mnt /bin/bash  
  
下载grub引导程序  
pacman -S grub efibootmgr  
然后在sdb设备上生成配置文件  
切记是sdb而不是sdb1  
grub-install --target=x86_64-efi --efi-directory=/boot/efi --bootloader-id=grub  
grub-mkconfig -o /boot/grub/grub.cfg  
  
(if BOIS/MBR:  
pacman -S grub  
grub-install /dev/sdb  
grub-mkconfig -o /boot/grub/grub.cfg  
)  
  
安装必要的工具  
pacman -S wpa-supplicant dialog vim  
备注：  
wifi-menu需要的依赖dialog, wpa-supplicant  
如此，安装彻底完成，现在我们可以重启了！  
  
## 配置ArchLinux：
配置语言环境  
使用nano编辑器编辑配置文件  
```
vim /etc/locale.gen
```
去掉注释并保存退出  
en_US.UTF-8  
zh_CN.UTF-8的  
然后生成编码  
locale-gen  
并配置优先为英文  
```
echo LANG=en_US.UTF-8 > /etc/locale.conf
```
  
配置时间  
rm /etc/localtime  
ln -s /usr/share/zoneinfo/Asia/Shanghai /etc/localtime  
使用date查看时间对不对  
date  
  
  
配置主机名  
```
echo ThinkPad > /etc/hostname
```
将ThinkPad替换为你的主机名  
  
配置root密码  
passwd  
  
创建用户  
```
useradd -m -G wheel -s /bin/bash kyron
```
然后设置密码  
passwd kyron  
将kyron替换为你的用户名  
为用户添加sudo权限  
安装sudo  
pacman -S sudo  
编辑sudo配置文件  
visudo  
将wheel用户组的权限注释去除  
按shift+zz保存退出  
使用切换用户测试sudo  
```
su kyron
```
  
## 安装桌面：
第一步安装xorg  
```
sudo pacman -S xorg xorg-xinit dbus
```
然后安装gnome  
```
sudo pacman -S gnome gnome-extra
```
gnome-extra可不安装  
安装完毕之后，拷贝一份xinit的初始化配置文件到用户目录下  
```
cp /etc/X11/xinit/xinitrc ~/.xinitrc
vim ~/.xinitrc
```
把从twm &开始到末尾的信息全部注释掉，然后添加gnome的启动参数  
exec gnome-session  
  
对root的配置文件也进行同样操作  
```
su root
cp /home/kyron/.xinitrc /root
```
  
# loadkeys  
```
sudo loadkeys us
```
  
安装intel显卡驱动  
```
sudo pacman -S xf86-video-intel xf86-video-fbdev
```
  
  
#turn off NVIDIA  
```
su
cd /sys/kernel/debug/vgaswitcheroo/
cp switch ~/install/switch.bak
echo OFF > /sys/kernel/debug/vgaswitcheroo/switch
```
  
接下来启动gnome  
startx  
如果不成功  
可以参考文章后面我的调试记录 error 1 2 3，或者google  
  
If success  
```
sudo systemctl start NetworkManager
sudo systemctl enable NetworkManager
```
  
Good Luck!!  
  
  
## starx时错误的调试xorg记录
startx  
```
vim /path/log-file
```
查找EE对应的报错  
  
### error 1
keysym xf86monbrightnessup ...  
  
google得知是键盘映射的问题  
参考install wiki  
```
ls /usr/share/kbd/keymaps/**/*.map.gz
```
loadkeys us  
  
### error 2
[ 1600.687] [drm] failed to load kernel module "nouveau"  
[ 1600.687] [drm] failed to load kernel module "nv"  
[ 1600.687] (EE) [drm] failed to open device  
[ 1600.687] (EE) No devices detected.  
这里调试了好久，最终得知我我的电脑有双显卡的问题，最终参考  
- https://coolrc.me/2016/11/28/28115748/ Arch禁用nvidia独显
  
bbswitch 可以帮助你禁用N卡，首先安装 bbswitch  
```
sudo pacman -S bbswitch dkms
```
  
然后设施 bbswitch 开机自动加载：  
```
sudo echo "bbswitch" >> /etc/modules-load.d/modules.conf
```
  
设置 bbswitch 启动参数并禁用nouveau  
```
sudo echo "options bbswitch load_state=0" >> /etc/modprobe.d/bbswitch.conf
sudo echo "blacklist nouveau" >> /etc/modprobe.d/nouveau_blacklist.conf
```
  
然后重建 initrd  
mkinitcpio -p linux  
其他发行版可能是 mkinitrd命令  
  
执行完成后重启电脑。  
reboot  
or  
startx  
备注:如果startx不成功可以测试下  
```
sudo pacman -S nvidia
```
执行 lspci 或 lspci | grep NVIDIA 查看效果，如果N卡后面显示 (rev ff) ，表明已经成功禁用。  
（备注：虽然我重启后还是显示rev ff，但是startx可以成功加载gnome了）  
  
### error 3
(EE) /dev/fb0: Permission denied  
这是xorg-server的一个相关错误（X server doesn't run as root any longer）  
```
vim /etc/X11/Xwrapper.config
```
needs_root_rights = yes  
  
## 参考
- [Arch安装完全指南](https://lexuge.github.io/jekyll/update/2017/03/24/Arch%E5%AE%89%E8%A3%85%E5%AE%8C%E5%85%A8%E6%8C%87%E5%8D%97.html)
- [archlinux安裝手记（Win10+Arch、GPT+UEFI、lvm）](https://www.cnblogs.com/unkownarea/p/6472461.html)
- https://wiki.archlinux.org/index.php/installation_guide
- https://wiki.archlinux.org/index.php/Network_configuration
- https://wiki.archlinux.org/index.php/GNOME#Network
- [如何在Arch Linux的终端里设定WiFi网络](http://os.51cto.com/art/201611/520832.htm)
- https://wiki.archlinux.org/index.php/Xorg
