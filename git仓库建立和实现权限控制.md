  
## 限制git用户只执行git的权限通过git-shell  
  
其中权限管理有不同仓库的读权限和不同分支的相关权限设置  
## 方法一 无安装软件解决方案  [[https://git-scm.com/book/zh/v1/%E6%9C%8D%E5%8A%A1%E5%99%A8%E4%B8%8A%E7%9A%84-Git-%E5%9C%A8%E6%9C%8D%E5%8A%A1%E5%99%A8%E4%B8%8A%E9%83%A8%E7%BD%B2-Git][在服务器上部署 Git]] 小型安装  [Setting Up the Server](https://git-scm.com/book/en/v2/Git-on-the-Server-Setting-Up-the-Server) <2018-01-16 二>
  
在远程服务器上设置git用户可ssh登录  
  
建立远程仓库  
用root权限确定仓库地址和git拥有权限  
```
su root
cd /opt
mkdir git && cd git
```
  
如果是新的仓库  
```
mkdir new-project.git && cd new-project.git
chown -R git:git ./
git init --bare
```
如果已有仓库 old-project  
```
git clone --bare old-project old-project.git # 相当于 cp -Rf old-project/.git old-project.git
scp -r old-project.git root@username:/opt/git/ # 本地执行
chown -R git:git /opt/git/old-project.git/
chmod 755 /opt/git/old-project.git/
```
  
然后可以在本地通过git客户端下载了  
```
git clone git@hostname:/opt/git/xxx-project.git
```
  
## 方法二 使用git服务器框架 <2018-01-17 三>
  
https://www.zhihu.com/question/29534213 推荐使用gerrit来进行权限和codereview管理  
Gerrit https://zh.wikipedia.org/wiki/Gerrit  
Gerrit，一种开放源代码的代码审查软件，使用网页界面。利用网页浏览器，同一个团队的软件程序员，可以相互审阅彼此修改后的代码，决定是否能够提交，退回或是继续修改。它使用版本控制系统，Git作为底层。  
http://softlab.sdut.edu.cn/blog/subaochen/2016/01/github_like_softwares/ 几个GIT仓库开源软件的比较 推荐gogs https://gogs.io/docs  
  
权限控制方面用的多的是gitosis和gitolite  
gitolite [[https://github.com/sitaramc/gitolite][sitaramc/gitolite]]  [[http://www.linuxidc.com/Linux/2017-07/145764.htm][CentOS 7中安装搭建Git服务器Gitolite]] [使用gitolite管理git授权](https://czero000.github.io/2016/10/19/use-gitolite-manager-git.html) ubuntu16.04版  
gitosis [伺服器上的 Git - Gitosis](https://git-scm.com/book/zh-tw/v1/%E4%BC%BA%E6%9C%8D%E5%99%A8%E4%B8%8A%E7%9A%84-Git-Gitosis)  
  
对比分析了一下  
gitolite文档较全，维护时间较新，获得star多，权限控制粒度更细  
  
install gitolite  
  
```
scp ~/.ssh/id_rsa.pub root@gitserver:/tmp/admin.pub
ssh root@gitserver
```
adduser git  
```
su - git
```
  
```
git clone https://github.com/sitaramc/gitolite
mkdir -p $HOME/bin
```
gitolite/install -to $HOME/bin  
```
ls ~/bin # find some files installed
```
  
```
cp /tmp/admin.pub ~/
```
$HOME/bin/gitolite setup -pk admin.pub  
```
cat ~/.ssh/authorized_keys # find admin's key added
```
  
local  
```
ssh git@gitserver  # prompt some messege success
git clone git@gitserver:gitolite-admin
cd gitolite-admin
```
  
```
vim conf/gitolite.conf
```
```
@foo_admin   =   admin
@foo_staff   =   Demon

repo gitolite-admin
    RW+     =   admin

repo testing
    RW+     =   @all

repo foo
    RW+         =    @foo_admin
    - master    =    @foo_staff # 该组不能管理master分支，注意和下一行顺序不能反
    RW          =    @foo_staff
```
  
```
access rule examples
Gitolite's access rules are very powerful. The simplest use was already shown above. Here is a slightly more detailed example:

repo foo
    RW+                     =   alice
    -   master              =   bob
    -   refs/tags/v[0-9]    =   bob
    RW                      =   bob
    RW  refs/tags/v[0-9]    =   carol
    R                       =   dave
Here's what these example rules say:

alice can do anything to any branch or tag -- create, push, delete, rewind/overwrite etc.

bob can create or fast-forward push any branch whose name does not start with "master" and create any tag whose name does not start with "v"+digit.

carol can create tags whose names start with "v"+digit.

dave can clone/fetch.

Please see the main documentation linked above for all the gory details, as well as more features and examples.
```
```
用户管理可以给用户或者仓库分组 @代表组，成员之间空格分隔
@oss_repos = linux perl gitolite
@admin     = Cc
@devops    = alice bob charlie
权限分类

C: 代表创建，仅用在通配符版本库授权时可以使用，用于指定那个用户可以创建和通配符匹配版本库
R: 只读
RW: 读写
RW+: 除了读写权限，还可以对 rewind 的提交强制 push
RWC、RW+C: 只有当授权指令中定义了正则引用（正则表达式定义的分支、里程碑等），才可以使用该授权指令。其中 C 的含义是允许创建和正则引用匹配的引用（分支或里程碑等）。
RWD, RW+D: 只有当授权指令中定义了正则引用（正则表达式定义的分支、里程碑等），才可以使用该授权指令。其中 D 的含义是允许删除和正则引用匹配的引用（分支或里程碑等）。
RWCD, RW+CD: 只有当授权指令中定义了正则引用（正则表达式定义的分支、里程碑等），才可以使用该授权指令。其中 C 的含义是允许创建和正则引用匹配的引用（分支或里程碑等），D 的含义是允许删除和正则引用匹配的引用（分支或里程碑等）。
拒绝访问

还有一种权限是 `-`表示拒绝， 拒绝
RW  master integ    = @engineers
-   master integ    = @engineers
RW+                 = @engineers
限制文件

repo foo
  RW    = @devops
  - VERF/Makefile    = @devops
```
  
```
cp public_key_path/id_rsa.pub ./keydir/Demon.pub  # Demon is username
```
  
```
git commit -a -m '...'
```
  
测试  
admin用户可以提交master,develop等分支，  
Demon用户对master分支提交提示无权限! [remote rejected] master -> master (hook declined)  配置成功  
更加详细的权限管理可参考github,如对tag的权限管理等  
