  
安装依赖  
```
sudo apt-get update
sudo apt-get install build-essential tcl
```
  
下载安装  
```
cd /tmp
curl -O http://download.redis.io/redis-stable.tar.gz
tar xzvf redis-stable.tar.gz
cd redis-stable

make
# make test
sudo make install
```
  
修改配置文件  
```
sudo mkdir /etc/redis

sudo cp ./redis.conf /etc/redis

sudo /etc/redis/redis.conf
```
修改以下内容  
```
# 因为我们的系统是systemd init system，把默认no改为systemd
supervised systemd

# redis数据库存放位置，需要设置redis用户有权限管理，默认为 ./
dir /var/lib/redis
```
  
创建Redis systemd Unit文件  
```
sudo vim /etc/systemd/system/redis.service
# 编辑内容如下
[Unit]
Description=Redis In-Memory Data Store
After=network.target

[Service]
User=redis
Group=redis
ExecStart=/usr/local/bin/redis-server /etc/redis/redis.conf
ExecStop=/usr/local/bin/redis-cli shutdown
Restart=always

[Install]
WantedBy=multi-user.target
```
注：  
User和Group设置了启动redis的临时用户和组；  
Restart=always，当redis可能挂掉时恢复；  
WantedBy=multi-user.target，系统启动时启动。  
  
Create the Redis User, Group and Directories  
```
sudo adduser --system --group --no-create-home redis
sudo mkdir /var/lib/redis
sudo chown redis:redis /var/lib/redis
sudo chmod 770 /var/lib/redis
```
  
开启redis  
```
sudo systemctl start redis

sudo systemctl status redis
```
  
测试  
```
redis-cli

ping
# You should see:
PONG

set test "It's working!"
# Output
OK

get test
#Output
"It's working!"

exit

sudo systemctl restart redis

redis-cli
get test
# The value of your key should still be accessible:

"It's working!"

exit
```
  
设置开机重启  
```
sudo systemctl enable redis
```
  
- https://www.digitalocean.com/community/tutorials/how-to-install-and-configure-redis-on-ubuntu-16-04
  
扩展  
redis安全配置  
