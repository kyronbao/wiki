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
  
# 参考  
- https://www.archlinux.org/mirrorlist/
- https://blog.csdn.net/u010456460/article/details/54292105 linux如何将新硬盘挂载到home目录下
- https://wiki.archlinux.org/index.php/Shadowsocks
