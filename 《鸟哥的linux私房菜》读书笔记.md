* linux 鸟哥  
* 基础篇  
* 5	首次登入与在线求助 man page  
重启X Window    C-M-<del>  
X Window 与 terminal 切换         C-M-[F1]~[F6] C-M-[F7]  
注销            exit  
修改语系        echo $L其他ANG    $LANG=en_US.UTF-8  
命令            date +%Y/%m/%d ;;   date +%H:%M  
man  
  查找			man -f man    whatis  
  关键词查找	man -k manual    apropos  
  whatis apropos 不能用时, sudo makewhatis建立数据库  
  
关机十分钟后     shutdown -h +10  
日历            cal 5 2017  
计算器          bc  
  
* 6 Linux 的档案权限与目录配置  
  
目录的 w 权限代表目录下的文件名可以变动(移动、删除等)  
目录的 x 权限代表目录下文件的读取、修改、执行  
文件的 w 权限不包括新建删除  
文件的读取需要文件的 r 权限 和 目录的 x 权限  
  
drwx------ /home/arpher/demo/ 下的所有文件其他人不能读取  
  
根目彔下与开机过程有关的目彔, 就不能够与根目彔放到不同的分割槽去  
 /etc:配置文件  
 /bin:重要执行档  
 /dev:所需要的装置档案  
 /lib:执行档所需的函式库不核心所需的模块  
 /sbin:重要的系统执行文件  
  
查看核心版本 uname -r  
查看distribution信息 lsb_release -a  
  
* 7 Linux 档案与目录管理  
  
```
cd - 回到上一个目录
```
pwd -P 显示链接的实际地址  
```
mkdir -p test1/test2/test3 建立多级递归目录
mkdir -m 755 test 建立自定义权限的目录
```
  
rmdir -p test1/test2/test3 删除递归目录  
rm -r test1 删除所有的内容  
  
```
cp -i 复制时询问是否覆盖
cp /bbbb -r /test  复制文件夹
cp -a /bbbb -r /test 备份文件夹，保留属性
```
   -u 有差异才复制，用于备份
   -d 是链接时 复制链接，不加-d默认复制实物
   -s 软链接
   -l 硬链接
  
取得路径文件名与目录名称  
basename /etc/hosts  文件名  
dirname /etc/hosts   路径  
  
查看文档cat head tail nl(显示行号)  
查看二进制 od -t oCc /etc/issue  
  
```
touch 可以修改时间
```
  
umask 0002 -------w-  
文件 默认 rw-rw-rw- 666 相减后默认新建值为 rw-rw-r-- 664  
目录 默认 rwxrwxrwx 777 相减后默认新建值为 rwxrwxr-x 775  
  
观察文件类型:file  
  
命令的搜寻:  
which ls 列出PATH中的命令  
  可以看到某个系统命令是否存在，以及执行的到底是哪一个位置的命令  
  -a 列出所有的
  
type cd 搜bash内建命令(可以取代which)  
  区分某个命令到底是由shell自带的  
  -p 如果一个命令是外部命令，那么使用-p参数，会显示该命令的路径，相当于which命令
  type apache2  
  
程序名搜索  
whereis ifconfig 寻找特定档案(无选项搜所有的)  
  -b 二进制  -m manual下文档 -s source来源档案
  whereis apache2  
  
搜索 locate passwd  
  更新数据库 updatedb  
  locate -r apache2 | grep conf  
  locate -r car | grep php  
  
find  
 -mtime
 +4 代表大亍等亍 5 天前的檔名:ex> find /var -mtime +4  
 -4 代表小亍等亍 4 天内的档案档名: find /var -mtime -4  
 4 则是代表 4-5 那一天的档案档名: find /var -mtime 4  
  
 -newer
find /var/www/sz.rr/hourlyrate-admin/php/Application/ -newer /var/www/sz.rr/hourlyrate-admin/php/Application/Admin/Conf/config.php  
find /etc -newer /etc/passwd  
  
find /home -user arpher  
find / -nouser  
  
```
sudo find /var -name config.php
sudo find / -type s
sudo find / -type s -exec ls -l {} \;   找socket文件
sudo find / -perm -4000 -exec ls -l {} \;  找隐藏SUID权限的文件
sudo find /var -name '*Car*'
```
  s socket  f 正规文档 ...  
  
