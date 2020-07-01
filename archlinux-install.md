  
# One
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
  
## Install zh_CN font  
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
  
## loadkeys  
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


# Two
## Install Gvim
gvim 支持剪贴板，可以使用"+y复制到系统剪贴板  
```
sudo pacman -Rs vim
sudo pacman -S gvim
```
  
## 来安装自动登陆程序gdm：
```
sudo pacman -S gdm
sudo systemctl enable gdm
sudo systemctl start gdm
```
  
如果enable gdm后希望后面停用自动登陆，可以使用USB启动后  
```
systemctl disable gdm
```
  
## 引导win10系统
前提：提前装好了win10系统  
```
sudo pacman -S os-prober
```
查看设备UUID (其中启动分区文件格式为vfat)  
lsblk -f  
  
挂载win10  
```
sudo mkdir -p /win10/boot
sudo mount /dev/sda2 /win10/boot
```
  
```
vim /boot/grub/grub.cfg
```
  
if [ "${grub_platform}" == "efi" ]; then  
	menuentry "Microsoft Windows Vista/7/8/8.1 UEFI/GPT" {  
		insmod part_gpt  
		insmod fat  
		insmod chain  
		search --no-floppy --fs-uuid --set=root $hints_string $fs_uuid  
		chainloader /EFI/Microsoft/Boot/bootmgfw.efi  
	}  
fi  
  
其中  
$fs_uuid取值方法  
```
sudo grub-probe --target=fs_uuid /win10/boot/EFI/Microsoft/Boot/bootmgfw.efi
```
$hints_string取值方法  
```
sudo grub-probe --target=hints_string /win10/boot/EFI/Microsoft/Boot/bootmgfw.efi
```
  
  
参考：  
https://wiki.archlinux.org/index.php/GRUB#Windows_installed_in_UEFI/GPT_mode  
https://wiki.archlinux.org/index.php/Dual_boot_with_Windows#UEFI_systems  
http://tech.memoryimprintstudio.com/dual-boot-installation-of-arch-linux-with-preinstalled-windows-10-with-encryption/  
  
## 环境设置：
  
字体  
使用pacman -Ss font搜索你喜欢的字体  
推荐安装：sudo pacman -S wqy-microhei  
输入法  
使用iBus：  
安装拼音：sudo pacman -S ibus-rime  
在.bashr末尾中加入以下参数：  
```
export GTK_IM_MODULE=ibus
export XMODIFIERS=@im=ibus
export QT_IM_MODULE=ibus
```
  
GNOME现在已经默认集成了IBus， 所以你只需要安装的输入法引擎并在  
Region & Language 添加输入rime源。  
默认切换输入法的快捷键是 Super-space, 配置输入法 ibus-setup，切换键改为shift(直接在输入框中填写shift 就可以成功)，退出重新登录生效。  
  
