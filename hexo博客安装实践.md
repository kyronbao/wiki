  
```
mkdir hexo && cd hexo
sudo cnpm install -g hexo
```
  
提示 link /usr/local/node/bin/hexo@ -> /usr/local/node/lib/node_modules/hexo/bin/hexo  
-g代表全局依赖 安装后可以在其他目录任意调用，如webback等可以使用全局安装;
本地安装的优点是升级依赖、重命名等时可以和全局的依赖避免冲突  
参考 http://www.cnblogs.com/zhuzhenwei918/p/7228915.html  
  
```
sudo hexo init
sudo cnpm install hexo-deployer-git --save
```
hexo d  
  
使用命令  
```
hexo generate = hexo g
hexo server = hexo s
hexo delopy = hexo d
hexo new = hexo n
```
参考 [[http://www.jianshu.com/p/ed32ac187dbc]]  