examle 假设系统中有两个账号,分别是 Jim 与 Tom ,这两个人除了自己群组外还共同支持  
一个名为 project 的群组。假设这两个用户需要共同拥有 /srv/ahome/ 目录的开发权,该目录限制  
其他人进入查阅  
  
groupadd project  
```
useradd -G project Jim
useradd -G project Tom
```
  
```
mkdir /srv/ahome
```
chgrp project /srv/ahome  
```
chmod 2770 /srv/ahome     0->其他人不能查看 77->同组内可以新建 2->SGID 新建的文件的组属于文件组
```
  
* 8 Linux 磁盘与文件系统管理  
  
查看文件系统的大小  
df -h /usr  查看对应的设备  
  -h human
  -i 显示inode
  -T 文件类型
df -h  
  /dev/shm/ 目彔,其实是利用内存虚拟出来的磁盘空间  
  
查看目录的大小(含文件系统(鸟哥))  
```
sudo du -hs /*
sudo du -hs /usr
```
  -s summry总和
  
链接  
ln bbbb.c bbbb.h  
  硬链接，删除源文件后不影响  
  实体链接叧是多了一个文件名对该 inode 号码的链接而已  
ln -s bbbb.c bbbb.s  
  软链接，相当与快捷图标  
  
查看设备分区的大小  
fdisk -l  
  
磁盘分区查看老版笔记  
  
* 9 档案与文件系统的压缩与打包  
gzip context.txt  压缩  
gzip -d context.txt.gz 解压  
zcat context.txt.gz  
  
gzip 压缩  
  context.txt.gz  
  -d 解压
  zcat 查看  
  vim 查看编辑  
  
bzip2 压缩  
  context.txt.bz2  
  -d 解压
  bzcat 查看  
  vim 编辑  
  
```
tar 打包
```
  tar -zcvf dir/ dir.tar.gz 压缩  
  tar -ztvf dir.tar.gz 查看  
  tar -zxvf dir.tar.gz 解压  
  
  tar -jcvf dir/ dir.tar.bz2 压缩  
  tar -jtvf dir.tar.bz2 查看  
  tar -jxvf dir.tar.bz2 解压  
  
  -C 解压缩到目录
  -p 保留权限属性
  
```
tar -jxvf dir.tar.bz2 dir/bbbb.txt 只解压一个
```
  
dd 可以备份整个文件系统(disk)  
  sudo dd if=/dev/sdb1 of=./boot.dd.bak  
  也可以直接复制设备，先fdisk 一个相同或稍大的分区/dev/sdb6  
    sudo dd if=/dev/sdb1 of /dev/sdb6  
  
其他备份命令dump cpio  
  其他备份命令dump cpio其他备份命令dump cpio  
  
ni meng ye shi zui le  
其他备份命令dump cpio其他备份命令dump cpioyy  
ni meng ye shi zui le  
  
其他备份命令dump cpio其他备份命令dump cpio bbbbbbbbbbb  
  
* 10 vim  
* 11 认识与学习 BASH  
  
alias  
  
```
echo
```
变量名 PATH HOME LANG RANDOM  
mystr=bbbb  
mystr2="lang is $LANG"  
mystr3='lang is $LANG'  
  
version=$(uname -r)  
version2=`uname -r`  
扩增变量  
PATH="$PATH":/home/bin  
mystr=${mystr}cccc  
若该变量需要在其他子程序执行,则需要以 export 来使变量变成环境变量:  
```
export mystr
```
bash  进入子程序  
```
echo $mystr 生效
```
exit  
取消变量  
unset mystr  
如何进入到您目前核心的模块目录  
```
cd /lib/modules/$(uname -r)/kernel
```
  
```
ls -l `locate crontab`
```
  
设置常用工作目录  
job=/var/www  可以写入bash配置文件  
```
cd $job
```
  
env  输出环境变量  
  
declare 声明变量类型  
打印0-9随机数  
declare -i number=$RANDOM*10/32768 ; echo $number  
  
用 set 观察所有变量 (含环境变量与自定义变量)  
  
变量  
```
关于本shell的PID
```
? 上个执行指令的回传值 0 或 其他值  
OSTYPE, HOSTTYPE, MACHTYPE:(主机硬件与核心的等级)  
export: 自定义发量转成环境发量  
影响显示结果的语系发量 (locale)  
  whereis locale  
