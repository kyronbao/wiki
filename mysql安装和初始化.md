## win10安装mysql5.7
下载地址
https://downloads.mysql.com/archives/installer/
选５.7 .36
Microsoft Windows
下载


## 源码安装mysql5.7(ubuntu)


wget https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-boost-5.7.37.tar.gz

wget https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-5.7.37.tar.gz

把以上两个包解压到一个文件夹中

/media/qianyong/_dde_data

cmake \
     -DCMAKE_INSTALL_PREFIX=/media/qianyong/_dde_data/mysql \
     -DMYSQL_DATADIR=/media/qianyong/_dde_data/mysql/data \
     -DMYSQL_UNIX_ADDR=/tmp/mysql.sock \
     -DDEFAULT_CHARSET=utf8 \
     -DDEFAULT_COLLATION=utf8_general_ci \
     -DEXTRA_CHARSETS=gbk,gb2312,utf8,ascii \
     -DENABLED_LOCAL_INFILE=ON \
     -DWITH_INNOBASE_STORAGE_ENGINE=1 \
     -DWITH_FEDERATED_STORAGE_ENGINE=1 \
     -DWITH_BLACKHOLE_STORAGE_ENGINE=1 \
     -DWITHOUT_EXAMPLE_STORAGE_ENGINE=1 \
     -DWITHOUT_PARTITION_STORAGE_ENGINE=1 \
     -DWITH_FAST_MUTEXES=1 \
     -DWITH_ZLIB=bundled \
     -DENABLED_LOCAL_INFILE=1 \
     -DWITH_READLINE=1 \
     -DWITH_EMBEDDED_SERVER=1 \
     -DWITH_DEBUG=0 \
	 -DDOWNLOAD_BOOST=1 \
     -DWITH_BOOST=./boost
	 
    注意最后一个选项就是指定的解压的boost文件夹

cmake中按提示安装了
sudo apt install libncurses5-dev

``` 中途折腾boost的安装，这三条可以忽略，按上面的配置好 -DWITH_BOOST 参数就可以了
wget https://sourceforge.net/projects/boost/files/boost/1.59.0/boost_1_59_0.tar.gz/download

./bootstrap.sh

./b2 install

```

下一步
sudo make install

参考
- http://blog.itpub.net/30310891/viewspace-2767155/ 基于Linux的MySQL5.7源码编译安装
- https://blog.csdn.net/weixin_39747630/article/details/113203038  -DWITH_BOOST 选项


cd /media/qianyong/_dde_data/mysql


sudo ./bin/mysqld --initialize --user=mysql --basedir=/media/qianyong/_dde_data/mysql --datadir=/media/qianyong/_dde_data/mysql/data
查看初始化随机生成密码
grep "temporary password" /media/qianyong/_dde_data/mysql/data/myerror.log


## 源码安装mysql5.7(archlinux)  
经验总结：  
- 搜索报错信息
- 查看本地的安装文档
- 查看mysql官方文档

首先是花了半个小时来下载了aur源码，  
然后是花了一个小时来安装  

参考安装文件目录下的mysql.install文件
```
 echo ":: You need to initialize the MySQL data directory prior to starting"
  echo "   the service. This can be done with mysqld --initialize command, e.g.:"
  echo "   mysqld --initialize --user=mysql --basedir=/usr --datadir=/var/lib/mysql"
  echo ":: Additionally you should secure your MySQL installation using"
  echo "   mysql_secure_installation command after starting the mysqld service"
```


怎么初始化得到密码?  
首先删掉原来的 /var/lib/mysql/下文件  
运行下面命令后可以看到提示的初始化root密码  
```
sudo mysqld --initialize --user=mysql --basedir=/usr --datadir=/var/lib/mysql
```

怎么修改root密码？  
参考网上的经验，先删除 /etc/mysql 下的文件  
参考官方文档https://dev.mysql.com/doc/refman/5.7/en/starting-server.html ，运行  
```
sudo mysqld_safe --user=mysql
```
这样mysqld在后台运行起来了，现在可以通过如下命令来修改原始密码  
```
mysql_secure_installation
```

配置通过systemd管理mysqld  
可以发现，安装目录里有mysqld.service文件，直接复制粘贴
```
sudo cp mysqld.service /usr/lib/systemd/system/

```
现在就可以通过systemctl来管理mysqld了


