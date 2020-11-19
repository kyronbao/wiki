## 参考  
- https://docs.docker.com/ 官方文档
- https://hub.docker.com/ docker源 搜索mysql nginx php分别有官方维护的包
- https://docs.docker.com/compose/compose-file/ Dockerfile的命令
- https://cr.console.aliyun.com/cn-shenzhen/instances/mirrors 阿里云镜像加速器地址
- http://guide.daocloud.io/dcs/php-docker-9153871.html doocloud文档 包含怎么持续发布
- https://yeasy.gitbooks.io/docker_practice/content/ 中文文档
- https://github.com/fanly/laraveldocker 国内源的设置
  
参考例子  
- https://cloud.tencent.com/developer/ask/36031 在docker-compose中使用主机IP
- https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose
  不是基于alpine安装，提供了配置文件的同步方法，user添加方法  
- https://github.com/guillaumebriday/laravel-blog docker-compose安装php7.3,使用方法详细， 配置文件整理在了目录里，较整齐
- https://segmentfault.com/a/1190000011876870 如何构建一个php7-alpine的docker镜像
- https://qiita.com/ProjectEuropa/items/81368cae59f786cf6f0f 配置了ssl
- https://segmentfault.com/a/1190000015491751 docker-compose 2
  
## docker安装
### archlinux安装docker
安装  
```
sudo pacman -S docker
```
启动  
```
sudo systemctl start docker
```
查看  
```
sudo docker info
```
### ubuntu安装最新版docker
1. 卸载旧版本  
```
sudo apt-get remove docker docker-engine docker.io
```
2. 安装最新版本的 Docker  
最新版本的 Docker 分两个版本，docker-ce(Community Edition)和docker-ee(Enterprise Edition)。CE版本是免费的，如果我们学习或者一般应用，CE足够。我们安装社区版：  
  
由于docker安装需要使用https，所以需要使 apt 支持 https 的拉取方式。  
  
2.1 安装 https 相关的软件包  
```
sudo apt-get update # 先更新一下软件源库信息
```
  
```
sudo apt-get install \
```
    apt-transport-https \  
    ca-certificates \  
    curl \  
    software-properties-common  
2.2 设置apt仓库地址  
鉴于国内网络问题，强烈建议使用国内地址  
  
添加 Docker 官方apt仓库（使用国外源）  
执行该命令时，如遇到长时间没有响应说明网络连接不到docker网站，需要使用国内的  
  
# 添加 Docker 官方的 GPG 密钥（为了确认所下载软件包的合法性，需要添加软件源的 GPG 密钥）  
```
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
```
  
# 设置稳定版本的apt仓库地址  
```
sudo add-apt-repository \
```
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \  
   $(lsb_release -cs) \  
   stable"  
添加 阿里云 的apt仓库（使用国内源）  
  
```
curl -fsSL https://mirrors.aliyun.com/docker-ce/linux/ubuntu/gpg | sudo apt-key add -
```
  
```
sudo add-apt-repository \
```
     "deb [arch=amd64] https://mirrors.aliyun.com/docker-ce/linux/ubuntu \  
     $(lsb_release -cs) \  
     stable"  
2.3 安装 Docker 软件  
```
sudo apt-get update
```
  
```
sudo apt-get install docker-ce # 安装最新版的docker
```
如果要安装指定版本的docker，则使用下面的命令：  
  
```
apt-cache policy docker-ce # 查看可供安装的所有docker版本
sudo apt-get install docker-ce=18.03.0~ce-0~ubuntu # 安装指定版本的docker
```
``  
### 2.4 检查docker是否安装成功  
```
docker --version # 查看安装的docker版本
```
  
  
2. 配置镜像加速器（参考阿里云页面）  
针对Docker客户端版本大于 1.10.0 的用户  
  
您可以通过修改daemon配置文件/etc/docker/daemon.json来使用加速器  
```
sudo mkdir -p /etc/docker
sudo tee /etc/docker/daemon.json <<-'EOF'
```
{  
  "registry-mirrors": ["https://fxr51t6l.mirror.aliyuncs.com"]  
}  
EOF  
```
sudo systemctl daemon-reload
sudo systemctl restart docker
```
  