发量癿有效范围  
发量键盘读取、数组与声明: read, array, declare  
与文件系统及程序的限制有关系: ulimit  
  
变量内容的删除，取代与替换  
```
echo ${path#/*arpher/bin:}  path变量从前面删除到arpher/bin:
```
  # 从前面开始删  
  * 通配符  
```
echo ${path##/*:}  删掉/和最后一个:之间内容
```
  ## 从前面贪婪删除  
```
echo ${path%:/*bin} 从后面开始删
```
  % 从后面开始删除  
  %% 从后面贪婪删除  
  - = ?
  
alias unalias  
clear  
history  
  alias hs='history 20'  
  
!2044  
!vi  执行最近的命令  
  
bash的环境配置文件  
  
login_shell  
  
/etc/profile  
/etc/profile.d/*.sh  
  
1. ~/.bash_profile  
2. ~/.bash_login  
3. ~/.profile  
  
```
source :读入环境配置文件的指令
```
  
~/.bashrc  
/etc/manpath.config 设置tar格式软件的manpath  
  
~/.bash_history  
~/.bash_logout  
  
终端机的环境设定: stty, set  
  
stty -a  
/etc/inputrc  
  
编写命令的快捷键  
  
和emacs相似  
C-s 暂停屏幕输出  
C-q 恢复屏幕输出  
  
bash的特殊字符  
  # $ [] ^ * ? ;  
  
数据流重导向  
  
  > < >> <<  
  
待学的管线命令  
  
cut, grep, sort, wc, uniq, tee, tr, col, join, paste, expand, split,  
xargs  
  
* 12 正则表示法与文件格式化处理  
文件夹中找单词 grep 'article' Documents/php/learnlaravel5/app/Http/Controllers/*  
  
```
wget http://linux.vbird.org/linux_basic/0330regularex/regular_express.txt
```
  
```
grep -n 'the' regular
```
  n 显示行号  v 显示不包含the的行 i不区分大小写  
  搜 test 或 taste   -n[t?st]  
  
```
grep -n '[0-9]' regular_express.txt
```
  
[:alnum:] 0-9, A-Z, a-z  
[:alpha:] A-Z, a-z  
[:digit:] 0-9  
[:lower:] a-z  
  
```
grep -n 't[ae]st' regular_express.txt
grep -n '[^g]oo' regular_express.txt
grep -n '[^a-z]oo' regular_express.txt
grep -n '[0-9]' regular_express.txt
grep -n '[^[:lower:]]oo' regular_express.txt
grep -n '^the' regular_express.txt
grep -n '^[a-z]' regular_express.txt
grep -n '^[^a-zA-Z]' regular_express.txt  ^在[]里面表示非，在外面表示行首
grep -n '\.$' regular_express.txt
cat -nv regular_express.txt | head -n 10 | tail -n 6 显示6行截止到第10行
grep -n '^$' regular_express.txt 搜空白行
```
  
```
grep -v '^$' /etc/syslog.conf | grep -v '^#' 输出没有空格和#注释的行
```
  
```
grep -n 'g..d' regular_express.txt   . 一定有一个任意字符
grep -n 'g.*g' regular_express.txt   * 重复前一个 0 到无穷多次
grep -n 'o\{2\}' regular_express.txt  oo
grep -n 'go\{2,5\}g' regular_express.txt  2 到 5 个 o
grep -n 'go\{2,\}g' regular_express.txt  2 个 o 以上
```
  
  
sed 工具  
  
nl /etc/passwd | sed '2,5d'    d 删除  
nl /etc/passwd | sed '2a drink tea'   在第二行后(亦卲是加在第三行)加上『drink tea?』  
nl /etc/passwd | sed '2a Drink tea or ......\  
> drink beer ?'                        添加多行  
nl /etc/passwd | sed '2,5c No 2-5 number'  2-5 行癿内容叏代成为『No 2-5 number』  
nl /etc/passwd | sed -n '5,7p'   仅列出 /etc/passwd 档案内癿第 5-7 行  
  
sed 's/要被叏代癿字符串/新癿字符串/g'  
mac ifconfig 取出ip  
ifconfig | grep 'inet ' | sed 's/inet //g' | sed 's/ netmask.*//g'  
取出 MAN行的 不带注释#的  
```
cat /etc/man.conf | grep 'MAN' | sed 's/^#.*//g' | sed '/^$/d'
```
  
