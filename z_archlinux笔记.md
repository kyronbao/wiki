#+TAGS: @work @home @tennisclus
## 滚动更新
```
sudo pacman -Syu
```
  
## 从AUR安装包
首先下载 (也可以通过wget或curl下载tar包后解压)  
```
git clone https://aur.archlinux.org/wiredtiger.git
```
进入目录后查看  
```
less PKGBUILD
```
安装  
```
makepkg -si
```
  
## yaourt pacman 的前端模块（ a pacman frontend ）
什么是 yaourt  
yaourt 是一种命令行接口程序（ cli），使得用户可以在 Archlinux 上直接通过 yaourt 命令安装 AUR 源的程序。  
  
安装 yaourt  
简便的安装  
最简单安装Yaourt的方式是添加Yaourt源至您的 /etc/pacman.conf:  
  
[archlinuxcn]  
#The Chinese Arch Linux communities packages.  
SigLevel = Optional TrustAll  
Server   = http://repo.archlinuxcn.org/$arch  
同步并安装：  
  
```
sudo pacman -Syu yaourt
```
即可使用 yaourt 安装程序，例如我写博客使用的 markdown 编辑器 remarkable ：  
  
```
sudo yaourt remarkable
```
  
参考  
- https://www.cnblogs.com/chris-d-nerd/p/5902003.html
## Downgrading packages 软件包降级
- https://wiki.archlinux.org/index.php/downgrading_packages