二.验证docker是否正确被安装  
运行hello world镜像（直接运行即可　自动从服务器上拉取demo镜像）  
  
```
sudo docker run hello-world
```
正确结果如下：  
  
    ....  
    Hello from Docker!  
    ....  
---------------------
  
  
四.添加到用户组（可选项）  
添加到用户组（so easy）  
  
```
sudo groupadd docker
sudo usermod -aG docker $USER
```
  
注销系统重新进入系统，就可以直接使用docker开头了。  
```
sudo service docker restart
```
  
### ubuntu阿里云脚本安装docker
curl -sSL http://acs-public-mirror.oss-cn-hangzhou.aliyuncs.com/docker-engine/internet | sh -  
添加APT镜像  
检查版本是否改动过 sudo apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D  
  
```
echo "deb https://apt.dockerproject.org/repo ubuntu-xenial main" | sudo tee /etc/apt/sources.list.d/docker.list
```
  
```
sudo apt-get update
```
  
安装 Docker  
```
sudo apt-get install docker-engine
```
  
启动 Docker 引擎  
```
sudo systemctl enable docker
sudo systemctl start docker
```
  
将当前用户加入 docker 组：  
```
sudo usermod -aG docker $USER
```
## docker-compose安装
安装  
```
sudo curl -L "https://github.com/docker/compose/releases/download/1.23.1/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
```
  
curl 巨慢 所以  
先科学上网  
先 wget 下载后 在移到相应目录  
  
```
sudo chmod +x /usr/local/bin/docker-compose
```
  