直接修改档案内容(危险劢作)  
  
  
延伸正觃表示法  
egrep -v '^$|^#' regular_express.txt  去除穸白行不行首为 # 癿行列  
  
+ 重复『一个戒一个以上』癿前一个 RE 字符  
? 『零个戒一个』癿前一个 RE 字符  
\| 用戒(or)癿方式找出数个字符串 egrep -n 'gd|good' regular_express.txt  
()找出『群组』字符串  egrep -n 'g(la|oo)d' regular_express.txt  
()+ 多个重复群组癿判别 echo 'AxyzxyzxyzxyzC' | egrep 'A(xyz)+C'  
  
格式化打印: printf  
  
me Chinese English Math Average  
DmTsai 80 60 92 77.33  
VBird 75 55 80 70.00  
Ken 60 90 70 73.33  
  
printf '%s\t %s\t %s\t %s\t %s\t \n' $(cat printf.txt)  
printf '%10s %5i %5i %5i %8.2f \n' $(cat printf.txt |\  
> grep -v Name)  
  
awk 比较倾向亍一 行当中分成数个『字段』杢处理  
 last -n 5 | awk '{print $1 "\t" $3}'   取出账号不登入者癿 IP  
  
  
发量名称 代表意义  
NF 每一行 ($0) 拥有癿字段总数  
NR 目前 awk 所处理癿是『第几行』数据  
FS 目前癿分隔字符,默讣是穸格键  
  
last -n 5| awk '{print $1 "\t lines: " NR "\t columes: " NF}'  
```
cat /etc/passwd | \
```
> awk '{FS=":"} $3 < 10 {print $1 "\t " $3}'  
  
```
cat /etc/passwd | \
```
> awk 'BEGIN {FS=":"} $3 < 10 {print $1 "\t " $3}'  
  
```
cat pay.txt | \
```
> awk 'NR==1{printf "%10s %10s %10s %10s %10s\n",$1,$2,$3,$4,"Total" } NR>=2{total = $2 + $3 + $4  
printf "%10s %10d %10d %10d %10.2f\n", $1, $2, $3, $4, total}'  
  
diff old new  
  
cmp 字节比较 常用于包的比较  
  
patch 常用于版本升级  
```
cp print.txt print2.txt
vim print2.txt
```
 添加 Jim 80 90 80 83.33  
diff -Naur printf.txt printf2.txt > printf2.patch  生成patch文件  
patch -p0 < printf2.patch 升级print.txt  
 -p0 指同一目录下
  
pr /etc/man.conf  分页打印  
  
  
demo  
搜索/etc 目录含有*的文件  
```
grep '\*' /etc/*
```
搜索/etc所有目录含有*的文件  
find / -type f | xargs -n 10 grep '\*'  
a. 先用 find 去找出档案;  
b. 用 xargs 将这些档案每次丢 10 个给 grep 杢作为参数处理;  
c. grep 实际开始搜寻档案内  
  
find / -type f | xargs -n 10 grep -l '\*'  
只搜档案名  
  
想要有个新发量,发量名为 MYIP ,这个发量 可以记彔我癿 IP  
alias myip="ifconfig | grep 'inet ' | sed 's/inet //g' | sed 's/ netmask.*//g' | grep '10.8'"  
MYIP=$(myip)  
如果每次登入都要生效,可以将alias不MYIP癿讴定那两行,写入你癿~/.bashrc卲 可!  
  
* 15 磁盘配额quota LVM  
## quota实践
首先磁盘分区 /dev/sda2 /home  
操作 用virtual box安装ubuntu16  
可以用 df -h /home 查看  
建立用户和密码  
groupadd mygrp  
```
useradd -g mygrp user1
```
...  
```
sudo passwd user1
```
...  
加入quota支持  
```
vim /etc/fstab
```
  LABEL=/home /home ext3 defaults,usrquota,grpquota  
  
mount -a 重新挂载  
mount -fav 检查/etc/fstab 是否正确  
  
检查  
```
sudo quotacheck -avug  查得 /home 支持先不管报错
```
ll /home/   查得quota的记录文件 aquota.user aquota.group  
  
## LVM实践
--扩容LVM--
  
首先virtual box 安装ubuntu server默认LVM  
virtual box添加2GB硬盘  
分割500M lvm  
  fdisk /dev/sdb  
  n新建 p(primary) 回车 +500M   t修改类型  8e(LVM类型) w写入  
  
