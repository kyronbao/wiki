## 局域网传输文件
sudo apt-get install openssh-client 
sudo apt-get install openssh-server 
## terminal常用快捷键
  
查找历史命令 Ctrl+R  
  
显示历史 history  
  
剪切一行从行尾 Ctrl+U  
剪切一行从行首 Ctrl+K  
Ctrl+Y 粘贴最近剪切的文本  
## 早期整理
老鸟建议  
	最小安装  尽量不yum卸载  
  
  
查看主机名 临时改名hostname  
  
netstat -lunt 通过查看端口知道开了哪些服务  
  
挂载  
```
mkdir /mnt/cdrom 通常在/mnt目录挂载文件
```
		设备   目录  
mount /dev/sr0 /mnt/cdrom  
```
cd /mnt/cdrom
ls   查看挂载情况
```
卸载  
```
cd 先把命令返回，不能停在本目录执行命令
```
umount /dev/sr0 或umount /mnt/cdrom  
  
重启 (推荐使用，可以取消正在使用的服务)  
shutdown -r now 现在重启 r指reboot  
shutdown -r 8:00 8:00重启  
shutdown -h  8:00关机(*禁用*)  
shutdown -c 取消关机重启  
  
其他重启命令 reboot init 6  
改系统运行级别 init 1   状态有(0,1,2,3,4,5,6)  
查看系统运行级别配置文件cat /etc/inittab  X11指图形界面  
查询系统运行级别    runlevel  
退出登录(记得退出)  logout  
  
  
  
RPM安装卸载  
		名称中noarch指适合所有linux版本  
		www.rpmfind.com 找模块依赖包  
		包安装位置var/lib/rpm/  
  
		安装 rpm -ivh 包全名(安装install 显示信息verbose 进度hash)  
		         -nodeps (不检测依赖性)  
			先  
			mkdir /mnt/cdrom  
			mount /dev/sr0 /mnt/cdrom  
			查看挂载：mount  
			cd /mnt/cdrom  
			ls 在此目录安装-  
		升级rpm -Uvh 包全名(升级)  
		卸载rpm -e 包名 (不用一定在安装目录)  
  
查询  
	 rpm -qa               查询全部  
	 rpm -q httpd          查询包名(query)  
	 rpm -qa | grep httpd  查询httpd相关的安装  
  
	 rpm -qR httpd         查询依赖信息(requie)  
	 rpm -qRp 包全名   查询未安装依赖信息(/mnt/cdrom/packages/)  
  
	 rpm -ql httpd         查询已安装软件安装位置(list)  
						   源码包安装位置查询 ls /usr/local/apa...  
	 rpm -qlp 包全名       查询未安装软件的位置  
	 rpm -qf /etc/yum.conf 查询系统文件属于那个软件包(files)  
  
	 rpm -qi httpd         查询软件信息(information)  
	 rpm -qip 包全名       查询未安装软件信息(package)  
  
rpm包校验  
		rpm -V httpd  校验(verify)  
		rpm -ql httpd  
		vim /etc/httpd/conf/httpd.conf  
rpm包中文件提取  
		rpm2cpio 包全名 |\  
		cpio -idv .文件绝对路径   \为了命令换行.当前目录  
  
		rpm2cpio 将rpm包转为cpio格式命令  
		cpio -idv < [文件|设备]  从档案中提取文件(copy-in模式，还原 自动新建目录 显示还原过程)  
  
		例  mv /bin/ls /tmp  
			ls  
			rpm2cpio /mnt/cdrom/Packages/coreutils-8.4-31.el6.i686.rpm |\  
			> cpio -idm ./bin/ls  (> 另开一行命令面板提示)  
			dir  
			cd bin/  
			cp ls /bin/ls  
  
网络yum源  
	vi /etc/yum.repos.d/CentOS-Base.repo  
	enabled=1 生效 0不生效  
  
yum命令(命令地址不限，不需要包全名)  
	查询所有可用软件包列表      yum list  
	搜索所有和关键字相关的包    yum search httpd  
	安装                        yum -y install gcc  
			-y 自动回答yes  
			gcc 源码包安装需要的c语言编译器  
								rpm -q gcc 查询安装成功  
	升级   	yum -y update (*禁用*)升级所有包和内核  
			yum -Y updata gcc  
	卸载	yum -y remove 关键字(*尽量禁用*)依赖性  
yum软件组管理  
	查询列表	yum grouplist  
	安装    	yum groupinstall "软件组名"  
	卸载		yum groupremove  "软件组名"  
  