- [Dockerise your PHP application with Nginx and PHP7-FPM](http://geekyplatypus.com/dockerise-your-php-application-with-nginx-and-php7-fpm/)
## docker管理
显示所有容器 docker ps -a  
显示运行容器 docker ps  
显示镜像     docker images  
  
删除容器 docker rm dc1...  
删除镜像 docker rmi dci  
  
构建镜像  
```
docker build -t nginx:v3 .
```
  
```
docker-compose buid
```
docker-comose --no-cache build  
  
停止所有容器  
```
sudo docker kill $(sudo docker ps -q)
```
删除所有停止容器  
```
sudo docker rm $(sudo docker ps -a -q)
```
删除所有images  
```
sudo docker rmi $(sudo docker images -q)
```
强制关闭并删除正在运行的程序  
```
docker rm -f $(docker ps -q)
```
删除临时镜像(可以通过docker images -a查看)  
```
sudo docker rmi $(sudo docker images -f "dangling=true" -q)
```
大招（删除所有没使用的东西）  
```
docker system prune -a
```
  
从容器复制文件  
```
docker cp db_blog:/etc/mysql/ ./
```
  
## 使用Dockerfile定制镜像
```
mkdir nginxmy
cd nginxmy
vim Dockfile
```
FROM nginx  
RUN echo '<h1>Hello, Docker!</h1>' > /usr/share/nginx/html/index.html  
  
一般来说，应该会将 Dockerfile 置于一个空目录下，或者项目根目录下。  
如果该目录下没有所需文件，那么应该把所需文件复制一份过来。如果目录下有些东西确实不希望构建时传给 Docker 引擎，那么可以用 .gitignore 一样的语法写一个 .dockerignore，该文件是用于剔除不需要作为上下文传递给 Docker 引擎的。  
  
那么为什么会有人误以为 . 是指定 Dockerfile 所在目录呢？  
这是因为在默认情况下，如果不额外指定 Dockerfile 的话，会将上下文目录下的名为 Dockerfile 的文件作为 Dockerfile。  
这只是默认行为，实际上 Dockerfile 的文件名并不要求必须为 Dockerfile，而且并不要求必须位于上下文目录中，比如可以用 -f ../Dockerfile.php 参数指定某个文件作为 Dockerfile。  
  
当然，一般大家习惯性的会使用默认的文件名 Dockerfile，以及会将其置于镜像构建上下文目录中。  
  
## 定制自己的docker
  
  
配置docker国内镜像  
  
安装mysql  
  
进入mysql容器  
```
docker exec -it database bash
```
导出数据  
```
docker exec database sh -c 'exec mysqldump --all-databases -uroot -p"$MYSQL_ROOT_PASSWORD"' > ./all-databases.sql
```
  
安装php-fpm  
  
配置php  
php默认在/usr/local/etc/php/conf.d中扫描加载.ini文件  
（安装成功后，通过phpinfo() 搜索php.ini得知：Scan this dir for additional .ini files	/usr/local/etc/php/conf.d）  
  
安装依赖  
```
cp .env.example .env
docker-compose run --rm --no-deps app composer install
docker-compose run --rm --no-deps app php artisan key:generate
docker-compose run --rm --no-deps app php artisan storage:link
docker-compose up -d
```
  
--no-deps指启动当前服务时不启动其他依赖的服务
  
现在可以在 http://localhost:8000 检查安装已经成功  
  
导入测试数据  
注意.env的DB_HOST应该设为database (docker-compose的数据库服务)  
```
docker-compose run --rm app php artisan migrate --seed
```
  
  
上线发布  
```
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```
  
## larvel-docker-compose README.md
为了方便部署Laravel，使用docker-compose配置环境。上线时，只需要几行命令，就可以很快部署好环境。  
## 项目说明：  
- 各种源使用国内镜像
- 使用alpine为linux基础
- laravel环境PHP依赖最小化安装
- 各种依赖程序版本使用最新的稳定版
## 相关版本  
- docker compose file version 3
- PHP 7.3
- MySQL 5.7
- Nginx stable
  
## 安装环境  
```
docker 1.13.0+
docker-compose 建议使用最新版
```
  
## 使用  
新建laravel测试项目  
```
git clone git@github.com:laravel/laravel.git laravel-demo
```
复制.docker目录和docker-compose.yml到项目根目录  
```
git clone git@github.com:kyronbao/laravel-docker-compose.git
cp -r laravel-docker-compose/.docker laravel-demo \
&& cp laravel-docker-compose/docker-compose.yml laravel-demo \
&& cd laravel-demo
```
安装依赖  
```
cp .env.example .env
```
配置下列项  
DB_CONNECTION=mysql  
DB_HOST=db  
DB_PORT=3306  
DB_DATABASE=laravel-docker-compose  
DB_USERNAME=root  
DB_PASSWORD=secret  
  
```
docker-compose run --rm --no-deps app composer install -vvv
docker-compose run --rm --no-deps app php artisan key:generate
```
--no-deps指启动当前服务时不启动其他依赖的服务
  
修改storage权限  
  
## 启动docker-compose  
提示：如果主机端口占用8000，3306，需先停止  
```
docker-compose up -d
```
  
现在，可以在浏览器输入 http://localhost:8000 看到laravel的界面了  
  
## 连接不了数据库
调试方法  
1 重新登录一遍试试  
## mysql 端口冲突问题
  
最后调试解决方法如下  
  
blog项目:  
.env  
port=3306  
  
docker-compose.yml  
  db:  
    ports:  
      - "3306:3306"
  
lservices项目:  
.env  
port=3306  
  
docker-compose.yml  
  db:  
    ports:  
      - "3307:3306"
  
命令  
```
docker-compose up --force-recreate
```
--force-recreate 即使镜像和配置没改变，也重新创建镜像
```
docker-compose up -V
```
-V 重新创建匿名volumes，而不是从上次的容器中取数据
  通过测试不会删除以前的数据  
## practise install laravel （老版实践）
  
- [Laravel 5.6 in Docker with PHP 7.2 , NGINX 1.10 and MySQL 5.7](https://medium.com/@markpadilla/laravel-5-6-in-docker-with-php-7-2-nginx-1-10-and-mysql-5-7-cdb6c054379c)
- [Laravel + Docker Part 1 — setup for Development](https://medium.com/@shakyShane/laravel-docker-part-1-setup-for-development-e3daaefaf3c) 老版教程
  
复制4个文件到项目目录后  
```
docker-compose up
cp .env.example .env
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan optimize
docker-compose exec app php artisan migrate --seed
docker-compose exec app php artisan make:controller MyController
```
  
  
  
  
  
