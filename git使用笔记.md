  
## 常用快捷键
		    状态    git status  
工作区添加到暂存    git add readme.txt  
					git add .  
暂存区添加到本地    git commit -m '修改了bug'    没有add的文件不会commit到本地  
		日记显示	git log  
					git log --pretty=oneline  
		命令记录	git reflog    查看commit号码  
  
  
		区别显示	git diff readme.txt   查看工作区修改了什么  
					git diff HEAD -- readme.txt  查工作区和最新版本库的区别  
					git diff HEAD^ -- readme.txt  查工作区和上次版本库的区别  
撤销修改从工作区(未commit)	git checkout -- readme.txt  
							git checkout -- .  
撤销修改从暂存区(已commit)	git reset HEAD -- readme.txt  
  
回退  
本地版本时光穿梭	git reset --hard HEAD^  
					git reset --hard HEAD^^  
					git reset --hard HEAD~5  
					git reset --hard de321d1  
  仅回退提交消息	git reset --soft de32  
  回退消息和index   git reset de32  
  
 git reset --hard 指回滚后上次修改的文件在本地也删除掉了  
 git reset  指回滚后上次的修改在本地是unstaged状态。可以用git status查看  
修改完成后可以git push orgin master --force  
  
如果仅仅是commit消息写错了，可以：  
```
git commit --amend
```
参考 [Undo a commit and redo](https://stackoverflow.com/questions/927358/how-to-undo-the-most-recent-commits-in-git)  
  
## 实例流程
 修改文件  
		初始化      git init  
		添加		git add  
		提交		git commit -m '第一版'  
		添加标签    git tag '1.0'  
		添加		git add  
		提交		git commit -m '第二版'  
		添加标签    git tag '2.0'  
  
  列出标签和信息    git tag -n  
		查看标签    git show 1.0  
	切换到一标签    git reset --hard 2.0 切换到标签2.0  
	后期添加标签	git tag v1 bb29  
  
创建SSH Key			ssh-keygen -t rsa -C "201313488@qq.com"  
  
把本地的推送到远程  github.com  点击“Create repository”按钮  
根据GitHub的提示    git remote add origin https://github.com/kyronbao/eeee.git  
下一步，推送到远程  git push -u origin master  
					-u第一次推送master分支的所有内容  
此后，使用命令		git push origin master   推送最新修改  
  
推送远程不用密码方法  
	1切换到路径		git remote set-url --push origin git@github.com:kyronbao/eeee.git  
		再使用		git push origin master  
	2或者第一次时   git remote add origin git@github.com:kyronbao/bbbb.git  
  
  
## git flow工作流
安装  
```
sudo apt-get install git-flow
```
  
参考  
[git-flow 备忘清单](https://danielkummer.github.io/git-flow-cheatsheet/index.zh_CN.html)  
[git-flow 的工作流程](https://www.git-tower.com/learn/git/ebook/cn/command-line/advanced-topics/git-flow)  
  
[Installing on Linux, Unix, etc.](https://github.com/petervanderdoes/gitflow-avh/wiki/Installing-on-Linux,-Unix,-etc.)  
https://segmentfault.com/l/1500000009978736  
  
  
  
  
## 一般远程流程
	1 建远程仓库 (勾选README.md)  
	2 克隆到本地	git clone git@github.com:kyronbao/ffff.git  
					(如果https 需要以后输入密码push)  
	3 进入目录		cd ffff  
	4 操作,提交		git push origin master  
  
## 分支
查看分支：				git branch  
创建分支：				git branch <name>  
切换分支：				git checkout <name>  
创建+切换分支：			git checkout -b <name>  
合并某分支到当前分支：	git merge <name>  
删除分支：				git branch -d <name  
  
## 合并
当合并时出现冲突时  
	查看哪个文件		git status  
	在文件处理完冲突	git add .  
						git commit -m 'conflict hander'  
	再次执行合并		git merge feature1  
	加上--no-ff参数  
	合并后的历史有分支	git merge --no-ff -m "merge with no-ff" feature1  
查看合并分支			git log --graph --pretty=oneline --abbrev-commit  
创建远程origin的release分支到本地	git checkout -b release origin/release  
  
  
## 实际项目开发流程(分支管理策略)
	1 github上创建仓库,  
		勾选README.md  
	2 克隆到本地		git clone git@github.com:kyronbao/cccc.git  
	3 创建dev分支		git checkout -b dev  
	4 创建login分支		git checkout -b login  
		查看分支		git branch  
	5 在login分支下  
				编辑	git add .  
				  提交	git commit -m '完成登录表单'  
				  编辑  git add .  
				  提交	git commit -m '完成用户数据库'  
				  编辑	git add .  
				  提交	git commit -m '登录页面美化'  
	6 切换到dev分支		git checkout dev  
		合并login分支	git merge --no-ff -m '差不多完成了登录功能' login  
		查看			git log --graph  
		删除login分支	git branch -d login  
		提交dev到远程	git push origin dev  
	7 额外添加验证码  
		切换到login分支	git checkout -b login2  
			编辑		git add .  
			提交		git commit -m '完成验证码功能'  
		切换到dev分支	git checkout dev  
			合并		git merge --no-ff -m '登录功能完善' login2  
		查看			git lg  
		删除login2		git branch -d login2  
  
  
	8 完成版本1.0开发  
		切换到master分支	git checkout master  
		合并dev分支			git merge --no-ff -m '更新了登录功能' dev  
		查看				git lg  
  
	9 提交到远程		git push origin dev  
						git push origin master  
  
  
  
## git多账户管理
### github多帐户
	因为多了一个kyronbao@github账户,所以在同一台电脑下push到这个账户时会收到  
		ERROR: Permission to kyronbao/hello.git denied to kyronbao.  
		的错误提示,所以为此账户添加ssh  
	参考  
		https://www.zybuluo.com/yangfch3/note/172120  
		http://www.jianshu.com/p/f7f4142a1556  
  
	在C:\Users\ThinkPad\.ssh 目录下,生成ssh公私钥  
		ssh-keygen -t rsa -C "kyronbao@gmail.com"  
			根据提示,第一次输入id_rsa_github_kyronbao,第二三次直接回车  
	取消全局设置  
		git config --global --unset user.name  
		git config --global --unset user.email  
	新建config文件  
		touch config  
		vi config  
			# Default github user(kyronbao@gmail.com)  默认配置，一般可以省略  
			Host github.com  
			Hostname github.com  
			User kyronbao  
			Identityfile ~/.ssh/github  
  
			# second user(kyronbao@gmail.com)  给一个新的Host称呼  
			Host kyronbao.github.com  
			HostName github.com  
			User kyronbao  
			IdentityFile C:/Users/ThinkPad/.ssh/id_rsa_github_kyronbao  
  
	测试  
		ssh -T git@kyronbao.github.com  
  
	使用  
		情景1：使用新的公私钥进行克隆操作  
			git clone git@kyronbao.github.com:kyronbao/hello.git  
			注意此时要把原来的github.com配置成你定义的kyronbao.github.com  
		情景2：已经克隆，之后才添加新的公私钥，我要为仓库设置使用新的公私钥进行push操作  
			修改仓库的配置文件：.git/config 为  
			[remote "origin"]  
				url = git@kyronbao.github.com:kyronbao/hello.git  
  
### 为某一个ip设置ssh
将私钥保存在.ssh目录下，命名为例如id_rsa_sfabric

在文件口添加
```
Host the-real-ip
    Hostname the-real-ip
    IdentityFile ~/.ssh/id_rsa_sfabric
    IdentitiesOnly yes
```
注意：私钥文件的权限需要检查正确：
```
ls -la .ssh/
total 32
drwx------  2 kyron kyron 4096 Feb  4 12:38 .
drwx------ 58 kyron kyron 4096 Feb  4 13:29 ..
-rw-r--r--  1 kyron kyron  110 Sep  7 09:36 config
-rw-------  1 kyron kyron 3243 Jun  4  2019 id_rsa
-rw-r--r--  1 kyron kyron  744 Jun  4  2019 id_rsa.pub
-rw-------  1 kyron kyron 1675 Feb  4 12:38 id_rsa_sfabric
-rw-r--r--  1 kyron kyron 5680 Nov 10 17:09 known_hosts``
```
## git下载基于其中一个分支开发
	克隆 实际上是克隆了所以远程的分支  
		git clone git@github.com:kyronbao/cccc.git  
	查看所有分支  
		git branch -a  
		  * master  
		  remotes/origin/HEAD -> origin/master  
		  remotes/origin/dev  
		  remotes/origin/master  
	切换到远程dev分支查看  
		git checkout origin/dev  
	从远程dev分支创建本地dev开发  
		git checkout -b dev origin/dev  
			再次查看  
				git branch  
				git branch -a  
	参考  
		http://justlpf.blog.51cto.com/3889157/1217508  
  
  
  
  
## 简化命令
```
vim .gitconfig
# 添加

```
  
在Ubuntu下.bashrc文件包含.bash_aliases，所以可以：  
```
cd
vim .bash_aliases
# 加入以下内容
alias gitps="git add . && git commit -m '...' && git push"


# 生效
source .bashrc
```
  
备注：  
查看修改过的日志可以使用  
```
vim .gitconfig
# 添加
[alias]
    st = status
    co = checkout
    ad = add .
    cm = commit -m '...'
    ps = push
    lg = log --graph --pretty='format:%C(red)%d%C(reset) %C(yellow)%h%C(reset) %ar %C(green)%aN%C(reset) %s'

# git lg -d选项可以显示修改的内容
```
  
## 解决中文乱码
```
git config --global core.quotepath false  		# 显示 status 编码
git config --global gui.encoding utf-8			# 图形界面编码
git config --global i18n.commit.encoding utf-8	# 提交信息编码
git config --global i18n.logoutputencoding utf-8	# 输出 log 编码
export LESSCHARSET=utf-8
# 最后一条命令是因为 git log 默认使用 less 分页，所以需要 bash 对 less 命令进行 utf-8 编码
```
参考 https://gist.github.com/nightire/5069597  
## 更新本地gitignore
修改.gitignore  
简单实例  
```
# 此为注释 – 将被 Git 忽略
# 忽略所有 .a 结尾的文件
*.a
# 但 lib.a 除外
*
!lib.a
# 仅仅忽略项目根目录下的 TODO 文件，不包括 subdir/TODO
/TODO
# 忽略 build/ 目录下的所有文件
build/
# 会忽略 doc/notes.txt 但不包括 doc/server/arch.txt
doc/*.txt
# 会忽略掉 doc/ 里面所有的txt文件，包括子目录下的（**/ 从 Git 1.8.2 之后开始支持 **/ 匹配模式，表示递归匹配子目录下的文件）
doc/**/*.txt
```
  
同步remote端和本地端  
```
# 注意有个点“.”
git rm -r --cached .
git add -A
git commit -m "update .gitignore"
```
  
  
## 设置名称和邮箱
```
git config --global user.name "Your Name"
git config --global user.email "email@example.com"
```
  
  
## git部署服务器
### 个人简单
http://jser.me/2013/12/29/%E5%88%A9%E7%94%A8git%E5%BF%AB%E9%80%9F%E9%83%A8%E7%BD%B2%E8%BF%9C%E7%A8%8B%E6%9C%8D%E5%8A%A1%E5%99%A8.html  
服务器端操作  
首先创建一个裸库，为什么是裸库？因为这个库不是真正用来修改的，我们也不允许在服务器上修改代码，我们只是把它当作一个代码中转的地方  
  
```
cd /opt
mkdir git-pro
cd git-pro
git init --bare
```
添加我们的hook  
  
```
cd hooks
touch post-receive
```
编辑post-receive的内容为下面的，其中opt/git-pro，是我们存放网站代码地方  
  
env -i git archive master | tar -x -C /opt/git-pro  
```
echo "远程更新完毕"
```
本地git的操作  
本地我们只需要添加一个远程库，在需要部署的时候push到远程库就行了,下面我们添加了一个名为publish的远程库  
  
```
git remote add publish root@192.168.0.107:/opt/git-pro
git push publish master
```
可以强化的地方  
这里演示的是一个简单的小网站的部署过程，复杂的情况下我们还可以添加静态资源版本更新，服务器重启等等，举一反三， 最大程序自动化我们的工作  
  
### 多人
https://linux.cn/article-7800-1.html#3_7195  
创建 gituser 用户  
adduser gituser  
  
创建一个 ~/.ssh 的框架  
```
su - gituser
mkdir .ssh && chmod 700 .ssh
touch .ssh/authorized_keys
chmod 600 .ssh/authorized_keys
```
  
开放权限允许bob  
```
cat ~/path/to/id_rsa.bob.pub >> /home/gituser/.ssh/authorized_keys
```
  
echo `which git-shell` >> /etc/shells  
```
usermod -s git-shell gituser
```
  
```
usermod -a -G gituser kyronbao
```
  
以 root 身份创建一个空的仓库  
git init --bare /opt/jupiter.git  
chown -R gituser:gituser /opt/jupiter.git  
chmod -R 770 /opt/jupiter.git  
  
测试  
```
git clone ssh://192.168.0.107:/opt/kyronbao.git
```
或者  
git remote add origin ssh://192.168.0.107:/opt/kyronbao.git  
```
cd kyronbao.git
```
编辑  
```
git add .
git commit -m 'bbbb'
git push
```
  
### Bitbucket Server 安装
http://blog.topspeedsnail.com/archives/8865  
### 创建远程服务器
在 远程根目录创建裸仓库 git init --bare demo.git  
                 （裸仓库没有工作区）  
https://www.kancloud.cn/kancloud/igit/46716  
https://www.liaoxuefeng.com/wiki/0013739516305929606dd18361248578c67b8067c8c017b000/00137583770360579bc4b458f044ce7afed3df579123eca000  
  
## tag相关操作
下载tag  
```
git clone --branch v1.6.5.7 https://github.com/ManaPlus/ManaPlus.gi
```
或 -b  
列出所有tag:  git tag  
打tag:  git tag v1  
删除本地tag  git tad -d v1  
删除远程tag  git push origin :refs/tags/v1  
推送所有tag: git push orign --tags  
## Git 用法之Git Stash
 备份当前的工作区的内容，从最近的一次提交中读取相关内容，让工作区保证和上次提交的内容一致。同时，将当前的工作区内容保存到Git栈中。  
  
```
git stash pop: 从Git栈中读取最近一次保存的内容，恢复工作区的相关内容。由于可能存在多个Stash的内容，所以用栈来管理，pop会从最近的一个stash中读取内容并恢复。
```
  
```
git stash list: 显示Git栈内的所有备份，可以利用这个列表来决定从那个地方恢复。
```
  
```
git stash clear: 清空Git栈。此时使用gitg等图形化工具会发现，原来stash的哪些节点都消失了。
```
  
```
git stash apply :从Git栈中读取一次保存的内容,恢复工作区的相关内容,但不清除栈中的内容;
```
  
关于Git Stash的详细解释，适用场合，这里做一个说明：  
  
使用git的时候，我们往往使用branch解决任务切换问题，例如，我们往往会建一个自己的分支去修改和调试代码, 如果别人或者自己发现原有的分支上有个不得不修改的bug，我们往往会把完成一半的代码 commit提交到本地仓库，然后切换分支去修改bug，改好之后再切换回来。这样的话往往log上会有大量不必要的记录。其实如果我们不想提交完成一半或者不完善的代码，但是却不得不去修改一个紧急Bug，那么使用'git stash'就可以将你当前未提交到本地（和服务器）的代码推入到Git的栈中，这时候你的工作区间和上一次提交的内容是完全一样的，所以你可以放心的修 Bug，等到修完Bug，提交到服务器上后，再使用'git stash apply'将以前一半的工作应用回来。也许有的人会说，那我可不可以多次将未提交的代码压入到栈中？答案是可以的。当你多次使用'git stash'命令后，你的栈里将充满了未提交的代码，这时候你会对将哪个版本应用回来有些困惑，'git stash list'命令可以将当前的Git栈信息打印出来，你只需要将找到对应的版本号，例如使用'git stash apply stash@{1}'就可以将你指定版本号为stash@{1}的工作取出来，当你将所有的栈都应用回来的时候，可以使用'git stash clear'来将栈清空。  
  
在这里顺便提下git format-patch -n , n是具体某个数字， 例如 'git format-patch -1' 这时便会根据log生成一个对应的补丁，如果 'git format-patch -2' 那么便会生成2个补丁，当然前提是你的log上有至少有两个记录。  
  
  
  
看过上面的信息，就可以知道使用场合了：当前工作区内容已被修改，但是并未完成。这时Boss来了，说前面的分支上面有一个Bug，需要立即修复。可是我又不想提交目前的修改，因为修改没有完成。但是，不提交的话，又没有办法checkout到前面的分支。此时用Git Stash就相当于备份工作区了。然后在Checkout过去修改，就能够达到保存当前工作区，并及时恢复的作用。  
- https://zhuanlan.zhihu.com/p/28608106
## 怎么修改commit过的用户名邮箱
- https://www.git-tower.com/learn/git/faq/change-author-name-email
## 修改远程分支的commit
首先利用phpstorm Reset Current branch to here  
当修改过本地后，使用+强制提交覆盖上一次版本  
```
git push bitbucket +dev
```
- https://ncona.com/2011/07/how-to-delete-a-commit-in-git-local-and-remote/
  
## 重命名本地和远程分支
1. Rename your local branch.  
If you are on the branch you want to rename:  
  
```
git branch -m new-name
```
If you are on a different branch:  
  
```
git branch -m old-name new-name
```
2. Delete the old-name remote branch and push the new-name local branch.  
  
```
git push origin :old-name new-name
```
3. Reset the upstream branch for the new-name local branch.  
Switch to the branch and then:  
  
```
git push origin -u new-name
```
## 本地的feature分支提交到远程的master
```
git push github HEAD:master
```
  
## git删除本地和远程分支
Executive Summary  
```
git push --delete <remote_name> <branch_name>
git branch -d <branch_name>
```
Note that in most cases the remote name is origin.  
  
Delete Local Branch  
To delete the local branch use one of the following:  
  
```
git branch -d branch_name
git branch -D branch_name
```
Note: The -d option is an alias for --delete, which only deletes the branch if it has already been fully merged in its upstream branch. You could also use -D, which is an alias for --delete --force, which deletes the branch "irrespective of its merged status." [Source: man git-branch]  
- [How do I delete a Git branch locally and remotely?](https://stackoverflow.com/questions/2003505/how-do-i-delete-a-git-branch-locally-and-remotely)
## merge合并时怎么排除文件
从laravel分支合并到dev分支，怎么排除readme.md composer.json等文件  
  
首先在dev分支根目录的.gitattributes或者.git/info/attributes添加  
composer.json merge=ours  
readme.md merge=ours  
  
然后定义一个虚拟的合并策略，叫做 ours：  
```
git config --global merge.ours.driver true
```
  
然后切换到dev分支使用phpstorm合并或命令  
```
git merge --no-ff laravel
```
  
注意：必须 readme.md 和 composer.json必须有冲突才会排除合并  
可以在合并前在dev分支修改上面的文件，然后在合并  
  
参考  
- [git-scm.com/book/zh/v2/自定义-Git-Git-属性](https://git-scm.com/book/zh/v2/%E8%87%AA%E5%AE%9A%E4%B9%89-Git-Git-%E5%B1%9E%E6%80%A7)
- https://stackoverflow.com/questions/15232000/git-ignore-files-during-merge
## 其他参考
[Git的奇技淫巧]( https://github.com/521xueweihan/git-tips)  
[阮一峰 常用 Git 命令清单](http://www.ruanyifeng.com/blog/2015/12/git-cheat-sheet.html)  