```
sudo partprobe
```
  
查看sudo fdisk -l  
  
建立新的PV  
  sudo pvcreate /dev/sdb1  
  查看VG vgscan vgdisplay  
添加/dev/sdb1到VG(volume group)  
  vgextend ubuntu-vg /dev/sdb1  
  查看 vgdisplay 查看里面的free PE有130个PE  
放大LV 添加VG里free PE到LV中  
  查看LV名字 sudo lvdisplay 查得LV名字/dev/ubuntu-vg/root  
  放大 lvresize -l +130 /dev/ubuntu-vg/root  
  再次查看 sudo vgdisplay VG的free PE变为0  
          sudo lvdisplay LV size 变大8.5为9.10G  
          df -h /  查得文件系统仍然是8.3G,没有变化  
放大文件系统  
  先查看 dumpe2fs /dev/ubuntu-vg/root 共Group67  
  將完整的LV容量扩充到文件系统 resize2fs /dev/ubuntu-vg/root  
  查看 df -h / 增为8.8G 扩容成功  
       dupme2fs /dev/ubuntu-vg/root Group增至72  
  
总结先fdisk实体分割，然后PV->VG->LV 可以分别加上display查看  
    最后用resize2fs扩容文件系统  
  
  
--缩小LVM--
去掉挂载到/mnt/lvm的sdb5  
查看sudo pvscan    sudo pvdisplay 查得sdb1 total PE 12个 200M  
  df -h /mnt/lvm    查得659M  
  算得减少容量后659M-200M=459M  
  
```
sudo resize2fs /dev/ubuntu-vg/root 450M    用0.45G貌似不行
```
  提示 /dev/ubuntu-vg/root is mount on /mnt/lvm  
  
umount /mnt/lvm  
执行resize2fs 再次提示 Please run 'e2fsck -f /dev/arphervg/arpherlv' first.先检查磁盘  
于是先检查磁盘，然后umount  
再次执行resize2fs成功  
然后重新挂载 sudo mount /dev/arphervg/arpherlv /mnt/lvm  
  查 df -h /mnt/lvm  变为428M 成功  
  发现原来/mnt/lvm的文件消失了  
  
查vgdisplay 得VG size 688MB  
  lvdisplay 得LV size 688MB  
  pvdisplay 的sdb5的free PE 12个 共200MB  
    加入sdb5的free PE 为0  另外有sdb6的free PE 12个 都大小200MB要卸掉sdb5的话  
       参考鸟哥的pvmove /dev/hda6 /dev/hda10  
       pvmove /dev/sdb5 /dev/sdb6 可以把sd5的PE移到sd6上  
       然后可以將/dev/sdb5 移除arphervg  
降低lv vg容量  
  sudo lvresize -l -12 /dev/arphervg/arpherlv   sdb5有12个PE  
  將/dev/sd5移出arpherlv  
    sudo vgreduce arphervg /dev/sdb5  
  然后查看 sudo vgdisplay 得VG size 496MB成功  
          sudo pvdisplay 得 /dev/sdb5 is new physical volume 成功  
  
  
--新增lvm--
查看sudo fdisk -l  
  先分好 /dev/sdb2  
建立新的PV  
  sudo pvcreate /dev/sdb2  
  查看sudo pvscan  
建立新的VG  
  將sdb2建成vg  
  参考 vgcreate -s 16M vbirdvg /dev/hda{6,7,8}  
    指定PE为16M,  
  sudo vgcreate -s 16M arphervg /dev/sdb2  
  查sudo -vgdisplay 得Total PE为31  
建立新的LV  
  sudo lvcreate -l 31 -n arpherlv arphervg  
  -l PE的数量 -n lv的名字
格式化，挂载lv  
  先查看文件系统格式 df -hT  
  sudo mkfs -t ext4 /dev/arphervg/arpherlv  
  
  mkdir /mnt/lvm  
  sudo mount /dev/arpher/arpherlv /mnt/lvm  
  
  查看 sudo lvscan  
       sudo lvdisplay  
       df -h       sudo fdisk -l  
  
* 17 程序管理与SELinux初探  
  
C-z 暂停程序  
jobs 查看暂停程序  
fg %1 恢复到前台执行(% 可有可无)  
bg %1 在后台变为running  
  