## debian9/deepin15.11安装percona-server5.7
参考 https://www.percona.com/doc/percona-server/5.7/installation/apt_repo.html#standalone-deb  
  
```
wget https://repo.percona.com/apt/percona-release_latest.stretch_all.deb
```
```
Supported Releases:

Debian:
8.0 (jessie)
9.0 (stretch)
10.0 (buster)
Ubuntu:
16.04LTS (xenial)
18.04 (bionic)
Supported Platforms:

x86
x86_64 (also known as amd64)

Installing Percona Server from Percona apt repository
Fetch the repository packages from Percona web:

wget https://repo.percona.com/apt/percona-release_latest.$(lsb_release -sc)_all.deb
备注这里使用 wget https://repo.percona.com/apt/percona-release_latest.stretch_all.deb 来下载
Install the downloaded package with dpkg. To do that, run the following commands as root or with sudo:

sudo dpkg -i percona-release_latest.$(lsb_release -sc)_all.deb
Once you install this package the Percona repositories should be added. You can check the repository setup in the /etc/apt/sources.list.d/percona-release.list file.

Remember to update the local cache:

sudo apt-get update
After that you can install the server package:

sudo apt-get install percona-server-server-5.7
备注：安装时以此安装依赖，最后使用提示的类似 --fix 的命令可以安装所有的依赖
```
  
## 如何在Ubuntu 18.04上重置MySQL或MariaDB Root密码
 https://cloud.tencent.com/developer/article/1359782  
## archlinux安装mariadb
pacman -S mariadb  
  
首先启动mariadb服务，不然执行下面命令时提示Can't connect to local MySQL server through socket '/run/mysqld/mysqld.sock' (2)  
  
```
sudo systemctl start mariadb
```

```
mysql_install_db --user=mysql --basedir=/usr --datadir=/var/lib/mysql  
```  
  
```
Installing MariaDB/MySQL system tables in '/var/lib/mysql' ...
OK

To start mysqld at boot time you have to copy
support-files/mysql.server to the right place for your system


PLEASE REMEMBER TO SET A PASSWORD FOR THE MariaDB root USER !
To do so, start the server, then issue the following commands:

'/usr/bin/mysqladmin' -u root password 'new-password'
'/usr/bin/mysqladmin' -u root -h ThinkPak password 'new-password'

Alternatively you can run:
'/usr/bin/mysql_secure_installation'

which will also give you the option of removing the test
databases and anonymous user created by default.  This is
strongly recommended for production servers.

See the MariaDB Knowledgebase at http://mariadb.com/kb or the
MySQL manual for more instructions.

You can start the MariaDB daemon with:
cd '/usr' ; /usr/bin/mysqld_safe --datadir='/var/lib/mysql'

You can test the MariaDB daemon with mysql-test-run.pl
cd '/usr/mysql-test' ; perl mysql-test-run.pl

Please report any problems at http://mariadb.org/jira

The latest information about MariaDB is available at http://mariadb.org/.
You can find additional information about the MySQL part at:
http://dev.mysql.com
Consider joining MariaDB's strong and vibrant community:
https://mariadb.org/get-involved/


```
  
## Ubuntu 16.04安装mysql5.7
```
sudo apt-cache show mysql-server
show
Source: mysql-5.7
	
sudo apt install mysql-server
show
The following NEW packages will be installed:
  libaio1 libevent-core-2.0-5 libhtml-template-perl mysql-client-5.7
  mysql-client-core-5.7 mysql-common mysql-server mysql-server-5.7
  mysql-server-core-5.7

mysql_secure_installation
询问以下内容：
是否安装保证密码复杂度的插件、
是否修改密码、
是否允许root远程登录、
是否移除匿名用户
是否移除test数据库

systemctl status mysql.service
sudo sysv-rc-conf --list | grep mysql
```
  
mysqladmin工具介绍  
mysqladmin tool, which is a client that lets you run administrative commands.  
```
mysqladmin --help
查看版本等信息
mysqladmin  -uroot -p version
修改密码
mysql -uroot -p password 123456
```
  
一份基础的mysql教程 https://www.digitalocean.com/community/tutorials/a-basic-mysql-tutorial  
  
参考 https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-16-04  
  
