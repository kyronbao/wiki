  
archlinux官方源中由于协议原因移除了mongodb  
  
所以通过aur安装，感觉半个小时还没安装完，太慢了（编译的文件夹有4G多），所以暂停从aur安装  
  
最后参考这里安装二进制包  
https://www.docs4dev.com/docs/zh/mongodb/v3.6/reference/tutorial-install-mongodb-on-linux.html  
  
下载  
curl -O https://fastdl.mongodb.org/linux/mongodb-linux-x86_64-3.6.12.tgz  
解压后移到/usr/local  
设置PATH变量  
  
创建数据默认目录  
```
mkdir -p /data/db
```
暂时给所有权限  
```
sudo chmo 777 /data/db
```
  
测试  
mongo --verion  
运行  
mongod  
  
开始使用MongoDB  