前面的只针对C-c有效而已，假如通过远程终端的在后台执行  
nohup ./sleep500.sh &  
  
强制删除 kill -9 %2  
  
```
ps aux 观察系统所有的程序数据
ps -lA 也是能够观察所有系统的数据
ps axjf 连同部分程序树状态
```
  
```
ps -l 仅观察自己的 bash 相关程序
```
  
查看程序pid  
```
ps aux | grep httpd
ps axjf | grep apach2 以程序树查看
```
  
pstree -p 02043 查看pid的相关依赖程序  
  
kill -signal 2043  
信号查看 kill -l  
 -1 启动 -9 强制删除 -15 默认正常删除
  
删除服务 killall -9 httpd  
-i 交互询问是否删除
  
调整程序优先级  
nice -n 6 vim eeee.txt 新建程序时调整优先级  
renice 5 2064 调整现有程序优先级  
  nice 范围为 -20 ~ 19 ;  
  root 可随意调整自己戒他人程序的 Nice 值,且范围为 -20 ~ 19 ;  
  一般用户仅可调整自己程序的 Nice 值,且范围仅为 0 ~ 19 (避免一般用户抢占系统资源);  
  
free 观察内存使用情况  
注意swap 使用情况，一般来说，swap最好不要被使用，效能跟物理内存差很多  
  
uname:查阅系统与核心相关信息  
uname -a  
  
uptime 观察系统启动时间与工作负载  
  
netstat 列出目前系统已经建立的网络联机与unix socket状态  
使用 n 时, netstat 就不会使用主机名不服务名称 (hostname & service_name) 来显示, 取而代之的则是以 IP 及 port number 来显示的  
  
哪些服务『目前』是在启动的状态?  
可以透过 services --status-all,戒者是透过 netstat -anl 等方式。也可以透过 pstree 去查询喔! 只是相关对应 的服务 daemon 档名就得要个别查询了。  
  tcp wrappers 软件功能不 xinetd 的功能中,可以使用哪两个档案迚行网络防火墙的控管? /etc/hosts.{allow,deny}  
  
* 架构篇  
* 1 网络基础  
  
命令 route  arp  
ARP  Address Resolution Protocol 网络地址解析  
ICMP  Internet Control Messege Protocol 英特网信息讯息控制协议  
本机dns文件 /etc/recolv.conf  
  
* 4 连上internet  
  
观察核心捕捉的网卡信息  
dmesg | grep -in eth 查得 e1000e模块 1000Mbps  inter  
  
查询相关设备芯片数据  
lspci | grep -i eth 查得I218-v设备  
  
查询核心是佛顺利载入模块  
lsmod | grep e1000e  
  
查询模块信心  
modinfo e1000e  查得filename驱动程序目录  
  
查询网卡卡号 ifconfig  
  
  
  
  
  
  
  
  
  
* 5 Linux 常用网络命令  
Ubuntu是一个依赖于网络的系统，没有网何止我们活不了，他也活不下去。那在虚拟机里的Ubuntu要是连不上网了，该怎么办呢？  
首先明确一下，网络的问题是复杂的，并不能保证一剂猛药直戳病灶，立马康复，而可能由方方面面的各种原因所造成，我们要做的，是淡定，对病情保持乐观心态，然后将可能的情况一一排查。来看：  
第一，检查网线。有人会对此不屑一顾，但是也有人搞了2小时之后发现网线没插紧而胸闷气喘的。另外必须确认windows主机能上网。  
  
第二，检查VMware的网络配置方式，具体而言，如果你所在的网络可以允许你拥有多个独立IP，那么推荐设置为桥接（Bridged）模式。如果你所在的网络只能允许你拥有一个IP，那么推荐设置为NAT模式。  
  
第三，正确配置Ubuntu的IP地址，IP地址的设置有两种方式，一种是固定IP，一种是自动获取IP，如果是固定IP，请确保 /etc/network/interfaces 有如下内容：  
其中 address、netmask 和 gateway 分别是IP地址、子网掩码和网关地址，注意要设置成你自己的网络环境，可别照我的抄！  
如果是自动获取IP，就更简单了，确保 /etc/network/interfaces 里的内容如下：​  
眼尖的同学看到了没，就是将static改成dhcp，就由原来的静态固定IP改成动态自动获取IP。  
第四，正确地配置DNS服务器，确保 /etc/resolv.conf 里面有如下语句：  
nameserver 202.96.134.133  
配置DNS服务器需注意，上述 202.96.134.133 的服务器地址仅限于华南地区，北方地区需要自行百度距离更近的服务器。另外 nameserver 语句可以写多句，相当于备用DNS。  
第五，确保配置了正确的网关地址，比如你所在网络的网关地址是192.168.1.1，那么可以执行如下命令：  
```
sudo route add default gw 192.168.1.1
```
  