*修改编码防止navicat等乱码问题*  
查看mysql编码  
```
mysql -uroot -p

mysql> show variables like 'character_set_%';
+--------------------------+----------------------------+
| Variable_name            | Value                      |
+--------------------------+----------------------------+
| character_set_client     | utf8                       |
| character_set_connection | utf8                       |
| character_set_database   | latin1                     |
| character_set_filesystem | binary                     |
| character_set_results    | utf8                       |
| character_set_server     | latin1                     |
| character_set_system     | utf8                       |
| character_sets_dir       | /usr/share/mysql/charsets/ |
+--------------------------+----------------------------+
8 rows in set (0.01 sec)

mysql> show variables like 'collation_%';
+----------------------+-------------------+
| Variable_name        | Value             |
+----------------------+-------------------+
| collation_connection | utf8_general_ci   |
| collation_database   | latin1_swedish_ci |
| collation_server     | latin1_swedish_ci |
+----------------------+-------------------+
3 rows in set (0.00 sec)
```
  
修改配置文件  
```
sudo vim /etc/mysql/mysql.conf.d/mysqld.cnf
在[mysqld]段落添加
character-set-server=utf8
collation-server=utf8_general_ci

sudo systemctl restart mysql.service
```
  
修改完查看mysql编码  
```
mysql> show variables like 'character_set_%';
+--------------------------+----------------------------+
| Variable_name            | Value                      |
+--------------------------+----------------------------+
| character_set_client     | utf8                       |
| character_set_connection | utf8                       |
| character_set_database   | utf8                       |
| character_set_filesystem | binary                     |
| character_set_results    | utf8                       |
| character_set_server     | utf8                       |
| character_set_system     | utf8                       |
| character_sets_dir       | /usr/share/mysql/charsets/ |
+--------------------------+----------------------------+
8 rows in set (0.00 sec)

mysql> show variables like 'collation_%';
+----------------------+-----------------+
| Variable_name        | Value           |
+----------------------+-----------------+
| collation_connection | utf8_general_ci |
| collation_database   | utf8_general_ci |
| collation_server     | utf8_general_ci |
+----------------------+-----------------+
3 rows in set (0.00 sec)
```
  
安装mysql-devel供其他程序调用mysql,如sphinx  
```
sudo apt-get install libmysqlclient-dev libmysqld-dev
```
  
 <2018-01-26 五>  
  
参考 https://kelvin.mbioq.com/2016/12/03/install-premium-navicat-on-ubuntu1604.html#ci_title4  
  
  
  
  

## 创建数据库，导入导出，设置Character Set and Collation  
### 配置
[mysqld]
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci
 
systemctl restart mysql.service

### 查看编码
查看数据库
SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME
FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'db_name';

数据库　For Schemas (or Databases - they are synonyms):

SELECT default_character_set_name FROM information_schema.SCHEMATA 
WHERE schema_name = "schemaname";

表For Tables:

SELECT CCSA.character_set_name FROM information_schema.`TABLES` T,
       information_schema.`COLLATION_CHARACTER_SET_APPLICABILITY` CCSA
WHERE CCSA.collation_name = T.table_collation
  AND T.table_schema = "schemaname" AND T.table_name = "tablename";

列For Columns:

SELECT character_set_name FROM information_schema.`COLUMNS` 
WHERE table_schema = "schemaname"　AND table_name = "tablename"　AND column_name = "columnname";
### 创建数据库和修改编码utf8mb4
CREATE DATABASE mydatabase CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;  


CREATE DATABASE mydatabase;

DROP DATABASE mydatabase;

ALTER DATABASE DBNAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

公司
CREATE DATABASE IF NOT EXISTS db_wms DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_general_ci;
### 导入导出

导入  
mysql -uroot -p laravel < laravel.sql  
 

mysql> CREATE DATABASE IF NOT EXISTS db1;
mysql> USE db1;
mysql> source dump.sql
导出  
导出数据库  
mysqldump --set-gtid-purged=OFF -h127.0.0.1 -uroot -P3306 -p laravel >
laravel.sql  
导出时排除某些表
mysqldump --databases mytest --ignore-table=mytest.ti_o_sms --ignore-table=mytest.ti_o_smsbak > mytest02.sql
导出数据库的表  
mysqldump -uroot -p laravel users > laravel_users.sql  

### 执行sql文件
进入mysql控制台
source script.sql
