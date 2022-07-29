VirtrulBox

小程序相关开发工具（un-app）在linux上不兼容，可以通过virturalbox搭建前段环境，来和本机的后端联调。  

实践环境：  
- 本机：deepin15.11/debian9.0
- 虚拟环境：win7

操作步骤：  

```
sudo apt install virtualbox
```
备注：先搜索看看debian,ubuntu相关的有没有源  

通过win7镜像(.iso文件)安装  
  1.下载qq软件管家，下载git
  2. scp user@host:/home/user/.ssh/id_rsa ./ 
    git clone git@host...
	安装Ｈbuider,威信开发工具

修改win7的host文件,如
　　192.168.1.46 www.exhibition.sm  

开始联调
　修改前端


备注：　
　虚拟主机窗口调整显示下（默认窗口小）

　　　win7窗口->设备->安装增强功能
　　　进入win7,桌面的计算机->点击可移动存储设备：Virtural Box Guest additions
        ->点击安装：VBoxWindowsAdditions-amd64
  
     win7->Devices->Insert guset additions CD image
	 