第六，重新启动网络服务，命令如下：  
```
sudo /etc/init.d/networking reload
sudo /etc/init.d/networking restart
```
一般而言，到此网络就应该能联网了，如果还不行，再继续尝试如下方法：  
  
1 重新启停虚拟网卡：  
      sudo ifconfig eth0 down  
      sudo ifconfig eth0 up  
2 重新启动Ubuntu：  
      sudo shutdown -r now  
http://blog.csdn.net/vincent040/article/details/51148677  
  
常用命令  
ifconfig  
route  
ip 兼顾上面两个命令 还可以改eth0名字 和mac地址  
traceroute  
  
netstat  
秀出目前已启动的网络  
```
sudo netstat -tulnp
```
 -l 显示listen的端口
观察本机所有网络程序的联机状态  
```
sudo netstat -atunp
```
  例如可以查看运行的 ftp 为ESTABLISHED  
列出在监听的网络服务  
  sudo netstat -tunl  
列出已联机的网络联机状态  
  sudo netstat -tun  
删除已建立或在监听中的联机  
  kill -9 pid号  不用killall 可能误删别人运行的相同服务  
  
  查看程序通过脚本关闭-centos  
  sudo netstat -atulnp | grep 5793 得ftp  
  type ftp 得 /usr/bin/ftp  
  rpm -qf /usr/bin/ftp  或 dpkg -s ftp 或 查软件安装位置 dpkg -L ftp  
  rpm -qc ftp | grep init  或 dpkp -S ftp | grep init  
  更多dpkg操作http://www.cnblogs.com/forward/archive/2012/01/10/2318483.html  
  
netstat 更多参考http://blog.csdn.net/xad707348125/article/details/46804649  
  
sar命令可以从文件的读写情况、系统调用的使用情况、磁盘I/O、CPU效率、内存使用状况、进程活动及IPC有关的活动等方面进行报告  
  
nmap  
  扫描本机启用的接口 仅TCP  
nmap localhost  
  扫描本机启用的接口 TCP+UDP  
```
sudo nmap -sTU localhost
```
  如果要扫描区网内的主机  
localhost换成192.168.0.0/24  
  
  
  
  
检查主机名的ip  
host www.baidu.com  
  通过/etc/resove.conf 的dns的ip查的  
host www.baidu.com 168.95.1.1 通过这条ip查的baidu的ip  
  
查ip的主机名  
nslookup 168.95.1.1  
  
  
ftp ftp.ksu.edu.tw  
用户名anonymous 密码空  
命令 help ls cd get put bye  
  图形化工具gftp  
  
图形化通讯工具pidgin 支持msn gtalk....等  
  
文字浏览工具 links  
文字下载工具 wget  设置proxy 等配置 /etc/wgetrc  
  
  
tcpdump  
```
sudo tcpdump -i lo -nn
```
  测试ssh localhost 可以看到三次握手  有seq ack字样  
```
sudo tcpdump -i lo -nn -X 'port 21'
```
  测试ftp localhost 可以看到到明文USER arpher PASS 字样  
  
wireshark  
安装 根据提示 sudo apt install wireshark-..  
  
dumpcap需要root权限才能使用的,以普通用户打开Wireshark  
  
1.添加wireshark用户组  
```
sudo groupadd  wireshark
```
2.将dumpcap更改为wireshark用户组  
```
sudo chgrp wireshark /usr/bin/dumpcap
```
3.让wireshark用户组有root权限使用dumpcap  
```
sudo chmod 4755 /usr/bin/dumpcap
```
4.将需要使用的普通用户名加入wireshark用户组  
#sudo gpasswd -a arpher wireshark  
  
参考https://wiki.wireshark.org/CaptureSetup/CapturePrivileges  
https://anonscm.debian.org/viewvc/collab-maint/ext-maint/wireshark/trunk/debian/README.Debian?view=markup  
http://jingyan.baidu.com/article/c74d60009d992f0f6a595de6.html  
  
