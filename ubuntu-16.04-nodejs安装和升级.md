## ubuntu18只安装稳定版 node npm  
1 下载解压到/opt  
2 创建一个链接  
 sudo ln -s /opt/node-v12.13.0-linux-x64/bin/node /usr/bin/  
 sudo ln -s /opt/node-v12.13.0-linux-x64/bin/npm /usr/bin/  
  
## nvm 版安装  
- [使用 nvm 管理不同版本的 node 与 npm](http://bubkoo.com/2017/01/08/quick-tip-multiple-versions-node-nvm/)
- https://zhaoda.net/2014/03/31/node-n-nvm/
- https://github.com/creationix/nvm
nvm 安装  
curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash  
```
source .bashrc
```
nvm将安装镜像设置成国内镜像  
```
export NVM_NODEJS_ORG_MIRROR=https://npm.taobao.org/mirrors/node
```
  
  
安装稳定版nodejs  
查看官网目前稳定版为8.12.0  
nvm install 8.12  
  
安装最新版nodejs  
nvm install 10.12  
  
查看  
nvm ls  
切换nodejs版本  
nvm use 8.12  
  
每个版本的npm源目录  
 ~/.nvm/versions/node/<version>/lib/node_modules/  
举例  
npm install antd-init -g  
将在上面的目录下安装antd-init, 使全局命令antd-init可用  
  
  
  
npm从特定版本导入到我们将要安装的新版本 Node：  
nvm install v8.12.0 --reinstall-packages-from=10.12  
  
源使用的坑  
安装慢时，可以使用国内镜像  
安装报错时，可以换回官方源  
  
npm  
一、使用淘宝镜像  
1.临时使用  
npm --registry https://registry.npm.taobao.org install express  
  
2.持久使用  
npm config set registry https://registry.npm.taobao.org  
  
3.通过cnpm  
npm install -g cnpm --registry=https://registry.npm.taobao.org  
  
二、使用官方镜像  
npm config set registry https://registry.npmjs.org/  
  
三、查看npm源地址  
npm config get registry  
  
  
yarn 国内镜像  
yarn config set registry https://registry.npm.taobao.org  
  
参考  
  
- https://www.jianshu.com/p/f311a3a155ff npm换源
