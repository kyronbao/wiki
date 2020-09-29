## 第一次检出checkout
要从trunk分支检出 
如
svn co https://subvs.szhibu.com:1443/svn/FabTradERP/04Code/BMP/product/server/trunk/ productcatalog

## phpstorm清除授权密码缓存
1 setting->Version Control->Subversion->clear Auth Cache
2 这样清除了之后在项目中svn up时会重新提示输入密码
## phpstorm设置svn
环境
深度 deepin

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