关闭时报错 .config/wireshark/ 里文件无权限  
```
sudo chgrp -R arpher ./
sudo chown -R arpher ./
```
  
  
nc工具  
  
  
  
* 7 网络安全  
* 9 防火墙与NAT服务器  
* 10 ssh  
```
ssh -f arpher@47.90.85.241 find / bbbb &> ~/find.log 在本地生成find.log
```
-f 远程执行，不需要等待
* 20 www服务器  
## unbutu-lamp配置记录
  
安装ubuntu版chkconfig  
  sudo apt install sysv-rc-conf   成功  
执行 sysv-rc-conf --list  
  报错  perl: warning: Setting locale failed.  
  解决  sudo apt-get install language-pack-zh-hans  
  
查看目录  
  
查询 sudo dpkg -L apache2  
apache 启动文件  
/usr/sbin/  有apachectl 和apache2ctl  
用diff 检查发现相同，是apache2的启动脚本  
登录server后 ll /usr/sbin/apache* 发现apachectl是apache2ctl的软链接  
  
mysql配置文件地址  
ll /usr/mysql/  
  my.cnf -> /etc/alternatives/my.cnf  
ll /etc/alternatives/my*  
  /etc/alternatives/my.cnf -> /etc/mysql/mysql.cnf  
  
php配置文件  
```
vim /etc/php/7.0/apache2/
```
  
php是否支持mysql  
```
vim /etc/php/7.0/mods-available/
```
  
  
  
  
  
  
## centos-lamp
yum安装 改mysql为mariadb  
yum install httpd mariadb mariadb-server php php-mysql  
查询安装位置  
rpm -ql mariadb  
  
httpd配置  
```
vim /etc/httpd/conf/httpd.conf
```
  
php配置  
```
vim /etc/php.ini
```
register_argc_argv = Off  
  
log_errors = On  
ignore_repeated_errors = On  
ignore_repeated_source = On  
  
display_errors = Off  
display_startup_errors = Off  
  
查询ip  
ip address  
  
虚拟机调试  ，桥接模式  
  
1、关闭firewall：  
```
systemctl stop firewalld.service #停止firewall
systemctl disable firewalld.service #禁止firewall开机启动
```
firewall-cmd --state #查看默认防火墙状态（关闭后显示not running，开启后显示running)  
  
测试  
/usr/sbin/httpd 为实际程序  
/usr/sbin/apachectl 脚本  
apachectl configtest  
  
自动启动  
执行chkconfig 和chkconfig按提示  
```
systemctl enable httpd.service
systemctl list-unit-files | grep httpd
```
测试  
没有netstat命令 安装yum install net-tools  
netstat -tulnp | grep httpd 成功  
ip address 代替ifconfig  
宿主机 http://192.168.0.106  
  
```
vim /var/www/html/phpinfo.php
```
<?php phpinfo();  
测试 http://192.168.0.106/phpinfo.php  
  
其他模块 安装yum install httpd-manual  
测试 http://192.168.0.106/manual  
mrtg:利用类似绘图软件自动产生主机流量图表的软件;  
mod_perl:让你的 WWW 服务器支持 perl 写的网页程序(例如 webmail 程  
序);  
mod_python:让你的 WWW 服务器支持 python 写的网页程序。  
mod_ssl:让你的 WWW 可以支持 https 这种加密过后的传输模式  
  
mysql  
mysql start报错  
Can't connect to local MySQL server through socket '/var/lib/mysql/mysql.sock' (2)  
service mariadb start  
Redirecting to /bin/systemctl start  mariadb.service  
  
netstat -tulnp | grep mysqld 成功  
mysql -u root -p  
  
show databases;  
exit  
修改密码mysqladmin -u root password 'root'  
给arpher用户一个 MySQL的数据库使用权,数据库名称为arpherdb,且密码为 arpher  
mysql> grant all privileges on arpherdb.* to arpher@localhost identified by 'arpher';  
mysql> use mysql;  
mysql> select * from user where user = 'arpher'\G;  
## centos-lnmp
  
换桥接模式后，yum不能使用  
经过各种测试，发现原来是防火墙的问题  
关闭防火墙(参考上一目录lamp)  
yum update 成功  
