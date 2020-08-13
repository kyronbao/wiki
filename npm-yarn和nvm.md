npm和yarn  
## nvm
安装nvm  
参考 - https://github.com/nvm-sh/nvm#git-install  
  
使用nvm安装node  
查看node最新版本  
nvm ls-remote node  
安装  
nvm install v10.15.3  
  
使用  
nvm list  
nvm use 10.12  
## archlinux 安装yarn
kyron@ThinkPad:~$ sudo pacman -S npm  
[sudo] password for kyron:  
resolving dependencies...  
looking for conflicting packages...  
  
Packages (6) c-ares-1.15.0-1  libuv-1.29.0-1  node-gyp-4.0.0-1  nodejs-11.15.0-1  
             semver-6.0.0-1  npm-6.9.0-1  
  
Total Download Size:    9.85 MiB  
Total Installed Size:  45.25 MiB  
  
  
配置  
PATH="$HOME/.node_modules/bin:$PATH"  
```
export npm_config_prefix=~/.node_module
```
  
## archlinux安装yarn
kyron@ThinkPak:~$ sudo pacman -S yarn  
resolving dependencies...  
looking for conflicting packages...  
  
Packages (1) yarn-1.16.0-1  
  
Total Download Size:   0.80 MiB  
Total Installed Size:  4.69 MiB  
  
### yarn管理
全局安装  
yarn global add gitbook-cli  
查看安装后目录  
which gitbook  
相关链接  
/home/kyron/.node_modules/bin/gitbook  
/home/kyron/.node_modules/bin/gitbook -> ../../.config/yarn/global/node_modules/.bin/gitbook*  
.config/yarn/global/node_modules/.bin/gitbook -> ../gitbook-cli/bin/gitbook.js*  
  
配置  
  
PATH="$HOME/.node_modules/bin:$PATH"  
```
export PATH=${PATH}:$HOME/.config/yarn/global/node_modules/.bin
```
  
  
  
## 国内源npm yarn
```
国内优秀npm镜像推荐及使用 https://segmentfault.com/a/1190000002576600

npm，yarn如何查看源和换源

npm config get registry  // 查看npm当前镜像源

npm config set registry https://registry.npm.taobao.org/  // 设置npm镜像源为淘宝镜像

yarn config get registry  // 查看yarn当前镜像源

yarn config set registry https://registry.npm.taobao.org/  // 设置yarn镜像源为淘宝镜像
镜像源地址部分如下：

npm --- https://registry.npmjs.org/

cnpm --- https://r.cnpmjs.org/

taobao --- https://registry.npm.taobao.org/

nj --- https://registry.nodejitsu.com/

rednpm --- https://registry.mirror.cqupt.edu.cn/

npmMirror --- https://skimdb.npmjs.com/registry/

deunpm --- http://registry.enpmjs.org/

```
## deepin深度npm安装问题 node-sass 下载不下来
过程：试过npm换淘宝源，cnpm等。。。都不能解决
解决：深度换 阿里的源

vim /etc/apt/sources.list
deb [by-hash=force] http://mirrors.aliyun.com/deepin lion main contrib non-free
#deb [by-hash=force] https://mirrors.tuna.tsinghua.edu.cn/deepin panda main contrib non-free
#deb-src http://mirrors.aliyun.com/deepin lion main contrib non-free

然后
npm install 

npm install cnpm -g --registry=https://registry.npm.taobao.org
cnpm install 

等等操作,竟然好了

## 调试 Unexpected end of JSON input while parsing near '...e","version":"0.1.5",'
```
解决
https://github.com/vuejs-templates/webpack/issues/990

npm cache clean --force
try
if false
delete package.lock.json
try again
if false
npm set registry https://registry.npmjs.org/ don't use taobao mirror
try again
```
## 参考
- https://www.npmjs.com/package/npm-check-updates npm更新package.json依赖的版本
- http://www.fly63.com/article/detial/554 yarn和npm的区别对比_比较npm和yarn 命令行
- [使用 nvm 管理不同版本的 node 与 npm](http://bubkoo.com/2017/01/08/quick-tip-multiple-versions-node-nvm/)
  
