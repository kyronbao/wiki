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
