
## No appropriate protocol (protocol is disabled or cipher suites are inappropriate)
1、打开终端，输入 svn ls https://(这里是自己对应项目的地址)
2、输入p，随意输入密码
3、根据要求输入svn的账号密码
4、刷新

参考　https://www.jianshu.com/p/1d8669bcd347
## 拉代码时不更新，子目录对应的版本不一致，有Switched Files
检查发现，子目录里有些版本对应的是上次开发的版本
参考　https://stackoverflow.com/questions/7854001/what-are-switched-files-with-regard-to-svn-intellij
svn st 发现　含有
    S  file1.txt
    S  file2.txt
在根目录执行
　svn switch URL
可以递归切换子目录的对应分支
再次执行　svn st 发现ok
## 第一次检出checkout
要从trunk分支检出 
如
svn co https://subvs.szhibu.com:1443/svn/FabTradERP/04Code/BMP/product/server/trunk/ productcatalog

## composer update后无法更新代码？ phpstorm清除授权密码缓存
1 setting->Version Control->Subversion->clear Auth Cache
2 这样清除了之后在项目中svn up时会重新提示输入密码
## phpstorm设置svn

### window10
https://blog.csdn.net/qiuhuanghe/article/details/109352279
安装小乌龟时 第二个command选项要开启
phpstorm setting subvisiton设置 /bin/svn.exe
拉代码时可以直接检出branch分支
### 深度 deepin

安装svn
sudo apt-get install subversion

phpstorm vcs-->checkout from version control-->subversion

按提示操作是报错
Cannot check out from SVN: No appropriate protocol
解决：File-->setting-->version control-->subversion->勾选enabel interactive mode


svn: E165001: 提交失败(细节如下): 
svn: E165001: Commit blocked by pre-commit hook (exit code 1) with output:
[Error output could not be translated from the native locale to UTF-8.]
解决：svn commit -m '这里的注释要长，要是汉字就不会报错'

## 参考
https://www.jianshu.com/p/fd8680f1d0c1 Debian 上安装SVN 过程
https://intellij-support.jetbrains.com/hc/en-us/community/posts/360000403700-Cannot-check-out-from-SVN-No-appropriate-protocol-HELP-
https://www.jianshu.com/p/39c6d345a521 phpstorm配置SVN版本控制器