yum源光盘搭建  
	1挂载光盘	虚拟机->设置->网络适配器->右上角已连接 勾  
				mkdir /media/CentOS/  
				mount -t iso9660 /dev/sr0 /media/CentOS/  
				mount 查看  
	2网源失效	cd /etc/yum.repos.d/  
				ls  
				mv CentOS-Base.repo CentOS-Base.repo.bak  
				mv CentOS-Debuginfo.repo CentOS-Debuginfo.repo.bak  
				mv CentOS-Vault.repo CentOS-Vault.repo.bak  
  
				vi CentOS-Media.repo (不随便添加# 修改格式)  
				baseurl=file:///media/CentOS  
				#        file:///media/cdrom/  
				#        file:///media/cdrecorder/  
				enabled=1  
	3查看成果	yum list  
				yum install vim  
  
源码包安装  
	 检查安装gcc rpm -q gcc  
	1复制压缩包到root目录  
	2解压缩 tar -zxvf httpd-2.4.17.tar.gz  
		ls  
		du -sh httpd-2.4.17查看大小  
	3进入解压缩包目录cd httpd-2.4.17  
		查看ls   vi README    vi INSTALL  
	4准备  
		./configure --help  
		./configure --prefix=/usr/local/apache2  
			生成Makefile文件,用于后续编辑  
	5编译 make  
		到这一步前面报错的话make clean可以清空编译产生的文件  
	6编译安装make install  
	7/usr/local/apache2/bin/apachectl start  
  
  
用户配置文件  
  
	查询配置文件命令  man 5 passwd  
	/etc/passwd  用户名:密码标志:UID:GID:用户说明:家目录:登录之后的Shell  
		UID  0:超级用户 1-499系统用户 500-65535 普通用户  
	/etc/shadow 用户名:密码:最后修改:两次间隔:\  
				有效期:警告天数:宽限天数:失效时间:保留  
				加密算法升级为：SHA512  !!  * 表示没密码  
		换算时间  date -d "1970-01-01 16076 days"  
				echo $(($(date --date="2014/01/06"+%s)/86400+1))  
	/etc/group    组名:组密码标志:GID:组中附加用户  
	/etc/gshadow  组名:组密码:组管理员用户名:组中附加用户  
	查看用户组  
		新建用户时自动新建同名的用户组,  
		只有用户组存在才能创建用户,用户依存于用户组存在  
				cat /etc/passwd  看组ID  
				cat /etc/group   看组ID对应的组名  
  
		修改普通用户为超级用户  UID=0  
		var 可变文件存放  
	家目录  /root/ 			权限 550  超级用户  
			/home/用户名/   权限 700  普通用户  
	/var/spool/mail/用户名/ 用户邮箱  
	/etc/skel/              用户模板(普通用户家目录里默认自带文件)  
  
  
	用户默认文件    /etc/default/useradd  
					/etc/login.defs  
	普通用户添加 useradd meizi	-u -d -c -g -G -s  
	    密码添加 passwd meizi 123456  
				 echo "123456" | passwd --stdin 123  
	超级用户修改密码 passwd 123456  
	超级用户修改普通密码 passwd meizi 123456  
	普通用户修改密码 passwd 123456  
  
		我是谁  whoami  
		密码修改 后退:crl+Backspace  或重来: ctrl+c  
		查询	passwd -S meizi  
				cat /etc/shadow | grep meizi  
		锁定    passwd -l meizi  其实就是在shadow密码前加!!  
		解锁	passwd -u meizi  
	用户修改 usermod -c  -G     -L   -U  
					说明 用户组 锁定 解锁  
	密码状态修改 chage -l   -d      -m -M -W -I -E  
					   状态 修改日期...  
				chage -d 0 meizi 改后第一次登录后会提示修改密码  
	用户删除  userdel -r 注意-r同时删除用户家目录  
  
		id meizi  查询uid gid 目前所在组  
		usermod -G root meizi 加meizi到root组  
	身份切换 su - meizi   -注意连带切换环境变量  
			 env 查环境变量  
			 su - root -c "useradd fengge"   -c临时执行命令  
			 exit 退出  
  
	用户组管理  
		groupadd lamp    -g 指定GID  -g用处不大  
		groupmod -n 新组名 老组名   修改组名(*不建议*)要修改mail等,建议直接删除后添加新的  
		groupdel 组名(有作为主组的用户存在时，不能删)  
			useradd -g lamp1 user1 添加user1用户主组是lamp1  
			useradd -G lamp2 user2 添加user2到附加组lamp2  
			userdel -r user1       先删主组的用户  
			groupdel lamp1         才能删主组  
		gpasswd -a meizi lamp 把meizi加到lamp组作为附加用户  
		gpasswd -d meizi lamp 把meizi从lamp组中删除  
  
  
权限  
  
	df -h 查看分区使用状况  
	dumpe2fs -h /dev/sda5 	查指定分区文件系统信息  
		看 Default mount options:支持acl  目前大多数linux默认已经支持了，不用配置了,万一不支持的话  
	临时开启分区ACL权限 mount -o remount,acl   -o支持特殊  
	永久                vim /etc/fstab  (*慎重写错不能启动*)  
						default,acl  (在需要的分区加,acl)  
						mount -o remount  
  
	查看acl权限 getfacl 文件名  
	设置acl权限 setfacl -m 文件名  
		例：添加shiting用户rx权限对/project/  
		mkdir /project/  
		useradd bimm	 useradd cangls 	useradd shiting  
		groupadd tgroup  
		gpasswd -a bimm tgroup 		gpasswd -a cangls tgroup  
		cat /etc/group  
  
		chown root:tgroup /project/ 改/project/拥有者和组群  
		chmod 770 /project/  
		ll -d /project/  
  
		setfacl -m u:shiting:rx /project/  
				-m 设置acl u用户模式  
		ll -d /project/ 查看多了+  
		getfacl /project/ 报错提示去掉前面的/  
  
		su - shiting  
		ls 可以  cd /project/ 可以  touch abc 报错  
	组acl权限设置  
		groupadd tgroup2  
		setfacl -m g:tgroup2:rwx /project/  
		getfacl /project/  
最大有效权限mask  
		文件除了所有者owner,其他的权限与mask权限相与才是  
		文件的最终权限  
		setfacl -m m:rx  
删除acl  
		setfacl -x g:tgroup2 /project/ 删组  
		setfacl -x u:shiting /project/ 删用户  
		setfacl -b /project/ 删全部acl  
		查看 getfacl /project/  
			 ll /project/  
递归acl(只对文件起作用)  
	以前的里面的遵守  
		setfacl -m u:shiting:rx -R /project/  
						-R递归 注意位置  
	新建的遵守(默认递归)  
		setfacl -m d:u:shiting:rx /project/  
				   d默认  
  
  
			touch abc    ll abc  
SUID (只有可执行二进制程序才能执行SUID命令)  
	比如passwd命令有SUID权限,所以其他用户执行时  
	就可以变为root,可以使用passwd命令操作/etc/shadow文件  
	把密码写进文件  
  
	SetUID 灵魂附体二进制文件(*危险*)  
		whereis passwd  
		ll /usr/bin/passwd  有s  
		建议经常检测 以删除  
  
  
SetGID (对可执行二进制程序和目录都能执行SUID命令)  
  
	对文件：执行时组身份升级为程序文件的组属  
		whereis locate  
		ll /usr/bin/locate  
			-rwx--s--x 1 root slocate有s,有SGID,  
			其他用户执行是组升级为slocate  
		ll /var/lib/mlocate/mlocate.db  
			-rw-r----- 1 root slocate 组为slocate,有读权限  
			所以其他用户可以用locate命令执行  
  
  
	对目录：  
		cd /tmp/  
		mkdir test/  
		chmod 2755 test/  或g+s  
		ll -d test/  
		chmod 2777 test/ 为测试  
		su - meizi  
		touch abc   	ll -d abc查看  
		cd /tmp/test/   touch abc   ll -d abc查看  
		普通用户新建文件的所属组为创建者的所属组  
  
Sticky BIT (只对目录有效)  
		粘着位，保护自己建的文件不被其他普通用户删  
		ll -d /tmp/ 查看有t (只对本目录下文件有效)  
		su - meizi   touch abc  
		su - fengge   cd /tmp/   ll  
		rm -rf abc  不能删,只有创建者能删，避免误操作  
  
	设置  
			  SUID		SGID  TUID  
		chmod 4755 abc   2755  1755  
		chmod u+s abc     g+s     o+t  
		(设置SUID和SGID文件必须有x权限,大写S指报错)  
  
	删除  
			  SetUID	  SGID  TUID  
		chmod 755 abc  
		chmod u-s abc     g-s     o-t  
  
chattr文件系统属性  
		锁起来了,可以防止root误操作  
	格式：chattr [+-=]i 文件|目录  
		文件有i属性时：  
					所有人(包括root),只能查看,  
					不能删除改名、添加修改数据  
			例:  
			touch abc 	ll	 echo 111>>>abc		cat abc  
			chattr +i abc 	ll 看不到i属性  
			lsattr -a abc 	----i-------e-  
				e代表在ext文件系统，不用管  
		目录有i属性时：所有人不能建立删除文件，只能修改文件数据  
			例:  
			mkdir /test 	touch 	/text/bcd  
			chattr +i /test/ 	lsattr -a /test/ 能查看到有i属性  
			echo 222 >> /test/bcd 可以  
			cat /test/bcd 可以  
			rm -rf /test/bcd 不可以  
	格式：chattr [+-=]a 文件|目录  
		文件有a属性时：只能追加数据，不能修改、删除  
			例:echo 1111 >> abc 可以  
			   vi abc 不能保存  
		目录有a属性时：只能建立修改文件，不能删除  
	总结:i比a更严格,不能修改  
			a是add的意思,指可以添加数据  
  
sudo权限：  
	root:  
		把超级的命令赋予普通用户  
		visudo 实际上修改的是/etc/sudoers  
  
		root 	ALL=(ALL) 	ALL  
		允许meizi  在本机或本服务器网段任何IP 使用此命令  
		meizi 	ALL=/sbin/shutdown -r now写多，赋权限多  
		meizi 192.168.1.200=/usr/bin/vim (*禁*)普通用户vim有限制  
	普通用户  
		sudo -l查看授权命令  
		sudo /sbin/shutdown -r now  
  
  
文件系统  
  
  
	df [-h] [挂载点]   文件系统查看(从系统程序考虑)  
			-h人性化 -a 显示所有 -T显示类型  
		查：剩余空间为真实的  
		系统要定时重启，来清除缓存数据  
			游戏、下载、电影每周重启  
			不大网站每月重启  
		ll -h /etc/ 只统计其下一级子目录文件大小  
	du -sh /etc 统计所有目录或文件大小(从文件考虑)(注意比较耗资源)  
	看文件大小直接用 ll -h  
		-s总和 -a显示其下每个子文件  
	fsck [-a -y]分区设备文件名  文件系统修复 (*禁用*)  
					底层命令，不用手工敲  
	dumpe2fs /dev/sda1 查数据块  
		查Block size  
  
	mount [] 设备文件名 挂载点      查系统已挂载的设备  
			-t 文件系统 硬盘:ext4 光盘:iso9660  
			-L 卷标，别名-l显示卷标  
			-o特殊选项 remount  
					   exec/noexec 文件系统下文件可不可执行  
			例：noexec可以让home下文件不能 执行  
			ls 		touch ashell.sh  
			vim 内容#!/bin/bash  
					echo "hello world"  
			chmod 755 ashell.sh     ./ashell.sh 执行  
			mount -o remount,noexec /home/  
			cp ashell /home/  	cd /home/  
			ashell.sh 不能执行 chmod 755 ashell.sh 也不能  
			df 		dumpe2fs /dev/sda2 我没能找到noexex  
			mount -o remount,exec /home/  
  
	挂载光盘 mkdir /mnt/cdrom   现在默认也可以挂载到根下有media  
			 放入光盘  
			 mount -t iso9660 /dev/sr0 /mnt/cdrom/  \  
			 或简写mount /dev/cdrom /mnt/cdrom/  
						cdrom是sr0软连接(ll /dev/cdrom)  
			 df查看      cd /mnt/cdrom/  
实战挂载光盘 mkdir /media/CentOS  
			 mount -t iso9660 /dev/sr0 /media/CentOS  
			 mount  
  
	卸载光盘 cd ..  
			 umount /mnt/cdrom/ 或umount /dev/sr0  
			 去掉光盘  
  
	挂载u盘 设备名自动识别  
			进入虚拟机  鼠标点进去 插入u盘  
			fdisk -l 查u盘设备名 查看到设备名sdb  
			用远程工具  
			fdisk -l  
			mount -t vfat /dev/sdb1 /mnt/usb/  
			 FAT32分区识别为vfat FAT16->fat  linux默认不支持NTFX  
			umount /dev/sdb1  	拔出u盘  
  
加新分区  
		查看命令  
			看分区df -h     看挂载mount     看设备fdisk -l  
  
	步骤  
	虚拟机断电  添加硬盘(下一步、磁盘类型:SCSI 10G) 开机  
	fdisk -l 查看到新硬盘sdbp  
	fdisk /dev/sdb   不写sdb1等  
		m帮助   l显示系统类型   n新建 	 d删除  
		t改系统ID  w保存退出  q不保存退出  
		crl+退出 删除  
  
		p查看  
		n新建  p选主分区  1选1号主区(硬盘分区最好不要跳开)  
		1选1号柱列  +2G  p查看  
		n新建  e选扩展分区  2选2  回车  回车：剩下都都做了扩展分区  
  
		p查看  
		n新建  l(1234给了主分区)  回车 +2G  p查看  
  
		w(注意保存)  
		partprobe提示要重启时:重新读分区表信息  
  
		fdisk -l 查看  
		格式化  mkfs -t ext4 /dev/sdb1 (扩展区不能格式化如sdb2)  
				mkfs -t ext4 /dev/sdb5  
		新建挂载点 mkdir /disk1    mkdir /disk5  
			命令挂载(重启后会失效)  
					mount /dev/sdb1 /disk1/  
					mount /dev/sdb1 /disk5/  
			mount 或 df 查看挂载  
		设置自动挂载  
		先查UUID dumpe2fs -h /dev/sdb1  代替下面的/dev/sdb1  
			此项可选 一般执行 防止以后设备名冲突  
			Filesystem UUID:32dc9d2b-fa35-4ad1-8c61-327f99c9142a  
		vim /etc/fstab (注意写好,系统会崩溃)  
			/dev/sdb1    /disk1    ext4  defaults   1  2  
			/dev/sdb5    /disk5    ext4  defaults   1  2  
		mount -a 载入/etc/fstab挂载分区(防止写错系统崩溃)  
  
			万一崩溃了  
			重启  输入root密码  
			mount -o remount,rw /  重新挂载rw权限  
			vim /etc/fstab 写正确的  
  
新硬盘分配swap分区1G  
		free -m 查看内存和swap占用情况 -m兆  
			cached缓存 读取的数据写入内存 加速读取  
			buffer缓存 分散的写入命令写入内存 加速数据写入  
		fdisk /dev/sdb   l查swap分区ID号为82  
  
		n  l  回车  +1G  p查看  l查看ID m查到t  t  6 82 p  w保存退出  
		提示在忙的话partprobe  报错不管  重启reboot  
		格式化mkswap /dev/sdb6  
				保存UUID=9b24f75d-8ba5-4ea5-9ee4-021b3dac10ac  
			命令加入swapon /dev/sdb6   如果不想用了swapoff /dev/sdb6  
  
		自动挂载vim /etc/fstab  
		/dev/sdb6    swap      swap    defaults   0  0  
		reboot  
		查看free -m  
  
  
  
服务  
	service --status-all 查询所有RPM包服务状态  
	自启动方法(用完不一定已经启动 要service network restart)  
	1	chkconfig --list | grep httpd查询  
		chkconfig [--level] 2345 httpd on自启动开启  
	2	ll /etc/rc.d/rc.local		(推荐)  
		ll /etc/rc.local 上面的软连接,此文件所有用户登密码前启动  
		vim /etc/rc.local  
			/etc/rc.d/httpd start  #加入  
	3	ntsysv   要自启动的打*  
  
	vim /etc/rc.d/  下面不同数字是启动顺序  
  
进程  
	查看：ps aux     unix的格式  
		  ps -le 详细  
  
CPU  dmesg | grep CPU  
	 cat /proc/cpuinfo 文件断电重写  
  
	 w 看用户  
	 crontab -l 看定时任务  
  
日志  
	服务查看 ps aux | grep rstslogd  
			 chkconfig --list | grep rsyslog  
	配置文件 /etc/logrotate.conf  
  
  
## shell学习笔记
脚本条件判断中-z什么意思  
string is null, that is, has zero length  
```
 String=''   # Zero-length ("null") string variable.

if [ -z "$String" ]
then
  echo "\$String is null."
else
  echo "\$String is NOT null."
fi     # $String is null.
```
- https://unix.stackexchange.com/questions/109625/shell-scripting-z-and-n-options-with-if
  
```  
目录文件  cat /etc/shells  
切换sh exit  

echo [][内容] 输出命令 -e支持\ (-表-)

		\a警告 \b退格 \c取消换行 \e取消  
		\f换页 \n换行 \r回车 \t制表符 \v垂直指标符  
		\0nnn 八进制 \xhh 16进制  
history [] [历史命令保存文件]  
		-c清空 -w 家目录.bash_history缓存中写入文件  
		/etc/profile修改默认保存HISTSIZE1000条,重启生效  
		!serv代替最后输入的service network start  
命令别名 alias 别名='原命令'  设定别名  
			 alias 查询  
		/家目录/.bashrc  
命令执行顺序 路径>别名>内部命令[如cd]>环境变量定义的  
快捷键   ctrl+A移到开头 ctrl+E移到行尾 ctrl+C终止命令  
	     ctrl+L清除屏幕 ctrl+U剪切行前 ctrl+K剪切行后  
	     ctrl+Y粘贴内容 ctrl+R搜索历时 ctrl+D退出终端  
	     ctrl+Z暂停  
输出重定向  正确命令 > 文件   覆盖 例ls > abc  
			正确命令 >> 文件  追加   date > bcd  
			错误命令 2> 文件  
			错误命令 2>> 文件  
正确错误同时保存 命令 &> 文件  覆盖  
				 命令 &>> 文件  追加  
				 命令>>文件一 2>>文件二  

ls &>/dev/null  执行后输出丢到垃圾箱

输入重定向   命令 < 文件 把文件作为命令输入 例：wc < install.log  
			wc [] [文件名] 统计行号 单词数 字符数  
  
;多命令顺序执行 &&逻辑与  ||逻辑或  
dd if=输入文件 of=输出文件 bs=字节数 count=个数   复制磁盘等  
		 date;dd if=/dev/zero of=/root/testfile bs=1k count=100000;date  
		 命令 && echo yes || echo no  正确时yes 错误时no  
管道符  命令1 | 命令2    命令1的正确输出作为命令2的操作对象(1必须正确)  
		ll -a /etc/ | more 分屏显示  
		netstat -an | grep "ESTABLISHED" 显示所有的连接  

grep [] "搜索内容"  在文件中搜索显示搜索内容

	     -i忽略大小写 -n行号 -v反向查找 --color=auto  
通配符  匹配文件名  
		?任意一个字符 *零或多个字符 []里面任意一个字符  
		[-]例如[a-z] [^]取反[^0-9]  
		(*禁rm -rf /禁*)  
特殊符号  
		'直接输出' "$name特殊符号有意义" `系统命令`  
		#注释  $name  \转义符  
		例：abc=`date`即abc=$(date)  
			echo $abc  
变量  
	规则:默认是字符串，数值变量需指定，  
		 变量值 有空格用''或""括起来，可以用\  
		 增加变量值 "$变量名"或${变量名}  
			aa=123 aa="$aa"456 aa=${aa}789 echo $aa  
		 命令结果赋予变量 用``或$()包含命令  
			例name=$(date) echo $name  
		 环境变量名建议大写  
	分类:自定义变量  
			局部当前shell生效  
		 环境变量  
			子shell也生效  
			声明:export 变量名=变量值  
			pstree确定进程数  
				例：bash;name=sc;export age=18;sex=nan;  
					export sex;#自定义变量变为环境变量  
					bash;#进入子shell  
					patree;set#查看  
			env:查看环境变量  
			unset $sex:删除  
			PATH:系统查找命令的路径  
				例：快捷hello.sh  
					定义个hello.sh;chmod 755 hello.sh;  
					cp hello.sh /bin/;cd /home/;  
					hello.sh;rm -rf /bin/hell.sh  
				叠加："$PATH":/root/sh  
					例：临时生效hello.sh  
						PATH="$PATH":/root;echo $PATH;hello.sh  
			PS1:定义系统提示符的变量(env查不到，set可以)  
			文件：  
				source 配置文件 或.空格配置文件   就不用重启了  
  
		 位置参数变量 变量名不能自定义 作用固定  
			$n  
				例：vi canshu1.sh  
						#!/bin/bash  
						echo $0  
						echo $1  
						echo $2  
						echo $3  
					chmod 755.chanshu1.sh;./chanshu1.sh 11 22 33;  
				例：计算器  
					vi cal.sh  
						#!/bin/bash  
						sum=$(( $1+$2 ));  
						echo "sum is :$sum"  
					chmod 755.sh; ./cal.sh 11 22  
			$* $@ $#区别 例 见(-表-)  
		 预定义变量 同上  
			$? 最后一次执行命令的返回状态  
				例：ls; echo $?; lkfjk; echo $?;  
			$$	当前进程的进程号(PID) 例见(-表-)  
			$! 后台运行的最后一个进程的进程号  
		 read [] [变量名] 接受键盘输入  
			-p "提示信息"    -t 30 等30s  
			-n -s屏幕隐藏信息  
	查看：set  
	删除：unset name  
```

## 查找文件/内容
查文件名  
locate winebus.sys  
find / -name winebus.sys  
查文件内容  
grep -r "word" /etc/mysql
## 查看文件大小
cd ./laravel
du -h -d 1 --exclude=./.svn --exclude=./vendor ./
## 查看看文件夹大小
du -hs file_path  
du -sm * | sort -n 查看并排序  
- http://blog.sina.com.cn/s/blog_4af3f0d20100irvz.html
du -h --max-depth=1 /data/devops/ 查看一级子文件夹大小  
  
排除文件夹复制  
  
- https://stackoverflow.com/questions/1228466/how-to-filter-files-when-using-scp-to-copy-dir-recursively/1228535
## 查看进程 进程树 端口
查看开启的进程 ps aft | grep tcp.php  
查看子进程  pstree -aup 24451  
查看开启的端口 sudo netstat -anp | grep 8888  
  
查看进程数目  
```
ps ef|grep php|wc -l
```
杀死进程  
```
ps -ef|grep php-fpm|grep -v grep|cut -c 9-15|xargs sudo kill -9
```
注意cut -c 9-15为pid在行的字符位置  
- [Linux下批量杀死进程（根据关键字杀死进程](https://www.sundabao.com/linux%E4%B8%8B%E6%89%B9%E9%87%8F%E6%9D%80%E6%AD%BB%E8%BF%9B%E7%A8%8B%EF%BC%88%E6%A0%B9%E6%8D%AE%E5%85%B3%E9%94%AE%E5%AD%97%E6%9D%80%E6%AD%BB%E8%BF%9B%E7%A8%8B%EF%BC%89/)
  
  
  
  
## 查看linux版本
- https://www.cyberciti.biz/faq/find-linux-distribution-name-version-number/
```
uname -a    
hostnamectl  

cat /proc/version  
cat /etc/issue  
cat /etc/os-release  

cat /etc/*-release  
lsb_release -a  
```
## 查看Ip
ip addr show  
  
ifconfig  
  
hostname -I  
  
坑  
ubuntu测试不对时  
重新连接  
再运行上面的命令  
  
## 查看服务名servers
service --status-all  
## 如何为sudo命令定义PATH环境变量
添加所需要的路径(如 /usr/local/bin）到"secure_path"下，在开篇所遇见的问题就将迎刃而解。  
Defaults    secure_path = /sbin:/bin:/usr/sbin:/usr/bin:/usr/local/bin  
http://www.linuxidc.com/Linux/2014-09/106076.htm  
## 关于递归目录相关命令
```
cp -R dir/ ./
mv dir ./ # 不用选项
chown -R git:git ./
scp -r project.git/ root@hostname:/opt/git/
```
  

## 远程复制
```
scp -r user@your.server.example.com:/path/to/foo /home/user/Desktop/
```

## 测试端口是否打开
telnet 192.168.1.103 80  

## 修改root密码
```
sudo passwd root
```
使用  
```
su root
```
## 解压
### tar
查看  
```
tar -tf bbbb.tar.gz
```
查看一级目录  
```
tar tvf go1.11.2.linux-amd64.tar.gz | grep ^d  | awk -F/  '{if(NF<4) print }'
```
解压到制定目录  
```
tar -zxvf ***.tar.gz -C /opt
```
  
### zip unzip 压缩解压、中文乱码处理、加密解密
```
unzip -O cp936 UE.zip  # 解决解压乱码
unzip file.zip -d destination_folder

zip -r fold.zip fold  # 压缩文件
zip -re file.zip file  # 加密文件
```
### 7z解压
```
7z x file.7z
```
### unrar
```
unrar x file.rar
```
### 乱码
linux中rar解压中文文件名乱码解决  
        在linux解压rar文件，通常使用的命令是  
  
llx@linux:~ rar e 文件.rar  
  
        但是由于编码的缘故，在windows下打包的的中文文件，解压后时候乱码，提示为无效的编码格式，由于windows是gbk的编码格式，而ubuntu下默认使用的确实utf8编码格式，这个文件可以使用convmv这个命令解决。convmv能将文件的文件名从一种编码格式转换成为另外一种编码格式加入没有安装convmv，使用下面命令安装：  
  
llx@linux:~ sudo apt-get install convmv  
  
llx@linux:~ convmv  *  -f gbk -t utf8 -r --notest  
  
    其中，*是需要转换的文件；--notest是对文件进行重命名；-r是递归处理目录  
- http://l1x-linux.lofter.com/post/1cd4ae06_43156c4
## grep
```
grep words . -r -n
```

## 删除用户:
```
userdel -r mongo       # -r参数删除用户mongo的同时，将其宿主目录和系统内与其相关的内容删除。
```
  
## non-root用户sudo权限配置
```
sudo visudo
找到
root    ALL=(ALL:ALL) ALL
添加
<username> ALL=(ALL:ALL) ALL
```
  
## chmod
只修改文件夹的权限: chmod  755  `find  目录  -type  d`  
只修改文件的权限: chmod  644  `find  目录  -type  f `  
  
  
修改程序安装地址的权限实践  
首先修改所有目录和文件权限  
```
sudo chmod 644 ./
```
然后修改文件夹目录权限  
```
sudo chmod 755 `sudo find -type d`
```

## apt彻底删除
彻底删除 sudo apt purge  
通过man 8 apt查到  
使用remove命令时会删除包数据，但会保留小部分（修改过的）用户配置文件，防止意外删除，如果删除了，只需要再次安装即可。  
purge命令会删除所有数据，但是不会影响用户家目录的数据  
  
## 卸载linux服务的方法
```
systemctl stop [servicename]
systemctl disable [servicename]  # 禁止自动重启，可通过sysv-rc-conf检查
rm /etc/systemd/system/[servicename]
rm /etc/systemd/system/[servicename] symlinks that might be related
systemctl daemon-reload
systemctl reset-failed
```
  
dpkg -l | grep sendmail # 查看已安装的包  
```
sudo apt-get --purge remove sendmail-base sendmail-bin sendmail-cf
```
  
参考  
https://superuser.com/questions/513159/how-to-remove-systemd-services  
[How to remove Postgres from my installation?](https://askubuntu.com/questions/32730/how-to-remove-postgres-from-my-installation)  
  
## apt安装的包查询
dpkg -l gitlab-ce  
## apt dpkg软件管理
```
apt-cache search # ------(package 搜索包)  
apt-cache show #------(package 获取包的相关信息，如说明、大小、版本等)  

apt-get install # ------(package 安装包)
apt-get install # -----(package --reinstall 重新安装包)
apt-get -f install # -----(强制安装, "-f = --fix-missing"当是修复安装吧...)
apt-get remove #-----(package 删除包)
apt-get remove --purge # ------(package 删除包，包括删除配置文件等)
apt-get autoremove --purge # ----(package 删除包及其依赖的软件包+配置文件等（只对6.10有效，强烈推荐）)
apt-get update #------更新源
apt-get upgrade #------更新已安装的包
apt-get dist-upgrade # ---------升级系统
apt-get dselect-upgrade #------使用 dselect 升级

apt-cache depends #-------(package 了解使用依赖)  
apt-cache rdepends # ------(package 了解某个具体的依赖,当是查看该包被哪些包依赖吧...)  

apt-get build-dep # ------(package 安装相关的编译环境)
apt-get source #------(package 下载该包的源代码)
apt-get clean && apt-get autoclean # --------清理下载文件的存档 && 只清理过时的包
apt-get check #-------检查是否有损坏的依赖

dpkg -S filename -----查找filename属于哪个软件包  
apt-file search filename -----查找filename属于哪个软件包  
apt-file list packagename -----列出软件包的内容  
apt-file update --更新apt-file的数据库  
  
dpkg --info "软件包名" --列出软件包解包后的包名称.  
dpkg -l --列出当前系统中所有的包.可以和参数less一起使用在分屏查看. (类似于rpm -qa)  
dpkg -l |grep -i "软件包名" --查看系统中与"软件包名"相关联的包.  
dpkg -s 查询已安装的包的详细信息.  
dpkg -L 查询系统中已安装的软件包所安装的位置. (类似于rpm -ql)  
dpkg -S 查询系统中某个文件属于哪个软件包. (类似于rpm -qf)  
dpkg -I 查询deb包的详细信息,在一个软件包下载到本地之后看看用不用安装(看一下呗).  
dpkg -i 手动安装软件包(这个命令并不能解决软件包之前的依赖性问题),如果在安装某一个软件包的时候遇到了软件依赖的问题,可以用apt-get -f install在解决信赖性这个问题.  
dpkg -r 卸载软件包.不是完全的卸载,它的配置文件还存在.  
dpkg -P 全部卸载(但是还是不能解决软件包的依赖性的问题)  
dpkg -reconfigure 重新配置  
```  
摘自 http://qiuye.iteye.com/blog/461394  
  
## ubuntu安装deb,rpm安装包方法
Ubuntu的软件包格式是deb，如果要安装rpm的包，则要先用alien把rpm转换成deb。  
  
```
sudo apt-get install alien #alien默认没有安装，所以首先要安装它
```
  
```
sudo alien xxxx.rpm #将rpm转换位deb，完成后会生成一个同名的xxxx.deb
```
  
```
sudo dpkg -i xxxx.deb #安装
```
  
注意，用alien转换的deb包并不能保证100%顺利安装，所以可以找到deb最好直接用deb  
  
方法一：  
  
1. 先安装 alien 和 fakeroot 这两个工具，其中前者可以将 rpm 包转换为 deb 包。安装命令为：  
  
```
sudo apt-get install alien fakeroot
```
  
2. 将需要安装的 rpm 包下载备用，假设为 package.rpm。  
  
3. 使用 alien 将 rpm 包转换为 deb 包：  
  
fakeroot alien package.rpm  
  
4. 一旦转换成功，我们可以即刻使用以下指令来安装：  
  
```
sudo dpkg -i package.deb
```
  
方法二：  
  
1.CODE:  
  
```
sudo apt-get install rpm alien
```
  
2.CODE:  
  
alien -d package.rpm  
  
3.CODE:  
  
```
sudo dpkg -i package.deb
```
  
作者: 王德水  
出处：http://www.cnblogs.com/cnblogsfans  
  
## wine安装，卸载
安装wine  
#如果你使用的是64位Ubuntu，则先要开启32位安装环境：  
```
sudo dpkg --add-architecture i386
```
  
#然后需要下载一个PGP公钥以识别软件仓库：  
```
wget -nc https://dl.winehq.org/wine-builds/Release.key
```
  
#添加公钥并添加软件源：  
```
sudo apt-key add Release.key
sudo apt-add-repository https://dl.winehq.org/wine-builds/ubuntu/ （这里百度报错）
```
  
#更新软件列表  
```
sudo apt-get update
```
  
#之后就可以选择Wine版本安装了：  
#稳定版（Stable branch）安装命令  
```
sudo apt-get install --install-recommends winehq-stable
```
  
安装配置 （这一步比较慢）  
 winecfg  
  
```
sudo apt install winetricks
```
  
winetricks riched20  
  
  
下载wechat.exe  
  
测试 wine wechat.exe  
  
然后参考下面文章的后面  
https://blog.csdn.net/qq_36428171/article/details/81209475 解决微信中文乱码  
  
  
  
  
卸载wine安装的软件  
当你需要卸载你使用wine安装的软件时，只需要在Dash中搜索Uninstall Wine software或者在终端中输入命令 wine uninstaller，即会弹出如下下载软件的窗口  
https://jingyan.baidu.com/article/5225f26b662c3ce6fa090824.html  
## 资源推荐
- https://linuxtools-rst.readthedocs.io/zh_CN/latest/tool/index.html
- [Linux 上有哪些工具软件堪称精美？](https://www.zhihu.com/question/28596616)
## 画图
  - https://www.processon.com/ 流程图
  - https://www.draw.io
  - [程序员必知的七个图形工具](https://github.com/phodal/articles/issues/18)
## screen
- https://blog.csdn.net/chenyunqiang/article/details/52805814
- https://www.cnblogs.com/mchina/archive/2013/01/30/2880680.html
  
5.4 会话分离与恢复  
  
你可以不中断screen窗口中程序的运行而暂时断开（detach）screen会话，  
并在随后时间重新连接（attach）该会话，重新控制各窗口中运行的程序。  
例如，我们打开一个screen窗口编辑/tmp/david.txt文件：  
  
[root@TS-DEV ~]# screen vi /tmp/david.txt  
之后我们想暂时退出做点别的事情，比如出去散散步，  
那么在screen窗口键入C-a d，Screen会给出detached提示：  
  
暂时中断会话  
  
半个小时之后回来了，找到该screen会话：  
  
[root@TS-DEV ~]# screen -ls  
  
重新连接会话：  
  
[root@TS-DEV ~]# screen -r 12865  
一切都在。  
## 截图，截屏
flameshot 可以截屏到桌面显示
gnome-screenshot 可以通过如下快捷键来进行截图:  
  
shift+printscreen(Prt scr) 该快捷键可以对指定的区域进行截图  
Alt+printscreen(Prt scr) 该快捷键可以对当前的窗口进行截图  
Fn+printscreen(Prt scr) 该快捷键可以对桌面进行截图  
在打开——系统设置——>键盘——快捷键——自定义快捷键，然后输入名字和上边工具的命令  
gnome-screenshot  -ac  我这里是完全模拟了QQ的截图使用习惯，将快捷键设置为Ctrl+Alt+A  
- https://www.jianshu.com/p/7f453c144f9c
- [Linux中用于截图的两个工具](https://www.techforgeek.info/linux_screenshot.html)
## 联网
第一步，安装pppoecof  
打开终端，输入命令sudo apt-get install pppoeconf。  
安装成功之后，开始手动配置。  
  
第二步，配置连接  
打开终端，输入命令pppoeconf。  
接下来会看到一系列配置信息，包括用户名、密码（宽带连接的用户名密码），配置好之后会有一些提示信息，一路选择yes即可。到此，宽带连接已经成功连上，Plugin rp-pppoe.so loaded.此信息说明连接成功。  
然后重启下电脑。  
下次开机时手动连接  
打开终端，输入命令pon dsl-provider即可连接，可以用plog命令查看状态。  
断开连接的命令是poff dsl-provider。  
  
设置完后密码地址  
```
sudo vim /etc/ppp/pap-secrets
```
- https://blog.csdn.net/SeekN/article/details/52903919
  
  
- 宽带联网 sudo pppoeconf
  - https://blog.csdn.net/Handoking/article/details/78080883
- [Ubuntu 挂起（睡眠）后wifi断开的解决办法](https://blog.csdn.net/chenyiyue/article/details/52128245)
有时候从挂起状态唤醒之后，wifi会显示disconnected。  
  
解决方法1：如果不嫌麻烦：  
```
sudo service network-manager restart
```
  
方法二：  
  
#!/bin/sh  
  
case "${1}" in  
  resume|thaw)  
    nmcli r wifi off && nmcli r wifi on ;;  
esac  
  
Put this in /etc/pm/sleep.d/10_resume_wifi  
Make it executable sudo chmod 755 /etc/pm/sleep.d/10_resume_wifi and the problem should be fixed immediately.  
  
## 录像
kazam  
## 下载
- https://www.moerats.com/archives/347/ Aria2
执行以下命令：  
  
yum install aria2  #CentOS系统  
```
apt-get install aria2  #Debian/Ubuntu系统
```
使用  
1、直链下载  
下载直链文件，只需在命令后附加地址，如：  
  
aria2c http://xx.com/xx  
如果需要重命名为yy的话加上--out或者-o参数，如：  
  
aria2c --out=yy http://xx.com/xx  
aria2c -o yy http://xx.com/xx  
使用aria2的分段和多线程下载功能可以加快文件的下载速度，对于下载大文件时特别有用。-x 分段下载，-s 多线程下载，如：  
  
aria2c -s 2 -x 2 http://xx.com/xx  
这将使用2个连接和2个线程来下载该文件。  
  
2、BT下载  
种子和磁力下载：  
  
aria2c ‘xxx.torrnet‘  
aria2c '磁力链接'  
列出种子内容：  
  
aria2c -S xxx.torrent  
下载种子内编号为1、4、5、6、7的文件，如：  
  
aria2c --select-file=1,4-7 xxx.torrent  
设置bt端口：  
  
aria2c --listen-port=3653 ‘xxx.torrent’  
3、限速下载  
单个文件最大下载速度：  
  
aria2c --max-download-limit=300K -s10 -x10 'http://xx.com/xx'  
整体下载最大速度：  
  
aria2c --max-overall-download-limit=300k -s10 -x10 'http://xx.com/xx'  
这些基本都是常用的几个命令，更多的可以使用man aria2c和aria2c -h查看。  
  
## 翻译工具 stardict
网上词库资源多，支持点击选词翻译（在浏览器、PDF上均可）  
  
安装  
```
sudo apt install stardict
```
  
下载词典并复制到stardic相应目录（推荐朗文），打开stardic时会自动加载  
```
sudo cp -R stardict-langdao-ec-gb-2.4.2 /usr/share/stardict/dic/
```
  
打开stardic,点击界面的scan即可支持在屏幕上点击单词翻译的功能  
  
对比goldendict,网上下载词典资源较少，所以放弃  
## 对比工具，对比命令
- meld
  
- git 相关
git下查看本地的修改  
  
没有add时  
```
git diff file
```
  
已add时  
首先通过 =git status=，查看那些文件修改了，在执行下面的命令  
```
git difftool HEAD
```
此命令会调用本地的对比工具，安装信息  
```
See 'git difftool --tool-help' or 'git help config' for more details.
'git difftool' will now attempt to use one of the following tools:
meld opendiff kdiff3 tkdiff xxdiff kompare gvimdiff diffuse diffmerge ecmerge p4merge araxis bc codecompare emerge vimdiff
```
  
其他用法  
```
git difftool <commit1> <commit2>
```
  
比如刚 pull下来的代码有一个提交，想查看跟提交之前的代码相比有什么改进，我们就可以：  
```
git difftool HEAD~1
```
  
参考  
- https://www.chrisyue.com/linux-diff-tool-meld-vimdiff.html
  
  
## 命令行打开文件管理器
nautilus /etc  
## 内网穿透,开发联调工具
http://www.ittun.com/  
## ftp工具
filezilla  
  
## 中文乱码转码
### 从window拷贝代码到ubuntu（linux）乱码问题解决
```
iconv -f GBK -t UTF-8 bbbb.txt -o bbbb.txt
```
有时转码后依然会出现乱码，可以利用iconv的参数-c，忽略输出的非法字符，就可以了。  
```
iconv -f GBK  -t UTF-8 -c leach.m > leach1.m
```
http://blog.csdn.net/u010126792/article/details/61616884  
  
### 中文乱码批量转码
enca -L zh_CN -x utf-8 `find ./ -type f`  
- https://blog.csdn.net/a280606790/article/details/8504133
## sudo命令脚本中执行
- https://askubuntu.com/questions/425754/how-do-i-run-a-sudo-command-inside-a-script
## cron计划执行sudo命令
```
sudo crontab -e
```
- https://askubuntu.com/questions/173924/how-to-run-a-cron-job-using-the-sudo-command
  
## crontab命令
依次为 分 时 天 月 周  
  
```
sudo crontab -e 编写
sudo crontab -l 查看
```
  
脚本文件位置  
```
sudo vim /var/spool/cron/crontabs/root
```
  
注意  
脚本要有执行权限  
root权限使用命令 sudo crontab -e  
  
cron默认日志地址  
/var/log/syslog  
以下命令只查看文件中的cron日志  
```
grep CRON /var/log/syslog
```
  
  
控制默认日志地址  
去掉以下一行的注释  
#cron.*                         /var/log/cron.log  
ps: 除了/var/log/cron.log,/var/log/syslog会留下cron的日志  
```
sudo service rsyslog restart
```
  
  
计划脚本本身的output日志记录  
01 14 * * * /home/joe/myscript >> /home/log/myscript.log 2>&1  
以上命令将脚本所有output和error导向到日志文件中  
  
参考 https://askubuntu.com/questions/56683/where-is-the-cron-crontab-log  
  
## ufw 防火墙设置
Step 1 — Using IPv6 with UFW (Optional)  
```
sudo nano /etc/default/ufw
```
IPV6=yes  
  
Step 2 — Setting Up Default Policies  
```
sudo ufw default deny incoming
sudo ufw default allow outgoing
```
  
Step 3 — Allowing SSH Connections  
```
sudo ufw allow ssh
sudo ufw allow 22
```
ufw通过/etc/services的文件识别端口号  
  
...  
  
Step 7 — Deleting Rules  
By Rule Number  
```
sudo ufw status numbered
sudo ufw delete 2
```
  
Step 8 — Checking UFW Status and Rules  
```
sudo ufw status verbose
```
  
Step 9 — Disabling or Resetting UFW (optional)  
```
sudo ufw disable
sudo ufw reset
```
  
经测试，在本地添加防火墙  
```
sudo ufw default deny incoming
sudo ufw default allow outgoing
```
开启  
sudu ufw enable # 局域网内无法访问本机 http://ip_url  
查看  
```
sudo ufw app list
sudo ufw app info "Apache Full"
```
开启规则  
```
sudo ufw allow in "Apache Full"  # 可以访问 http://ip_url
```
删除规则  
```
sudo ufw status numbered
sudo ufw delete 2  # 无法访问 http://ip_url
```
  
  
参考 [How To Set Up a Firewall with UFW on Ubuntu 16.04](https://www.digitalocean.com/community/tutorials/how-to-set-up-a-firewall-with-ufw-on-ubuntu-16-04)  
## nohup用法
```
nohup node server.js > server.log 2>&1 &
```
查看  
```
jobs
jobs -l # 显示pid
fg
fg %n
kill -9 pid
```
https://ehlxr.me/2017/01/18/Linux-%E7%9A%84-nohup-%E5%91%BD%E4%BB%A4%E7%9A%84%E7%94%A8%E6%B3%95/  
https://code.juhe.cn/docs/203  
  
## 怎么登录后自动启动,自动执行程序
### 登录前执行
- https://developer.toradex.com/knowledge-base/how-to-autorun-application-at-the-start-up-in-linux
在/etc/profile.d/ 添加脚步,可以在登录前运行
sudo vim /etc/profile.d/autostart_teamviewer.sh

### 登录后执行
登录后需要自动运行的程序可以在.config/autostart/配置
sudo vim .config/autostart/teamviewer.desktop

[Desktop Entry]
Name=Teamviewer
Comment=...
Icon=teamviewer
Exec=teamviewer
Terminal=false
Type=Application
X-GNOME-Autostart-Delay=15

主要设置Name,Comment,Exec就好了

### 联网后执行
https://stackoverflow.com/questions/29513880/linux-execute-a-command-when-network-connection-is-restored
将脚本放在这里
/etc/network/if-up.d/
注意确保脚本是可执行的 chmod +x autostart_after_net.sh

### 常规启动
将脚本放到这里
/etc/init.d/autostart.sh
注意确保脚本可执行
链接到
sudo ln -s /etc/init.d/autostart.sh /etc/rc3.d/S05autostart
备注
S代表启动的意思，
rc3代表runlevel为3,
05代表排在03network等后面执行
参考
https://blog.csdn.net/easy_monky/article/details/38688573

### 通过systemctl控制
sudo vim /etc/systemd/system/autossh.service :
```
[Unit]
# By default 'simple' is used, see also https://www.freedesktop.org/software/systemd/man/systemd.service.html#Type=
# Type=simple|forking|oneshot|dbus|notify|idle
Description=Autossh keepalive daemon
## make sure we only start the service after network is up
Wants=network-online.target
After=network.target

[Service]
## here we can set custom environment variables
Environment=AUTOSSH_GATETIME=0
Environment=AUTOSSH_PORT=0
ExecStart=/usr/local/bin/ssh-keep-alive.sh
ExecStop=pkill -9 autossh
# don't use 'nobody' if your script needs to access user files
# (if User is not set the service will run as root)
#User=nobody


# Useful during debugging; remove it once the service is working
StandardOutput=console

[Install]
WantedBy=multi-user.target

https://unix.stackexchange.com/questions/166473/debian-how-to-run-a-script-on-startup-as-soon-as-there-is-an-internet-connecti
```
## 添加自启动快捷方式
```
sudo vim /usr/share/applications/pstorm.desktop
```
[Desktop Entry]  
Version=1.0  
Name=pstorm  
Exec=/opt/PhpStorm-172.3317.83/bin/phpstorm.sh  
Terminal=false  
Icon=/opt/PhpStorm-172.3317.83/bin/phpstorm.png  
Type=Application  
Categories=Development  
  
https://blog.csdn.net/walker0411/article/details/51555821  
## 设置普通用户no-root和ssh登录
```
useradd <username>
```
编辑主机名不然会报错 =sudo: unable to resolve host vultr.guest=  
```
nano /etc/hosts
nano /etc/hostname
reboot
```
  
```
sudo visudo
```
找到  
```
 # User privilege specification
root    ALL=(ALL:ALL) ALL
```
添加  
```
<username> ALL=(ALL:ALL) ALL
```
  
```
mkdir /home/<username>
chown <username>:<usergroup> /home/<username> -R
sudo passwd <username>
<username>:x:1000:1000::/home/<username>:/bin/bash
reboot
```
  
*ssh登录*  
ssh登入root用户后  
```
cp -r /root/.ssh /home/arpher
cd /home/arpher
chown -R arpher:arpher .ssh/
```
参考  
[Setup a Non-root User with Sudo Access on Ubuntu](https://www.vultr.com/docs/setup-a-non-root-user-with-sudo-access-on-ubuntuFfF)  
## sudo和su的区别
```
su root 相当于切换为root，输入的是root的密码
sudo command 相当于root管理员授权了你使用命令（可以是全部或部分），输入的是自己的密码
```
参考 [Why is the 'sudo' password different than the 'su root' password](https://unix.stackexchange.com/questions/109944/why-is-the-sudo-password-different-than-the-su-root-password)  
  
  
## 文件加密方案思路整理
### 单个文件加密
*使用linux文件权限机制加密*  
首先提高文件权限  
```
chown root:root file
chmod 600 file
```
修改文件权限为 =-rw-------=  
特点：本地管理方便，但获取本地账户密码后就可以拥有权限  
*使用 gpg 工具加密*  
是目前流行的加密工具  
特点：  
不易破解  
可对本地文件使用密码加密  
可用于传播加密文件，签名等  
### 文件夹加密
文件放到目录中，使用zip加密实现  
 - 为了方便兼容win linux等平台，可以用这个方案
 - 为了目前方便管理项目，暂时用私有仓库托管
  
## 文件加密工具gpg使用
全称 [GNU Privacy Guard](https://www.gnupg.org/index.html)  
  
查看是否安装  
gpg --help  
  
生成密钥  
gpg --gen-keys  
  
查看已生成的密钥  
gpg --list-keys  
  
加密文件  
  
gpg -c file  
加密后生成file.gpg  
  
解密文件  
gpg -o file -d file.gpg  
  
阮一峰的GPG入门教程  
```
二、安装

GPG有两种安装方式。可以下载源码，自己编译安装。

　　./configure
　　make
　　make install

也可以安装编译好的二进制包。

　　# Debian / Ubuntu 环境
　　sudo apt-get install gnupg

　　# Fedora 环境
　　yum install gnupg

安装完成后，键入下面的命令：

　　gpg --help

如果屏幕显示GPG的帮助，就表示安装成功。
三、生成密钥
安装成功后，使用gen-ken参数生成自己的密钥。
　　gpg --gen-key
回车以后，会跳出一大段文字：
　　gpg (GnuPG) 1.4.12; Copyright (C) 2012 Free Software Foundation, Inc.
　　This is free software: you are free to change and redistribute it.
　　There is NO WARRANTY, to the extent permitted by law.
　　请选择您要使用的密钥种类：
　　　(1) RSA and RSA (default)
　　　(2) DSA and Elgamal
　　　(3) DSA (仅用于签名)　
　　　(4) RSA (仅用于签名)
　　您的选择？
第一段是版权声明，然后让用户自己选择加密算法。默认选择第一个选项，表示加密和签名都使用RSA算法。
然后，系统就会问你密钥的长度。
　　RSA 密钥长度应在 1024 位与 4096 位之间。
　　您想要用多大的密钥尺寸？(2048)
密钥越长越安全，默认是2048位。
接着，设定密钥的有效期。
　　请设定这把密钥的有效期限。
　　　0 = 密钥永不过期
　　　<n> = 密钥在 n 天后过期
　　　<n>w = 密钥在 n 周后过期
　　　<n>m = 密钥在 n 月后过期
　　　<n>y = 密钥在 n 年后过期
　　密钥的有效期限是？(0)
如果密钥只是个人使用，并且你很确定可以有效保管私钥，建议选择第一个选项，即永不过期。回答完上面三个问题以后，系统让你确认。
　　以上正确吗？(y/n)
输入y，系统就要求你提供个人信息。
　　您需要一个用户标识来辨识您的密钥；本软件会用真实姓名、注释和电子邮件地址组合成用户标识，如下所示：
　　"Heinrich Heine (Der Dichter) <heinrichh@duesseldorf.de>"
　　真实姓名：
　　电子邮件地址：
　　注释：
"真实姓名"填入你姓名的英文写法，"电子邮件地址"填入你的邮件地址，"注释"这一栏可以空着。
然后，你的"用户ID"生成了。
　　您选定了这个用户标识：
　　　"Ruan YiFeng <yifeng.ruan@gmail.com>"
我的"真实姓名"是Ruan YiFeng，"电子邮件地址"是yifeng.ruan@gmail.com，所以我的"用户ID"就是"Ruan YiFeng <yifeng.ruan@gmail.com>"。系统会让你最后确认一次。
　　更改姓名(N)、注释(C)、电子邮件地址(E)或确定(O)/退出(Q)？
输入O表示"确定"。
接着，系统会让你设定一个私钥的密码。这是为了防止误操作，或者系统被侵入时有人擅自动用私钥。
　　您需要一个密码来保护您的私钥：
然后，系统就开始生成密钥了，这时会要求你做一些随机的举动，以生成一个随机数。
　　我们需要生成大量的随机字节。这个时候您可以多做些琐事(像是敲打键盘、移动鼠标、读写硬盘之类的)，这会让随机数字发生器有更好的机会获得足够的熵数。
几分钟以后，系统提示密钥已经生成了。
　　gpg: 密钥 EDDD6D76 被标记为绝对信任
　　公钥和私钥已经生成并经签名。
请注意上面的字符串"EDDD6D76"，这是"用户ID"的Hash字符串，可以用来替代"用户ID"。
这时，最好再生成一张"撤销证书"，以备以后密钥作废时，可以请求外部的公钥服务器撤销你的公钥。
　　gpg --gen-revoke [用户ID]
上面的"用户ID"部分，可以填入你的邮件地址或者Hash字符串（以下同）。
四、密钥管理
4.1 列出密钥
list-keys参数列出系统中已有的密钥．
　　gpg --list-keys
显示结果如下：
　　/home/ruanyf/.gnupg/pubring.gpg
　　-------------------------------
　　pub 4096R/EDDD6D76 2013-07-11
　　uid Ruan YiFeng <yifeng.ruan@gmail.com>
　　sub 4096R/3FA69BE4 2013-07-11
第一行显示公钥文件名（pubring.gpg），第二行显示公钥特征（4096位，Hash字符串和生成时间），第三行显示"用户ID"，第四行显示私钥特征。
如果你要从密钥列表中删除某个密钥，可以使用delete-key参数。
　　gpg --delete-key [用户ID]
4.2 输出密钥
公钥文件（.gnupg/pubring.gpg）以二进制形式储存，armor参数可以将其转换为ASCII码显示。
　　gpg --armor --output public-key.txt --export [用户ID]
"用户ID"指定哪个用户的公钥，output参数指定输出文件名（public-key.txt）。
类似地，export-secret-keys参数可以转换私钥。
　　gpg --armor --output private-key.txt --export-secret-keys
4.3 上传公钥
公钥服务器是网络上专门储存用户公钥的服务器。send-keys参数可以将公钥上传到服务器。
　　gpg --send-keys [用户ID] --keyserver hkp://subkeys.pgp.net
使用上面的命令，你的公钥就被传到了服务器subkeys.pgp.net，然后通过交换机制，所有的公钥服务器最终都会包含你的公钥。
由于公钥服务器没有检查机制，任何人都可以用你的名义上传公钥，所以没有办法保证服务器上的公钥的可靠性。通常，你可以在网站上公布一个公钥指纹，让其他人核对下载到的公钥是否为真。fingerprint参数生成公钥指纹。
　　gpg --fingerprint [用户ID]
4.4 输入密钥
除了生成自己的密钥，还需要将他人的公钥或者你的其他密钥输入系统。这时可以使用import参数。
　　gpg --import [密钥文件]
为了获得他人的公钥，可以让对方直接发给你，或者到公钥服务器上寻找。
　　gpg --keyserver hkp://subkeys.pgp.net --search-keys [用户ID]
正如前面提到的，我们无法保证服务器上的公钥是否可靠，下载后还需要用其他机制验证．
五、加密和解密
5.1 加密
假定有一个文本文件demo.txt，怎样对它加密呢？
encrypt参数用于加密。
　　gpg --recipient [用户ID] --output demo.en.txt --encrypt demo.txt
recipient参数指定接收者的公钥，output参数指定加密后的文件名，encrypt参数指定源文件。运行上面的命令后，demo.en.txt就是已加密的文件，可以把它发给对方。
5.2 解密
对方收到加密文件以后，就用自己的私钥解密。
　　gpg --output demo.de.txt --decrypt demo.en.txt
    gpg -o demo.txt -d demo.gpg
decrypt参数指定需要解密的文件，output参数指定解密后生成的文件。运行上面的命令，demo.de.txt就是解密后的文件。
GPG允许省略decrypt参数。
　　gpg demo.en.txt
运行上面的命令以后，解密后的文件内容直接显示在标准输出。
```
参考  
- [[http://www.ruanyifeng.com/blog/2013/07/gpg.html][GPG入门教程]] 阮一峰的文章，通俗易懂，文章内也有加密算法的介绍链接 [RSA算法](http://www.ruanyifeng.com/blog/2013/06/rsa_algorithm_part_one.html)
- [Linux: HowTo Encrypt And Decrypt Files With A Password](https://www.cyberciti.biz/tips/linux-how-to-encrypt-and-decrypt-files-with-a-password.html)
- [GnuPG (简体中文)](https://wiki.archlinux.org/index.php/GnuPG_(%E7%AE%80%E4%BD%93%E4%B8%AD%E6%96%87)#.E6.96.B0.E7.94.A8.E6.88.B7.E7.9A.84.E9.BB.98.E8.AE.A4.E9.80.89.E9.A1.B9) 来自 https://wiki.archlinux.org/
  
## terminal终端ssh登录自动退出的解决
编辑 $HOME/.ssh/config （如果不存在的话创建）
Host *
    ServerAliveInterval 240
	
如果是对特定的ip
Host remotehost
    HostName remotehost.com
    ServerAliveInterval 240
	
这样每4分钟会请求一次，保证不断连接

https://stackoverflow.com/questions/25084288/keep-ssh-session-alive

## su su-和sudo的区别
sudo -s 切换到root
```
  
我首先是用su命令切换到root身份的，但是运行useradd时，出现错误：bash: useradd: command not found。google了一下，原因是在这个用su命令切换过来的root用户上。  
  
su命令和su -  
命令最大的本质区别就是：前者只是切换了root身份，但Shell环境仍然是普通用户的Shell；而后者连用户和Shell环境一起切换成root身份了。只有切换了Shell环境才不会出现PATH环境变量错误。su切换成root用户以后，pwd一下，发现工作目录仍然是普通用户的工作目录；而用su -命令切换以后，工作目录变成root的工作目录了。  
  
```
sudo 执行命令的流程是当前用户切换到root（或其它指定切换到的用户），然后以root（或其它指定的切换到的用户）身份执行命令，执行完成后，直接退回到当前用户；而这些的前提是要通过sudo的配置文件/etc/sudoers来进行授权；
```
它的特性主要有这样几点：  
　　 sudo能够限制用户只在某台主机上运行某些命令。  
　　 sudo提供了丰富的日志，详细地记录了每个用户干了什么。它能够将日志传到中心主机或者日志服务器。  
　　 sudo使用时间戳文件来执行类似的“检票”系统。当用户调用sudo并且输入它的密码时，用户获得了一张存活期为5分钟的票（这个值可以在编译的时候改变）。  
　　 sudo的配置文件是sudoers文件，它允许系统管理员集中的管理用户的使用权限和使用的主机。它所存放的位置默认是在/etc/sudoers，属性必须为0411。  
  
参考  
- http://www.ha97.com/4001.html
- http://blog.51cto.com/fuwenchao/1340685

adduser命令  
在使用adduser命令时,它会提示添加这个用户名,并创建和用户名名称相同的组名,并把这个用户名添加到自己的组里去,并在/home目录想创建和用户名同名的目录,并拷贝/etc/skel目录下的内容到/home/用户名/的目录下,并提示输入密码,并提示填写相关这个用户名的信息。  
  
用adduser这个命令创建的账号是普通账号,可以用来登陆系统.  
  
例如：  
```
adduser Jim
adduser --gecos 'Git User' --disabled-password --home /home/git git
```
  
选项--gecos 可参考 https://en.wikipedia.org/wiki/Gecos_field  
  
  
useradd命令  
命令说明: 在使用命令useradd时，它会添加这个用户名，并创建和用户名相同的组名，但它并不在/home目录下创建基于用户名的目录,也不提示创建新的密码。也就是说使用useradd mongo 创建出来的用户,将是默认的"三无"用户,无家目录,无密码,无系统shell,换句话说,它创建的是系统用户,无法用它来登陆系统.  
  
常用命令行选项：  
-d：           指定用户的主目录
-m：          如果存在不再创建，但是此目录并不属于新创建用户；如果主目录不存在，则强制创建； -m和-d一块使用。
-s：           指定用户登录时的shell版本
-M：           不创建主目录
  
例如：  
```
sudo  useradd  -d '/home/git' -m -s '/bin/bash' git