设置：  
Ctrl+` 选择简化字  
运行中可按F4设置  
  
```
vim .config/ibus/rime/build/luna_pinyin.schema.yaml
```
switches:  
  - name: ascii_mode
    reset: 1  # 启动时默认英文  
    states: ["中文", "西文"]  
half_shape  
  "/": "/"   # 中文时按/直接输入/  
  
  
## 添加硬盘
举例说明：  
新增磁盘的设备文件名为 /dev/sda 大小为500GB。  
fdisk -l  查看新增的的磁盘  
1、对新增磁盘进行分区（这一步如果使用cfdisk已经分区了可以忽略）  
fdisk /dev/sda  
按提示操作 p打印  n新增 d 删除 w操作生效 q退出  
操作后 w  
partprobe   强制让内核重新找一次分区表（更新分区表）  
这里我们新增一个分区 /dev/sda  大小为128GB  
  
2、分区格式化  
mkfs -t ext4 /dev/sda1  格式化为ext4格式  
3、将新硬盘临时挂载在一个目录下  
  
```
mkdir /mnt/kyron-Downloads
```
mount /dev/sda1 /mnt/kyron-Downloads  
df -h  查看  
```
cp -a /home/kyron/Downloads/* /mnt/home/kyron-Downloads  备份
```
rm -rf /home/kyron/Downloads/* 把原来的东西删干净  
umount /dev/sda1  卸载硬盘  
df -h  查看  
  
  
4、设置开机挂载  
```
vi /etc/fstab
```
末尾增加一行  
/dev/sda1  /home/kyron/Downloads  ext4  defaults  0  2  
保存退出  
df -h  查看  
  
mount -a 挂载/etc/fstab 中未挂载的分区  
df -h  查看  
发现成功挂载  
```
chown kyron:kyron /home/kyron/Downloads -R
```
  
  
同样挂载一个文件夹/zz 用来平常删除备份  
  
## 配置archlinux源
  
添加到文件/etc/pacman.conf  
[archlinuxcn]  
Server = https://cdn.repo.archlinuxcn.org/$arch  
去掉注释（安装wine时找不到源的解决方法）  
[multilib]  
Include = /etc/pacman.d/mirrorlist  
  
  
添加到文件 /etc/pacman.d/mirrorlist  
  
## China  
Server = http://mirrors.tuna.tsinghua.edu.cn/archlinux/$repo/os/$arch  
Server = https://mirrors.tuna.tsinghua.edu.cn/archlinux/$repo/os/$arch  
Server = http://mirrors.zju.edu.cn/archlinux/$repo/os/$arch  
## Japan  
Server = https://mirrors.cat.net/archlinux/$repo/os/$arch  
## Worldwide  
Server = http://mirrors.evowise.com/archlinux/$repo/os/$arch  
  
更新源  
```
sudo pacman -Syu
```
  
## 安装shadowsocks
```
sudo pacman -S shadowsocks-qt5
```
搜索打開後配置(开机启动,启动自动连接)  
参考  
```
vim /etc/shadowsocks/config.json
```
{  
    "server":"ip*******",  
    "server_port":****,  
    "local_address": "127.0.0.1",  
    "local_port":1080,  
    "password":"********",  
    "timeout":300,  
    "method":"aes-256-cfb",  
    "fast_open": false,  
    "workers": 1,  
    "prefer_ipv6": false  
}  
## 配置代理Privoxy
```
sudo pacman -S privoxy
```
  
```
sudo vim /etc/privoxy/config
```
修改下面两行，注意后面的.  
listen-address localhost:8118  
  
forward-socks5 / 127.0.0.1:1080 .  
  
启动服务  
```
sudo systemctl start privoxy.service
sudo systemctl enable privoxy.service
```
  
终端开启代理方法  
```
export http_proxy=”127.0.0.1:8118”
export https_proxy=”127.0.0.1:8118”
```
  
  
  
## 安装chrome
参考  
- https://linuxhint.com/install-google-chrome-on-arch-linux/
  
```
git clone https://aur.archlinux.org/google-chrome.git
cd google-chrome
makepkg -s
sudo pacman -U google-chrome-...
```
使用代理启动  
google-chrome-stable --proxy-server="http://127.0.0.1:8118"  
登陆书签同步  
  
設置代理 127.0.0.1 8118  
  
## 优化
### 防止ssh断开连接
/etc/ssh/ssh_config  
ServerAliveInterval 10  
  
### 取消gnome top bar
```
sudo pacman -S chrome-gnome-shell
```
安装  
hide top bar  
  設置靠近時出現效果  
  取消Intellihide的两个选项：这样在桌面全屏时也隐藏top bar  
Dash to Dock  
  設置menu大小  
  
### 关闭linux terminal 报警alert
```
vim /etc/inputrc
```
取消注释  
set bell-style none  
  
phpstorm  
```
sudo tar -zxvf Phpstorm.. -C /opt
```
搜索PHPStorm激活服务器  
http://idea.imsxm.com/(2017-04-24 可用)  
  
## 参考  
- https://www.archlinux.org/mirrorlist/
- https://blog.csdn.net/u010456460/article/details/54292105 linux如何将新硬盘挂载到home目录下
- https://wiki.archlinux.org/index.php/Shadowsocks

# Three
  
Terminal 透明  
```
git clone https://aur.archlinux.org/gnome-terminal-transparency.git
makepkg -si
```
  
壁纸  
```
sudo pacman -S variety
```
  
gnome插件  
  
鼠标回到桌面 Custorm Hot corners  
显示app菜单 Applications Menu  
TopIcons Plus  
  
开发常用  
nginx  
 /etc/nginx/nginx.conf  
            php.conf  
            site-avaibable/*  
```
php php-fpm composer
```
