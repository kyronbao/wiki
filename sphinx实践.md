## ubuntu 16.04 sphinx2 scws编译安装实现增量索引和phpapi接口查询 <2018-01-30 二>
sphinx安装  
```
wget -c http://sphinxsearch.com/files/sphinx-2.2.11-release.tar.gz
tar zxvf sphinx-2.2.11-release.tar.gz
cd sphinx-2.2.11-release/
./configure --prefix=/opt/sphinx --with-mysql  # 报错时参考下一段
make
sudo make install
```
  
编译sphinx时报错ERROR: cannot find MySQL include files.如下  
```
ERROR: cannot find MySQL include files.

Check that you do have MySQL include files installed.
The package name is typically 'mysql-devel'.

If include files are installed on your system, but you are still getting
this message, you should do one of the following:

1) either specify includes location explicitly, using --with-mysql-includes;
2) or specify MySQL installation root location explicitly, using --with-mysql;
3) or make sure that the path to 'mysql_config' program is listed in
   your PATH environment variable.

To disable MySQL support, use --without-mysql option.
```
因为sphinx是c写的，调用mysql时需使用devel组件  
参考 https://raspberrypi.stackexchange.com/questions/32748/where-can-i-find-mysql-devel  
安装'xxx-dev'后解决  
```
sudo apt-get install libmysqlclient-dev libmysqld-dev
```
  
libsphinxclient安装  
```
cd api/libsphinxclient
./configure --prefix=/opt/sphinx/libsphinxclient
make && make install

成功后提示

Libraries have been installed in:
   /opt/sphinx/libsphinxclient/lib
```
  
  
sphinx php扩展安装  
下载地址 http://pecl.php.net/package/sphinx  
参考 http://php.net/manual/en/sphinx.installation.php ./configure --with-sphinx=$PREFIX, where $PREFIX is installation prefix of libsphinxclient.  
sphinx PHP扩展目前最新版本为1.3.3  
安装过程  
注意使用php5.6版本  
```
wget -c http://pecl.php.net/get/sphinx-1.3.3.tgz
tar zxvf sphinx-1.3.3.tgz
cd sphinx-1.3.3

/usr/bin/phpize5.6
./configure --with-sphinx=/opt/sphinx/libsphinxclient/ --with-php-config=/usr/bin/php-config5.6
make
sudo make install
# 成功后提示
Installing shared extensions:     /usr/lib/php/20131226/

# 配置php.ini
sudo vim /etc/php/5.6/apache2/php.ini
[Sphinx]
extension = sphinx.so
```
切换apache2下php版本  
```
sudo a2dismod php7.0
sudo a2enmod php5.6
sudo service apache2 restart
```
phpinfo()测试，php扩展sphinx安装成功  
  
sphinx扩展安装报错，安装失败，原因为扩展版本不匹配，记录如下  
```
phpize
./configure --with-sphinx=/opt/sphinx/libsphinxclient/ --with-php-config=/usr/bin/php-config7.0  报错
Makefile:194: recipe for target 'sphinx.lo' failed
make: *** [sphinx.lo] Error 1
解决
仔细查看参考的安装教程，推测可能事php版本的原因，sphinx扩展包最新版1.3.3为2015年的版本，而本机使用PHP为ubuntu16.04.03的默认PHP版php7.0
```
php5.6安装后，解决了sphinx扩展报错问题  
```
ll /usr/bin/php* 查得目前只有一个php版本

lrwxrwxrwx 1 root root      21 1月  29 15:05 /usr/bin/php -> /etc/alternatives/php*
-rwxr-xr-x 1 root root 4434992 12月  1 04:26 /usr/bin/php7.0*
lrwxrwxrwx 1 root root      28 1月  29 17:31 /usr/bin/php-config -> /etc/alternatives/php-config*
-rwxr-xr-x 1 root root    4133 12月  1 04:25 /usr/bin/php-config7.0*
lrwxrwxrwx 1 root root      24 1月  29 17:31 /usr/bin/phpize -> /etc/alternatives/phpize*
-rwxr-xr-x 1 root root    4687 12月  1 04:25 /usr/bin/phpize7.0*

# 通过php -v  和 php7.0 -v 也可验证php 为7.0版
sudo apt install php5.6
```
  
  
测试数据创建  
```
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='全文检索测试的数据表' AUTO_INCREMENT=11 ;

INSERT INTO `items` (`id`, `title`, `content`, `created`) VALUES
(1, 'linux mysql集群安装', 'MySQL Cluster 是MySQL 适合于分布式计算环境的高实用、可拓展、高性能、高冗余版本', '2016-09-07 00:00:00'),
(2, 'mysql主从复制', 'mysql主从备份(复制)的基本原理 mysql支持单向、异步复制,复制过程中一个服务器充当主服务器,而一个或多个其它服务器充当从服务器', '2016-09-06 00:00:00'),
(3, 'hello', 'can you search me?', '2016-09-05 00:00:00'),
(4, 'mysql', 'mysql is the best database?', '2016-09-03 00:00:00'),
(5, 'mysql索引', '关于MySQL索引的好处,如果正确合理设计并且使用索引的MySQL是一辆兰博基尼的话,那么没有设计和使用索引的MySQL就是一个人力三轮车', '2016-09-01 00:00:00'),
(6, '集群', '关于MySQL索引的好处,如果正确合理设计并且使用索引的MySQL是一辆兰博基尼的话,那么没有设计和使用索引的MySQL就是一个人力三轮车', '2016-09-03 01:00:00'),
(9, '复制原理', 'redis也有复制', '2016-09-03 02:00:00'),
(10, 'redis集群', '集群技术是构建高性能网站架构的重要手段，试想在网站承受高并发访问压力的同时，还需要从海量数据中查询出满足条件的数据，并快速响应，我们必然想到的是将数据进行切片，把数据根据某种规则放入多个不同的服务器节点，来降低单节点服务器的压力', '2016-09-03 03:00:00');

CREATE TABLE IF NOT EXISTS `sph_counter` (
  `counter_id` int(11) NOT NULL,
  `max_doc_id` int(11) NOT NULL,
  PRIMARY KEY (`counter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='增量索引标示的计数表';
```
  
Sphinx.conf配置  
注意修改数据源配置信息  
以下采用"Main + Delta" ("主索引"+"增量索引")的索引策略，使用Sphinx自带的一元分词。  
```
sudo vim /opt/sphinx/etc/sphinx.conf
source items {
    type = mysql
    sql_host = localhost
    sql_user = root
    sql_pass = root
    sql_db = sphinx_items

    sql_query_pre = SET NAMES utf8
    sql_query_pre = SET SESSION query_cache_type = OFF
    sql_query_pre = REPLACE INTO sph_counter SELECT 1, MAX(id) FROM items

    sql_query_range = SELECT MIN(id), MAX(id) FROM items \
                            WHERE id<=(SELECT max_doc_id FROM sph_counter WHERE counter_id=1)
    sql_range_step = 1000  # sql_query 每次执行条数
    sql_ranged_throttle = 1000  # sql语句执行间隔ms,降低负载

    sql_query = SELECT id, title, content, created_at, is_deleted FROM items \
                WHERE id<=(SELECT max_doc_id FROM sph_counter WHERE counter_id=1) \
                AND id >= $start AND id <= $end

    sql_attr_timestamp = created_at
    sql_attr_bool = is_deleted
}

source items_delta : items {
    sql_query_pre = SET NAMES utf8

    sql_query_range = SELECT MIN(id), MAX(id) FROM items \
                      WHERE id > (SELECT max_doc_id FROM sph_counter WHERE counter_id=1)

    sql_query = SELECT id, title, content, created_at, is_deleted FROM items \
                WHERE id>( SELECT max_doc_id FROM sph_counter WHERE counter_id=1 ) \
                AND id >= $start AND id <= $end

   sql_query_killlist = SELECT id FROM items WHERE is_deleted=1 \
                       AND id<=( SELECT max_doc_id FROM sph_counter WHERE counter_id=1 )

    sql_query_post_index = set @max_doc_id :=(SELECT max_doc_id FROM sph_counter WHERE counter_id=1)
    sql_query_post_index = REPLACE INTO sph_counter SELECT 2, IF($maxid, $maxid, @max_doc_id)
}
#主索引
index items {
    source = items
    path = /opt/sphinx/var/data/items
    docinfo = extern
    morphology = none
    min_word_len = 1
    min_prefix_len = 0
    html_strip = 1
    html_remove_elements = style, script
    ngram_len = 1
    ngram_chars = U+3000..U+2FA1F
    charset_table = 0..9, A..Z->a..z, _, a..z, U+410..U+42F->U+430..U+44F, U+430..U+44F
    preopen = 1
    min_infix_len = 1
}

#增量索引
index items_delta : items {
    source = items_delta
    path = /opt/sphinx/var/data/items-delta
}

#索引集合
index master {
    type = distributed
    local = items
    local = items_delta
}

indexer {
    mem_limit = 256M
}

searchd {
    listen                   = 9312
    #listen                   = 9306:mysql41 #Used for SphinxQL
    log                      = /opt/sphinx/var/log/searchd.log
    query_log                = /opt/sphinx/var/log/query.log
    attr_flush_period        = 600
    mva_updates_pool         = 16M
    read_timeout             = 5
    max_children             = 0
    dist_threads             = 2
    pid_file                 = /opt/sphinx/var/pid/searchd.pid
    seamless_rotate          = 1
    preopen_indexes          = 1
    unlink_old               = 1
    workers                  = threads # for RT to work
    binlog_path              = /opt/sphinx/var/log

}
```
注意：脚本中sql语句\后不能有空格  
版本2.07升级到2.2.11需要修改内容  
```
启动searchd时报错

WARNING: key 'charset_type' was permanently removed from Sphinx configuration. Refer to documentation for details.
ERROR: unknown key name 'compat_sphinxql_magics' in /opt/sphinx/etc/sphinx.conf line 75 col 27.
FATAL: failed to parse config file '/opt/sphinx/etc/sphinx.conf'

去掉searchd 区域内以下项
    compat_sphinxql_magics   = 0
    max_matches              = 1000
参考文档
compat_sphinxql_magics was removed. Now you can't use an old result format and SphinxQL always looks more like ANSI SQL.
Removed unneeded max_matches key from config file.
去掉index items 区域内如下一行
    charset_type = utf-8
参考文档Removed charset_type and mssql_unicode - we now support only UTF-8 encoding.
```
  
开启索引流程总结  
indexer首次生成索引  
searchd开启  
cron编写和重启  
浏览器查询测试  
等几分钟  
```
ls ./var/log查看日志
```
  
indexer索引首次创建  
```
cd /opt/sphinx
sudo ./bin/indexer -c ./etc/sphinx.conf --all
```
成功后提示  
```
Sphinx 2.2.11-id64-release (95ae9a6)
Copyright (c) 2001-2016, Andrew Aksyonoff
Copyright (c) 2008-2016, Sphinx Technologies Inc (http://sphinxsearch.com)

using config file '/opt/sphinx/etc/sphinx.conf'...
indexing index 'items'...
collected 12 docs, 0.0 MB
sorted 0.0 Mhits, 100.0% done
total 12 docs, 1207 bytes
total 1.399 sec, 862 bytes/sec, 8.57 docs/sec
indexing index 'items_delta'...
collected 0 docs, 0.0 MB
total 0 docs, 0 bytes
total 1.013 sec, 0 bytes/sec, 0.00 docs/sec
skipping non-plain index 'master'...
total 5 reads, 0.000 sec, 0.8 kb/call avg, 0.0 msec/call avg
total 19 writes, 0.000 sec, 0.4 kb/call avg, 0.0 msec/call avg
```
查看索引  
```
ls ./var/data
```
  
searchd开启和管理  
```
#创建pid目录
sudo mkdir ./var/pid

# 启动searchd
sudo ./bin/searchd -c ./etc/sphinx.conf

# 启动报错bind() failed on 0.0.0.0, retrying.时查看是否已有searchd程序占用端口

# 查看进程
ps -aux | grep searchd

# 停止Searchd:
sudo ./bin/searchd -c ./etc/sphinx.conf --stop

# 查看Searchd状态:
sudo ./bin/searchd -c ./etc/sphinx.conf --status
```
  
searchd开机启动设置  
```
sudo vim /etc/rc.local
# 添加以下内容
/opt/sphinx/bin/searchd -c /opt/sphinx/etc/sphinx.conf
```
  
  
索引更新及使用说明  
"增量索引"每N分钟更新一次.通常在每天晚上低负载的时进行一次索引合并,同时重新建立"增量索引"。  
当然"主索引"数据不多的话，也可以直接重新建立"主索引"。API搜索的时，同时使用"主索引"和"增量索引"，  
这样可以获得准实时的搜索数据.本文的Sphinx配置将"主索引"和"增量索引"放到分布式索引master中,因此只需  
查询分布式索引"master"即可获得全部匹配数据(包括最新数据)。  
  
crontab脚本计划生成索引  
```
cd /opt/sphinx/
sudo mkdir shell && cd shell/
# 增量索引生成脚本
sudo vim delta_index_update.sh

#!/bin/bash
printf "\n\n" >> /opt/sphinx/var/log/update_index.log
date +"%Y-%m-%d %H:%M:%S"  >> /opt/sphinx/var/log/update_index.log
/opt/sphinx/bin/indexer -c /opt/sphinx/etc/sphinx.conf --rotate items_delta  >> /opt/sphinx/var/log/update_index.log

# 合并索引脚本
sudo vim merge_daily_index.sh

#!/bin/bash
indexer=`which /opt/sphinx/bin/indexer`
mysql=`which mysql`

QUERY="use sphinx_items;select max_doc_id from sph_counter where counter_id = 2 limit 1;"
index_counter=$($mysql -h127.0.0.1 -uroot -proot -sN -e "$QUERY")

printf "\n\n" >> /opt/sphinx/var/log/index_merge.log
date +"%Y-%m-%d %H:%M:%S" >> /opt/sphinx/var/log/index_merge.log
#merge "main + delta" indexes
$indexer -c /opt/sphinx/etc/sphinx.conf --rotate --merge items items_delta >> /opt/sphinx/var/log/index_merge.log 2>&1

if [ "$?" -eq 0 ]; then
    ##update sphinx counter # if $index_counter !== ''
    if [ ! -z $index_counter ]; then
        $mysql -h127.0.0.1 -uroot -proot -Dsphinx_items -e "REPLACE INTO sph_counter VALUES (1, '$index_counter')"
    fi

    printf "\n\n" >> /opt/sphinx/var/log/rebuild_delta_index.log
    date +"%Y-%m-%d %H:%M:%S" >> /opt/sphinx/var/log/rebuild_delta_index.log
    ##rebuild delta index to avoid confusion with main index
    $indexer -c /opt/sphinx/etc/sphinx.conf --rotate items_delta >> /opt/sphinx/var/log/rebuild_delta_index.log 2>&1
fi




# 添加可执行权限
sudo chmod +x ./
```
  
增量索引流程描述  
```

# 当共有3条数据，有2条符合搜索条件
- 首次生成主索引和增量索引
sudo ./bin/indexer -c ./etc/sphinx.conf --all

source items 中执行
sql_query_pre = REPLACE INTO sph_counter SELECT 1, MAX(id) FROM items
source items_delta : items 中执行
sql_query_post_index = REPLACE INTO sph_counter SELECT 2, IF($maxid, $maxid, @max_doc_id)

sph_counter表如下
| counter_id | max_doc_id |
| 1          | 3          |
| 2          | 3          |

phpapi接口中可以查到2条数据

# 增加一条数据后
- 生成增量索引(脚本中约每分钟更新一次)
sudo /opt/sphinx/bin/indexer -c /opt/sphinx/etc/sphinx.conf --rotate items_delta
or
sudo ./shell/delta_index_update.sh

source items_delta : items 中执行
sql_query_post_index = REPLACE INTO sph_counter SELECT 2, IF($maxid, $maxid, @max_doc_id)

sph_counter表如下
| counter_id | max_doc_id |
|          1 |          3 |
|          2 |          4 |

接口中可以查询到3条数据
修改 $res = $s->query($words, 0, 10, 'master');
可验证其中items索引可查询2条数据，items_delta索引可查询1条数据

上一流程可以测试多次（如再次数据库添加2条数据，然后生成增量索引）
sph_counter表如下
| counter_id | max_doc_id |
|          1 |          3 |
|          2 |          6 |
接口中可以查询到共5条数据
修改 $res = $s->query($words, 0, 10, 'master');
可验证其中items索引可查询2条数据，items_delta索引可查询3条数据

- 合并索引
sudo ./shell/merge_daily_index.sh
首先将items_delta中索引合并到items索引，通过接口可以验证
master可查到5条数据
items可查到5条数据，delta中可查询到0条数据
说明合并成功


```
  
删除更新索引设计  
```
PHP程序添加$s->SetFilter("is_deleted", array(0));

主索引中暂无被删除的id，直接添加is_deleted=1的数据，
可验证查询不到已删除数据（合并索引后也查询不到已删除数据），可行



sql_query_killlist选项实践

该字段用于删除和更新索引时使用，当有items主索引和items_delta增量索引时，如果items索引已有id=2的含有'mysql'的索引，
当该字段删除或更新后不再包含'mysql',可以配置文件在items_delta中添加
sql_query_killlist = SELECT id FROM items WHERE updated_at>=(SELECET updated_at FROM sph_counter WHERE counter_id=1)
PHP程序中
$res = $s->query($words, 0, 10, 'items items_delta');
这样设置后会在items索引中已有含‘mysql'字样的索引的同时，
再次生成items_delta索引时，不修改items索引，创建一个kill-list过滤列表，过滤掉id=2的数据
注：'items items_delta'中，items_delta在items后面,items_delta会过滤掉前面的索引的id

实践后发现
当items中id=2的含有’mysql'的索引，修改该条删掉'mysql‘字样，更新最新时间updated_at，后
再次生成增量索引，能成功过滤掉id=2的数据

不足：
当id=2再次修改为含有'mysql'字样时，再次生成增量索引后，查不到id=2的数据

总结：
适合于对要求全文索引字段只能删除，不再编辑的场景，可被$s->SetFilter("is_deleted", array(0));的功能代替

```
  
场景：数据量大  
方案：增量索引，每5分钟生成增量索引，每晚合并索引  
总结：不需要每天重生成一次完成索引  
  
场景：  
增量索引时删除更新数据时索引同步的问题  
方案一：  
PHP添加$s->SetFilter("is_deleted", array(0))直接过滤增量索引中的删除的id  
按最新生成的id管理增量索引，主索引删除的id用sql_query_killlist实现  
总结：  
有官方文档实例，按最新的id查询生成增量索引，生成索引逻辑简单，  
删除数据后不能恢复  
不能处理更新数据  
  
  
代码参见本文档  
相关重要片段如下  
PHP片段  
$s->SetFilter("is_deleted", array(0));  
  
$res = $s->query($words, 0, 10, 'items items_delta');  
配置文件片段  
sql_query_killlist = SELECT id FROM items WHERE is_deleted=1 \  
                     AND id<=( SELECT max_doc_id FROM sph_counter WHERE counter_id=1 )  
  
sql_query_killlist注释  
$res = $s->query($words, 0, 10, 'items items_delta');中'items items_delta'后面的items_delta索引会覆盖前面的索引功能  
killlist中的ids优先被查询  
  
验证  
- 增加is_deleted=0的数据，重生成增量索引时， 可以查询，成功
- 增加is_deleted=1的数据，重生成增量索引时， 查询不到，成功
- 修改增量索引中数据is_deleted=1,重生成增量索引时，查询不到，成功
- 修改增量索引中数据is_deleted=0,重生成增量索引时，可行查询，成功
- 以上4中情况生成的索引都在增量索引中，合并时id不会出相重复冲突的情况，查询效果不变，成功
- 修改主索引中数据is_deleted=1,重生成增量索引，查询不到，成功（利用sql_query_killlist功能）
- 修改主索引中数据is_deleted=0,重生成增量索引，查询不到，失败（killlist只能隐藏该id，不能恢复）
  
  
方案二：  
按updated_at更新增量索引，  
如果直接在大数据表中查询最新修改和删除的数据代价较高，可以维护一个表来存放待处理的ids  
  
代码片段如下  
数据库  
```
CREATE TABLE `items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text,
  `is_deleted` tinyint(4) unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='全文检索测试的数据表';

CREATE TABLE `sph_counter` (
  `counter_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`counter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='增量索引标示的计数表';
```
配置文件  
```
source items {
    type = mysql
    sql_host = localhost
    sql_user = root
    sql_pass = root
    sql_db = sphinx_items

    sql_query_pre = SET NAMES utf8
    sql_query_pre = SET SESSION query_cache_type = OFF
    sql_query_pre = REPLACE INTO sph_counter SELECT 1, MAX(updated_at) FROM items

    sql_query = SELECT id, title, content, created_at, is_deleted FROM items \
                WHERE updated_at<=(SELECT updated_at FROM sph_counter WHERE counter_id=1)

    sql_attr_timestamp = created_at
    sql_attr_bool = is_deleted
}

source items_delta : items {
    sql_query_pre = SET NAMES utf8

    sql_query = SELECT id, title, content, created_at, is_deleted FROM items \
                WHERE updated_at>( SELECT updated_at FROM sph_counter WHERE counter_id=1 )

    sql_query_killlist = SELECT id FROM items \
                        WHERE updated_at>( SELECT updated_at FROM sph_counter WHERE counter_id=1 )

    sql_query_post_index = REPLACE INTO sph_counter SELECT 2, (SELECT MAX(updated_at) FROM items)
}
```
  
```
sudo vim merge_daily_index.sh
```
```

#!/bin/bash
indexer=`which /opt/sphinx/bin/indexer`
mysql=`which mysql`

QUERY="use sphinx_items;select updated_at from sph_counter where counter_id = 2 limit 1;"
index_counter=$($mysql -h127.0.0.1 -uroot -proot -sN -e "$QUERY")

printf "\n\n" >> /opt/sphinx/var/log/index_merge.log
date +"%Y-%m-%d %H:%M:%S" >> /opt/sphinx/var/log/index_merge.log
#merge "main + delta" indexes
$indexer -c /opt/sphinx/etc/sphinx.conf --rotate --merge items items_delta  >> /opt/sphinx/var/log/index_merge.log 2>&1

if [ "$?" -eq 0 ]; then

    $mysql -h127.0.0.1 -uroot -proot -Dsphinx_items -e "REPLACE INTO sph_counter VALUES (1, '$index_counter')"

    printf "\n\n" >> /opt/sphinx/var/log/rebuild_delta_index.log
    date +"%Y-%m-%d %H:%M:%S" >> /opt/sphinx/var/log/rebuild_delta_index.log
    ##rebuild delta index to avoid confusion with main index合并后清空增量索引
    $indexer -c /opt/sphinx/etc/sphinx.conf --rotate items_delta >> /opt/sphinx/var/log/rebuild_delta_index.log 2>&1
fi
```
  
注释  
首次生成全部索引时  
计数表counter_id=1时，插入最新更新数据时间  
主索引生成  
  
每次更新增量索引时，counter_id=2，插入最近数据时间  
  
合并索引时counter_id=1,更新为最近数据时间  
增量索引再次更新，清空  
  
验证  
修改索引和最新时间 查询成功  
is_deleted修改     查询生效  
合并               查询生效，增量索引再次清空  
  
  
调试  
```
sudo ./bin/indextool --dumphitlist items       mysql -c ./etc/sphinx.conf
sudo ./bin/indextool --dumphitlist items_delta mysql -c ./etc/sphinx.conf
```
  
其他选项  
--merge-dst-range deleted 0 0
合并索引时的过滤条件，只有deleted 从0到0的索引才能合并到目标索引中，不使用  
```
bin\indexer --config etc\csft_mysql.conf --merge mysql delta --rotate --merge-dst-range group_id 2 2
註解：--merge-dst-range是合並生成主索引的范圍開關；
這句的意思是隻有主索引的group_id屬性為2，並且子索引的group_id屬性為2，才能被合並生成；
否則會被過濾掉，移出主索引。

過濾器可以多個，並且全部滿足時才能在最終合並的索引出現
http://www.wenwenti.info/article/804259
```
--merge-killlists
默认合并后删除2索引的kill lists，不使用  
  
参考  
- http://sphinxsearch.com/forum/view.html?id=10032 sphinx论坛，建议用timestamp来维护增量索引
- [Sphinx 配置sql_query_killlist解析](https://segmentfault.com/a/1190000002501058)
- http://sphinxsearch.com/docs/current.html#conf-sql-query-killlist
- [研究了coreseek下的sphinx 配置及api调用，收获颇多](http://www.linuxso.com/sql/13319.html) 介绍了用时间戳维护增量索引的方法，
介绍了使用mysql里面的一个特殊字段的功能处理数据更新问题，  
搜索1对多的情况，如每个文章对应有N个标签， sql_attr_multi字段用法  
- [sphinx的更新与删除](http://www.it610.com/article/2554043.htm) 关于PHP程序需要修改的地方介绍比较详细
  
  
  
  
  
调试  
日志rebuild_delta_index.log报错  
```
/opt/sphinx/var/log/rebuild_delta_index.log 记录报错如下
FATAL: failed to lock /opt/sphinx/var/data/items-delta.tmp.spl: Resource temporarily unavailable,
will not index. Try --rotate option.
经验证
命令行更新索引items_delta
/opt/sphinx/bin/indexer -c /opt/sphinx/etc/sphinx.conf --rotate items_delta
后无报错，但浏览器页面phpapi查询不到刚刚添加的新数据,即master分布式索引无效
```
接口返回总数total和实际返回数据条数不一致  
```
当总是缺一条数据时查看是不是传入的分页数据错误
$res = $s->query($words, 0, 10, 'master');这里第一页应该为0

其次应该排查真实数据是否已删除
返回的总数total是从索引中获得，然后通过索引获得的ids在数据库中取到数据。
如果数据库中已删除某些数据，但索引中依然存有该数据的id,就会导致total与实际数据不符的情况。
解决方法
更新索引（使用--rotate选项，不然searchd无法返回实时的数据）
or
重生成索引（使用--all选项），重新启动search程序



```
  
cron计划添加  
注意:  
使用root权限管理计划  
脚本设置可执行权限  
```
sudo crontab -e
\\* * * * *  /opt/sphinx/shell/delta_index_update.sh
0 3 * * *    /opt/sphinx/shell/merge_daily_index.sh
sudo crontab -l

# 重启计划
sudo systemctl restart cron.service

# 过几分钟查看日志
ls ./var/log
```
  
scws中文分词安装  
注意扩展的版本和php的版本  
```
wget -c http://www.xunsearch.com/scws/down/scws-1.2.3.tar.bz2
tar jxvf scws-1.2.3.tar.bz2
cd scws-1.2.3
./configure --prefix=/opt/scws
make && sudo make install
```
  
scws的PHP扩展安装  
```
./configure  --with-scws=/opt/scws --with-php-config=/usr/bin/php-config5.6
cd ./phpext
phpize5.6
./configure
make && sduo make install
# 成功后提示
Installing shared extensions:     /usr/lib/php/20131226/

sudo vim /etc/php/5.6/apache2/php.ini
# 在最后添加
[scws]
extension = scws.so
scws.default.charset = utf-8
scws.default.fpath = /opt/scws/etc/

# 重启apache2
sudo systemctl restart apache2.service

# 通过phpinfo()检查扩展scws安装成功
```
  
scws词库安装  
```
wget http://www.xunsearch.com/scws/down/scws-dict-chs-utf8.tar.bz2
sudo tar jxvf scws-dict-chs-utf8.tar.bz2 -C /opt/scws/etc/
sudo chown www-data:www-data /opt/scws/etc/dict.utf8.xdb
```
  
  
php使用Sphinx+scws测试例子  
在Sphinx源码API中,有好几种语言的API调用.其中有一个是sphinxapi.php。  
不过以下的测试使用的是Sphinx的PHP扩展.具体安装见本文开头的Sphinx安装部分。  
测试用的搜索类Search.php：注意修改getDBConnection()信息为自己的  
```
cd /var/www/html
vim Search.php
```
```
<?php
class Search {
    /**
     * @var SphinxClient
    **/
    protected $client;
    /**
     * @var string
    **/
    protected $keywords;
    /**
     * @var resource
    **/
    private static $dbconnection = null;

    /**
     * Constructor
     **/
    public function __construct($options = array()) {
        $defaults = array(
            'query_mode' => SPH_MATCH_EXTENDED2,
            'sort_mode' => SPH_SORT_EXTENDED,
            'ranking_mode' => SPH_RANK_PROXIMITY_BM25,
            'field_weights' => array(),
            'max_matches' => 1000,
            'snippet_enabled' => true,
            'snippet_index' => 'items',
            'snippet_fields' => array(),
        );
        $this->options = array_merge($defaults, $options);
        $this->client = new SphinxClient();
        //$this->client->setServer("192.168.1.198", 9312);
        $this->client->setMatchMode($this->options['query_mode']);
        if ($this->options['field_weights'] !== array()) {
            $this->client->setFieldWeights($this->options['field_weights']);
        }
        /*
        if ( in_array($this->options['query_mode'], [SPH_MATCH_EXTENDED2,SPH_MATCH_EXTENDED]) ) {
            $this->client->setRankingMode($this->options['ranking_mode']);
        }
        */
    }

    /**
     * Query
     *
     * @param string  $keywords
     * @param integer $offset
     * @param integer $limit
     * @param string  $index
     * @return array
     **/
    public function query($keywords, $offset = 0, $limit = 10, $index = '*') {
        $this->keywords = $keywords;
        $max_matches = $limit > $this->options['max_matches'] ? $limit : $this->options['max_matches'];
        $this->client->setLimits($offset, $limit, $max_matches);
        $query_results = $this->client->query($keywords, $index);

        if ($query_results === false) {
            $this->log('error:' . $this->client->getLastError());
        }

        $res = [];
        if ( empty($query_results['matches']) ) {
            return $res;
        }
        $res['total'] = $query_results['total'];
        $res['total_found'] = $query_results['total_found'];
        $res['time'] = $query_results['time'];
        $doc_ids = array_keys($query_results['matches']);
        unset($query_results);
        $res['data'] = $this->fetch_data($doc_ids);
        if ($this->options['snippet_enabled']) {
            $this->buildExcerptRows($res['data']);
        }

        return $res;
    }

    /**
     * custom sorting
     *
     * @param string $sortBy
     * @param int $mode
     * @return bool
     **/
    public function setSortBy($sortBy = '', $mode = 0) {
        if ($sortBy) {
            $mode = $mode ?: $this->options['sort_mode'];
            $this->client->setSortMode($mode, $sortBy);
        } else {
            $this->client->setSortMode(SPH_SORT_RELEVANCE);
        }
    }

    /**
     * fetch data based on matched doc_ids
     *
     * @param array $doc_ids
     * @return array
     **/
    protected function fetch_data($doc_ids) {
        $ids = implode(',', $doc_ids);
        $queries = self::getDBConnection()->query("SELECT * FROM items WHERE id in ($ids)", PDO::FETCH_ASSOC);
        return iterator_to_array($queries);
    }

    /**
     * build excerpts for data
     *
     * @param array $rows
     * @return array
     **/
    protected function buildExcerptRows(&$rows) {
        $options = array(
            'before_match' => '<b style="color:red">',
            'after_match'  => '</b>',
            'chunk_separator' => '...',
            'limit'    => 256,
            'around'   => 3,
            'exact_phrase' => false,
            'single_passage' => true,
            'limit_words' => 5,
        );
        $scount = count($this->options['snippet_fields']);
        foreach ($rows as &$row) {
            foreach ($row as $fk => $item) {
                if (!is_string($item) || ($scount && !in_array($fk, $this->options['snippet_fields'])) ) continue;
                $item = preg_replace('/[\r\t\n]+/', '', strip_tags($item));
                $res = $this->client->buildExcerpts(array($item), $this->options['snippet_index'], $this->keywords, $options);
                $row[$fk] = $res === false ? $item : $res[0];
            }
        }
        return $rows;
    }

    /**
     * database connection
     *
     * @return resource
     **/
    private static function getDBConnection() {
        $dsn = 'mysql:host=127.0.0.1;dbname=sphinx_items';
        $user = 'root';
        $pass = 'root';
        if (!self::$dbconnection) {
            try {
                self::$dbconnection = new PDO($dsn, $user, $pass);
            } catch (PDOException $e) {
                die('Connection failed: ' . $e->getMessage());
            }
        }
        return self::$dbconnection;
    }

    /**
     * Chinese words segmentation
     *
     **/
    public function wordSplit($keywords) {
        $fpath = ini_get('scws.default.fpath');
        $so = scws_new();
        $so->set_charset('utf-8');
        $so->add_dict($fpath . '/dict.utf8.xdb');
        //$so->add_dict($fpath .'/custom_dict.txt', SCWS_XDICT_TXT);
        $so->set_rule($fpath . '/rules.utf8.ini');
        $so->set_ignore(true);
        $so->set_multi(false);
        $so->set_duality(false);
        $so->send_text($keywords);
        $words = [];
        $results =  $so->get_result();
        foreach ($results as $res) {
            $words[] = '(' . $res['word'] . ')';
        }
        $words[] = '(' . $keywords . ')';
        return join('|', $words);
    }

    /**
     * get current sphinx client
     *
     * @return resource
     **/
    public function getClient() {
        return $this->client;
    }
    /**
     * log error
     **/
    public function log($msg) {
        // log errors here
        //echo $msg;
    }
    /**
     * magic methods
     **/
    public function __call($method, $args) {
        $rc = new ReflectionClass('SphinxClient');
        if ( !$rc->hasMethod($method) ) {
            throw new Exception('invalid method :' . $method);
        }
        return call_user_func_array(array($this->client, $method), $args);
    }
}
```
ps:  
conf配置文件中max_matches在版本升级中已移除  
由于phpapi仍然采用1.3.3版php扩展，所以该字段保留  
  
```
vim test.php
```
```
<?php
require('Search.php');
$s = new Search([
        'snippet_fields' => ['title', 'content'],
        'field_weights' => ['title' => 20, 'content' => 10],
    ]);
$s->setSortMode(SPH_SORT_EXTENDED, 'created desc,@weight desc');
//$s->setSortBy('created desc,@weight desc');
$words = $s->wordSplit("mysql集群");//先分词 结果：(mysql)|(mysql集群)
//print_r($words);exit;
$res = $s->query($words, 0, 10, 'master');
echo '<pre/>';print_r($res);
```
  
  
  
- http://sphinxsearch.com/docs/current.html
- [php+中文分词scws+sphinx+mysql打造千万级数据全文搜索](http://blog.csdn.net/nuli888/article/details/51892776) 系统环境：centos6.5+php5.6+apache+mysql 安装版本sphinx-2.0.7-release  scws-1.2.3 增量索引 PHP封装好
- [Sphinx + PHP + scws构建MySQL准实时分布式全文检索](http://blog.csdn.net/u013699800/article/details/23968885) sphinx-2.0.7-release scws-1.2.1
- [sphinx+scws 全文检索使用之 安装配置篇](http://blog.csdn.net/qq_21267705/article/details/52473190) 介绍了各种方案的优缺点，
- [Sphinx+Scws 搭建千万级准实时搜索&应用场景详解](http://blog.csdn.net/black_OX/article/details/21801217)
- [基于Sphinx+MySQL的千万级数据全文检索（搜索引擎）架构设计](http://blog.csdn.net/ygm_linux/article/details/50830289) 张宴版，使用SphinxSE,版本老
  
https://www.zybuluo.com/lxjwlt/note/141406 [译]《Sphinx权威指南》 - Sphinx入门  
[千万级Discuz!数据全文检索方案（Sphinx）](https://wenku.baidu.com/view/3f81b62952d380eb63946d22.html?mark_pay_doc=0&mark_rec_page=1&mark_rec_position=2&clear_uda_param=1)  
  
  
[Sphinx的工作原理，深入浅出sphinx](http://www.bkjia.com/Mysql/1121327.html)  
[关于sphinx的分布式索引及与分布式架构的选择](http://www.04007.cn/article/470.html)  
  
  
 <2018-01-09 二>  
sphinx中文分词实践												 :sphinx:  
  
http://sphinxsearch.com/ 官网  
```
Coreseek
sfc（sphinx-for-chinese）
```
来自 http://www.sphinxsearch.org/sphinx-tutorial  
  
https://wenku.baidu.com/view/9c0d79c25fbfc77da269b1ec.html  
  
### 其他
#### Ubuntu 16.04 Mysql和PHP 配置 Sphinx-for-chinese 及Sphinx的排序筛选分页基本操作 成功
http://blog.csdn.net/joyatonce/article/details/52059564?utm_source=itdadao&utm_medium=referral  
  
不要用原生Sphinx，因为中文支持不好。要用sphinx-for-chinese，数据库编码要用utf-8，既能很好的受sphinx支持，又符合php规范。  
  
[plain] view plain copy  
```
git clone https://github.com/eric1688/sphinx
```
  
[plain] view plain copy  
```
cd sphinx
```
  
./configure --prefix=/usr/local/sphinx --with-mysql  
  
[plain] view plain copy  
make & make install  
  
从xdict_1.1.txt生成xdict文件，xdict_1.1.txt文件可以根据需要进行修改  
[plain] view plain copy  
/usr/local/sphinx/bin/mkdict xdict_1.1.txt xdict  
  
xdict生成完成显示：  
  
[plain] view plain copy  
Preparing...  
Making Chinese dictionary:      100% |******************************|  
Total words:                    284757  
File size:                      2854912 bytes  
Compression ratio:              100 %  
Chinese dictionary was successfully created!  
  
将xdict放入sphinx目录：  
[plain] view plain copy  
```
cp xdict /usr/local/sphinx/etc/
```
  
修改sphinx.conf索引配置文件：  
[plain] view plain copy  
```
cd /usr/local/sphinx/etc/
```
  
```
cp sphinx.conf.dist sphinx.conf
```
  
```
vim sphinx.conf
```
```
# sphinx基本配置
# 索引源
source sources_src
{
    # 数据库类型
    type = mysql
    # MySQL主机IP
    sql_host = localhost
    # MySQL用户名
    sql_user = root
    # MySQL密码
    sql_pass = root
    # MySQL数据库
    sql_db = www.data.c
    # MySQL端口(如果防火墙有限制,请开启)
    sql_port= 3306
    # MySQL sock文件设置(默认为/tmp/mysql.sock,如果不一样,请指定)
    # sql_sock = /tmp/mysql.sock
    # MySQL检索编码(数据库非utf8的很可能检索不到)
    sql_query_pre = SET NAMES UTF8
    # 获取数据的SQL语句
    sql_query = SELECT source_id,source_id as source_id_new,title,title as title_new,media_id from source
    # 以下是用来过滤或条件查询的属性(以下字段显示在查询结果中,不在下面的字段就是搜索时要搜索的字段,如SQL语句中的goods_color_search,goods_name_search)
    # 无符号整型
    #goods_id为主键,如果加在这里在生成索引的时候会报attribute 'goods_id' not found,这里用goods_id_new来变通
    sql_attr_uint = source_id_new
    # 字符串类型
    sql_attr_string = title_new
    # 用于命令界面端(CLI)调用的测试(一般来说不需要)
    #sql_query_info = SELECT * FROM goods_test Where goods_id = $goods_id;
}
# 索引
index sources
{
    # 索引源声明
    source = sources_src
    # 索引文件的存放位置
    path = /usr/local/sphinx/var/data/sources
    # 文件存储模式(默认为extern)
    docinfo = extern
    # 缓存数据内存锁定
    mlock = 0
    # 马氏形态学(对中文无效)
    morphology = none
    # 索引词最小长度
    min_word_len = 1
    # 数据编码(设置成utf8才能索引中文)
    charset_type = utf-8
    # 中文分词词典
    chinese_dictionary = /usr/local/sphinx/etc/xdict
    # 最小索引前缀长度
    min_prefix_len = 0
    # 最小索引中缀长度
    min_infix_len = 1
    # 对于非字母型数据的长度切割(for CJK indexing)
    ngram_len = 1
    # 对否对去除用户输入查询内容的html标签
    html_strip = 0
}
# 索引器设置
indexer
{
    # 内存大小限制 默认是 32M, 最大 2047M, 推荐为 256M 到 1024M之间
    mem_limit = 256M
}
# sphinx服务进程search的相关配置
searchd
{
    # 监测端口及形式,一下几种均可,默认为本机9312端口
    # listen = 127.0.0.1
    # listen = 192.168.0.1:9312
    listen = 9312:sphinx
    # listen = 9312
    # listen = /var/run/searchd.sock
    # search进程的日志路径
    log = /usr/local/sphinx/var/log/searchd.log
    # 查询日志地址
    query_log = /usr/local/sphinx/var/log/query.log
    # 读取超时时间
    read_timeout = 5
    # 请求超时市时间
    client_timeout = 300
    # searche进程的最大运行数
    max_children = 30
    # 进程ID文件
    pid_file = /usr/local/sphinx/var/log/searchd.pid
    # 最大的查询结果返回数
    max_matches = 1000
    # 是否支持无缝切换(做增量索引时需要)
    seamless_rotate = 1
    # 在启动运行时是否提前加载所有索引文件
    preopen_indexes = 0
    # 是否释放旧的索引文件
    unlink_old = 1
    # MVA跟新池大小(默认为1M)
    mva_updates_pool = 1M
    # 最大允许的网络包大小(默认8M)
    max_packet_size = 8M
    # 每个查询最大允许的过滤器数量(默认256)
    max_filters = 256
    #每个过滤器最大允许的值的个数(默认4096)
    max_filter_values = 4096
    # 每个组的最大查询数(默认为32)
    max_batch_queries = 32
}
# Sphinx配置文件结束

```
  
准备测试数据  
```
mysql> create database sphinx collate 'utf8_general_ci';
mysql> grant all privileges on sphinx.* to 'sphinxuser'@'' identified by 'sphinxpass';
mysql> grant all privileges on sphinx.* to 'sphinxuser'@'localhost' identified by 'sphinxpass';
mysql> use sphinx;
mysql> CREATE TABLE IF NOT EXISTS `goods_test` (
`goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
`goods_name` varchar(255) NOT NULL COMMENT '商品名称',
`goods_color` varchar(60) NOT NULL COMMENT '商品颜色',
PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品表,sphinx示例' AUTO_INCREMENT=11 ;
mysql> INSERT INTO `goods_test` (`goods_id`, `goods_name`, `goods_color`) VALUES
(1, '热卖时尚双肩背包', '黑色'),
(2, '热卖时尚电脑双肩背包', '灰色'),
(3, '缤纷炫动时尚化妆包', '黑色'),
(4, '缤纷炫动时尚化妆包', '蓝色'),
(5, '缤纷炫动时尚化妆包', '粉红'),
(6, '极致性感 女款衬衫', '黑色'),
(7, '个性宣言 男款短袖衬衫', '蓝色'),
(8, '个性宣言 男款短袖衬衫', '红色'),
(9, '个性宣言 男款短袖衬衫', '绿色'),
(10, '个性宣言 男款短袖衬衫', '黑色');
```
摘自 http://www.xuejiehome.com/blread-1283.html  
  
配置好了，增加索引：  
[plain] view plain copy  
/usr/local/sphinx/bin/indexer  -c /usr/local/sphinx/etc/sphinx.conf goods  
  
如果配置文件里有多个索引,需要一次生成使用--all参数  
[plain] view plain copy  
/usr/local/sphinx/bin/indexer -c /usr/local/sphinx/etc/sphinx.conf --all  
  
开启守护进程(接受PHP程序的调用)  
[plain] view plain copy  
/usr/local/sphinx/bin/searchd -c /usr/local/sphinx/etc/sphinx.conf  
如果重建索引时守护进程正在运行，需要运行下面的指令，会重建索引并且重开守护进程  
[plain] view plain copy  
/usr/local/sphinx/bin/indexer -c /usr/local/sphinx/etc/sphinx.conf --all --rotate  
  
ubuntu 关闭 iptables  
[plain] view plain copy  
ufw disable  
  
把 git目录下sphinx/api/sphinxapi.php copy 出来到 sphinx-php目录 进入目录  
  
```
vim Model_SphinxClient.php
```
```
<?php
include_once("./sphinxapi.php");
class Model_SphinxClient extends SphinxClient {

    protected static $_instance = null;

    public static function instance(){
        if(self::$_instance == null){
            self::$_instance = new self();

            self::$_instance->SetServer('127.0.0.1',9312);

            self::$_instance->SetConnectTimeout(3);

            self::$_instance->SetMaxQueryTime(2000);

        }
        return self::$_instance;
    }

}
```
  
```
vim index.php
```
```
<?php
include_once("./Model_SphinxClient.php");

$sphinx = Model_SphinxClient::instance();
//...//排序
//...//分页
//...//筛选等
$data = $sphinx->Query('个性宣言','goods');

echo '<pre>';

//print_r($data);

foreach($data['matches'] as $val) {
    foreach($val['attrs'] as $k=>$v){
        echo '   |   '.$k;
    }
    echo '<br>';
    break;
}

foreach($data['matches'] as $val) {
    foreach($val['attrs'] as $k=>$v){
        echo '   |   '.$v;
    }
    echo '<br>';
}

```
  
Debug  
http://www.04007.cn/article/256.html  
ERROR: index 'test1': No fields in schema - will not index.  
报错提示：在模式中没有字段，不会索引。简单理解一下，因为我的SQL是：sql_query=select id,id as ids,title, from webinfo，而id和title都当做属性被索引，sphinx搜索是想通过索引项，然后查询出其它的非索引 项，即id和title都被索引了，通过id,title搜索出来的结果里有什么呢？就是没有其它的字段可供搜索出来，索引也没什么意义。所以需要更改sql，增加查询的字段，如：sql_query=select id,id as ids,title,url,keywords,description from webinfo 即可。  
  
  
```
sudo vim etc/sphinx_sources.conf
sudo /usr/local/sphinx/bin/indexer  -c /usr/local/sphinx/etc/sphinx_sources.conf sources
sudo /usr/local/sphinx/bin/searchd -c /usr/local/sphinx/etc/sphinx_sources.conf
```
  
  
#### sphinx-for-chinese-1.10.1及中文分词词典xdict_1.1 编译失败 <2018-01-10 三>
- [[http://www.xuejiehome.com/blread-1283.html][Sphinx中文分词详细安装配置及API调用实战手册]] 实践详细,基于 [sphinx-for-chinese](http://sphinxsearchcn.github.io/) -1.10.1及中文分词词典xdict_1.1
```
cd /usr/local/src
sudo wget https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/sphinx-for-chinese/sphinx-for-chinese-1.10.1-dev-r2287.tar.gz  # 可通过浏览器下载
sudo wget https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/sphinx-for-chinese/xdict_1.1.tar.gz
make # 出错...
```
#### sphinx-chinese github版 分词采用scws 缺对mysql的支持,调试成功 <2018-01-10 三>
```
安装scws

可以参考 https://github.com/hightman/scws 里的安装方法

cd /tmp
wget http://www.xunsearch.com/scws/down/scws-1.2.1.tar.bz2
tar xjf scws-1.2.1.tar.bz2
cd scws-1.2.1
#默认路径(/user/local)就简单的 ./configure --enable-static
./configure --prefix=/tmp/scws --enable-static #需要静态编译
make
make install
tree /tmp/scws
安装sphinx

源码存储在 https://github.com/hetao29/sphinx ，这是官方的分支

cd /tmp
git clone https://github.com/hetao29/sphinx.git sphinx-chinese
cd sphinx-chinese
#请使用-chinese的分支，目前有2个，master-chinese, rel22-chinese
git checkout rel22-chinese
#如果默认安装就是 --with-scws=/usr/local
./configure --prefix=/tmp/sphinx_bin/ --with-scws=/tmp/scws/
make
make install
测试

cd /tmp
git clone https://github.com/hetao29/sphinx-chinese.git sphinx-test
cd sphinx-test/test
make  #测试
```
参考 https://github.com/hetao29/sphinx-chinese github较新的版本安装  
https://github.com/hetao29/sphinx-chinese 测试脚本地址  
https://github.com/hetao29/sphinx 脚本地址  
测试成功，可以安装成功词典scws(Simple Chinese Word Segmentation)和sphinx-chinese,  
成果：通过测试脚本可以对xml文件建立索引  
```
/tmp/sphinx-test/test$ ls
course.conf  course.xml  Makefile
make  # 可以看到对cource.xml建立的索引
```
查看版本和文档  
  
```
/tmp/sphinx-chinese/$ ls  # 查看到doc目录
cd doc/ && ls  # 发现html文档
nautilus ./    # 打开文将管理器
```
打开index.html 找到 Sphinx 2.2.11-dev 和参考文档  
  
#### sphinx 2.2.11 ubuntu稳定版安装
参考 http://sphinxsearch.com/docs/latest/installing-debian.html  
下载地址 http://sphinxsearch.com/downloads/archive/ 下载 Ubuntu 16.04 LTS x86_64 DEB 版本  
  
```
sudo apt-get install mysql-client unixodbc libpq5
sudo dpkg -i sphinxsearch_2.2.11-release-1~xenial_amd64.deb
sudo service sphinxsearch start
```
  
#### Sphinx 0.9.9/Coreseek 3.2
  
Sphinx 0.9.9/Coreseek 3.2 参考手册  
Sphinx--强大的开源全文检索引擎，Coreseek--免费开源的中文全文检索引擎  
http://sphinxsearch.com/wiki/doku.php?id=sphinx_manual_chinese#sphinx_coreseek快速入门教程  
http://sphinxsearch.com/wiki/doku.php?id=sphinx_manual_chinese#通用api方法  
http://sphinxsearch.com/wiki/doku.php?id=sphinx_manual_chinese#mysql_存储引擎_sphinxse  
PHP API Documentation  
This document lays out the methods from the Sphinx PHP API and gives examples in their use. It is current as of Sphinx 0.9.8-r1065.  
http://sphinxsearch.com/wiki/doku.php?id=php_api_docs  
https://github.com/sngrl/sphinxsearch Sphinx Search for Laravel 5 - Custom build with snippets support  
- [Coreseek + Sphinx + Mysql + PHP构建中文检索引擎](https://yq.aliyun.com/articles/46594)
- [CentOS下编译安装coreseek-4.1-beta](http://www.opstool.com/article/321)  http://pppboy.com/archives/32  3.2.14下载
- http://www.pythondoc.com/sphinx/index.html Python版
- https://gitee.com/lonely/lsearch/tree/master/dome 善良版
  
#### 如何安装和配置Sphinx在Ubuntu 16.04 成功
摘自 https://www.howtoing.com/how-to-install-and-configure-sphinx-on-ubuntu-16-04  
  
第1步 - 安装Sphinx  
在Ubuntu上安装Sphinx很容易，因为它在本地软件包存储库中。 使用安装它apt-get 。  
  
```
sudo apt-get install sphinxsearch
```
现在您已经在服务器上成功安装了Sphinx。 在启动Sphinx守护进程之前，让我们进行配置。  
  
第2步 - 创建测试数据库  
  
  
接下来，我们将使用随包提供的SQL文件中的示例数据设置数据库。 这将允许我们测试Sphinx搜索以后工作。  
  
让我们将示例SQL文件导入数据库。 首先，登录到MySQL服务器shell。  
  
mysql -u root -p  
提示时输入MySQL root用户的密码。 您提示将改变为mysql> 。  
  
创建虚拟数据库。 在这里，我们称它为测试 ，但你可以将其命名为任何你想要的。  
  
CREATE DATABASE test;  
导入示例SQL文件。  
  
SOURCE /etc/sphinxsearch/example.sql;  
然后离开MySQL shell。  
  
quit  
现在你有一个数据库填充样本数据。 接下来，我们将定制Sphinx的配置。  
  
第3步 - 配置Sphinx  
Sphinx的配置应该是在一个名为sphinx.conf中/etc/sphinxsearch 。 配置包括那些运行必不可少的3个主要模块： 索引 ，searchd的 ，和来源 。 我们将提供一个示例配置文件供您使用，并解释每个部分，以便以后进行自定义。  
  
首先，创建sphinx.conf文件。  
  
```
sudo nano /etc/sphinxsearch/sphinx.conf
```
这些指数 ，searchd的 ，和源块的描述如下。 然后，在这个步骤结束时，对全部sphinx.conf被包括为你复制并粘贴到文件中。  
  
源块包含源代码，用户名和密码到MySQL服务器的类型。 所述的第一列sql_query应该是唯一的ID。 SQL查询将在每个索引上运行，并将数据转储到Sphinx索引文件。 下面是每个字段和源块本身的描述。  
  
type ：数据源索引的类型。 在我们的例子，这是MySQL。 其他支持的类型包括pgsql，mssql，xmlpipe2，odbc等。  
sql_host ：主机名MySQL的主机。 在我们的例子，这是localhost 。 这可以是域或IP地址。  
sql_user ：用户名MySQL的登录。 在我们的例子，这是根源 。  
sql_pass ：密码为MySQL用户。 在我们的示例中，这是根MySQL用户的密码。  
sql_db ：存储数据的数据库的名称。 在我们的例子，这是考验 。  
sql_query ：查询从数据库到索引那转储数据。  
这是源块：  
  
sphinx.conf的源代码块  
```
source src1
```
{  
  type          = mysql  
  
  #SQL settings (for ‘mysql’ and ‘pgsql’ types)  
  
  sql_host      = localhost  
  sql_user      = root  
  sql_pass      = password  
  sql_db        = test  
  sql_port      = 3306 # optional, default is 3306  
  
  sql_query     = \  
  SELECT id, group_id, UNIX_TIMESTAMP(date_added) AS date_added, title, content \  
  FROM documents  
  
  sql_attr_uint         = group_id  
  sql_attr_timestamp    = date_added  
}  
索引组件包含源和存储数据的路径。  
在  
  
```
source ：源块的名称。 在我们的例子，这是src1的 。
```
path ：路径保存索引。  
sphinx.conf的索引块  
index test1  
{  
  source        = src1  
  path          = /var/lib/sphinxsearch/data/test1  
  docinfo       = extern  
}  
该searchd的组件包含端口和其他变量来运行Sphinx守护进程。  
  
listen ：这Sphinx守护进程运行的端口，后面的协议。 在我们的例子，这是9306：mysql41。 已知的协议是：Sphinx （SphinxAPI）和：mysql41（SphinxQL）  
query_log ：路径保存查询日志。  
pid_file ：到Sphinx守护进程的PID文件的路径。  
seamless_rotate ：同时旋转海量数据预缓存的指标，防止searchd的摊位。  
preopen_indexes ：是否强行盘前在启动时的所有索引。  
unlink_old ：是否删除成功旋转旧的索引拷贝。  
searchd块的sphinx.conf  
searchd  
{  
  listen            = 9312:sphinx       #SphinxAPI port  
  listen            = 9306:mysql41      #SphinxQL port  
  log               = /var/log/sphinxsearch/searchd.log  
  query_log         = /var/log/sphinxsearch/query.log  
  read_timeout      = 5  
  max_children      = 30  
  pid_file          = /var/run/sphinxsearch/searchd.pid  
  seamless_rotate   = 1  
  preopen_indexes   = 1  
  unlink_old        = 1  
  binlog_path       = /var/lib/sphinxsearch/data  
}  
复制和粘贴的完整配置如下。 你需要下面来改变它唯一的变量是sql_pass源块，这是高亮显示的变量。  
  
完整的sphinx.conf文件  
```
source src1
```
{  
  type          = mysql  
  
  sql_host      = localhost  
  sql_user      = root  
  sql_pass      = your_root_mysql_password  
  sql_db        = test  
  sql_port      = 3306  
  
  sql_query     = \  
  SELECT id, group_id, UNIX_TIMESTAMP(date_added) AS date_added, title, content \  
  FROM documents  
  
  sql_attr_uint         = group_id  
  sql_attr_timestamp    = date_added  
}  
index test1  
{  
  source            = src1  
  path              = /var/lib/sphinxsearch/data/test1  
  docinfo           = extern  
}  
searchd  
{  
  listen            = 9306:mysql41  
  log               = /var/log/sphinxsearch/searchd.log  
  query_log         = /var/log/sphinxsearch/query.log  
  read_timeout      = 5  
  max_children      = 30  
  pid_file          = /var/run/sphinxsearch/searchd.pid  
  seamless_rotate   = 1  
  preopen_indexes   = 1  
  unlink_old        = 1  
  binlog_path       = /var/lib/sphinxsearch/data  
}  
探索更多的配置，你可以看看在/etc/sphinxsearch/sphinx.conf.sample文件，里面有所有的变量在更详细的解释。  
  
第4步 - 管理索引  
  
  
在这一步中，我们将数据添加到Sphinx索引，并确保利用指数保持最新cron 。  
  
首先，使用我们之前创建的配置将数据添加到索引。  
  
```
sudo indexer --all
```
你应该得到类似下面的东西。  
  
OutputSphinx 2.2.9-id64-release (rel22-r5006)  
Copyright (c) 2001-2015, Andrew Aksyonoff  
Copyright (c) 2008-2015, Sphinx Technologies Inc (http://sphinxsearch.com)  
  
using config file '/etc/sphinxsearch/sphinx.conf'...  
indexing index 'test1'...  
collected 4 docs, 0.0 MB  
sorted 0.0 Mhits, 100.0% done  
total 4 docs, 193 bytes  
total 0.010 sec, 18552 bytes/sec, 384.50 docs/sec  
total 4 reads, 0.000 sec, 0.1 kb/call avg, 0.0 msec/call avg  
total 12 writes, 0.000 sec, 0.1 kb/call avg, 0.0 msec/call avg  
在生产环境中，有必要保持索引为最新。 为了做到这一点，让我们创建一个cronjob。 首先，打开crontab。  
  
crontab -e  
可能会询问您要使用哪个文本编辑器。 选择你喜欢的; 在本教程中，我们使用nano 。  
  
随后的cronjob将每小时运行一次，并使用我们之前创建的配置文件向索引添加新数据。 将其复制并粘贴到文件末尾，然后保存并关闭文件。  
  
crontab  
@hourly /usr/bin/indexer --rotate --config /etc/sphinxsearch/sphinx.conf --all  
现在Sphinx已经完全设置和配置，我们可以启动服务并尝试。  
  
第5步 - 启动Sphinx  
默认情况下，Sphinx守护程序关闭。 首先，我们将改变这一行启用START=no到START=yes中/etc/default/sphinxsearch 。  
  
```
sudo sed -i 's/START=no/START=yes/g' /etc/default/sphinxsearch
```
然后，使用systemctl重启Sphinx守护进程。  
  
```
sudo systemctl restart sphinxsearch.service
```
要检查Sphinx守护程序是否正确运行，请运行。  
  
```
sudo systemctl status sphinxsearch.service
```
你应该得到类似下面的东西。  
  
Output● sphinxsearch.service - LSB: Fast standalone full-text SQL search engine  
   Loaded: loaded (/etc/init.d/sphinxsearch; bad; vendor preset: enabled)  
   Active: active (running) since Tue 2016-07-26 01:50:00 EDT; 15s ago  
   . . .  
这也将确保Sphinx守护程序即使在服务器重新启动时也启动。  
  
第6步 - 测试  
  
  
现在，一切都设置好了，让我们测试搜索功能。 使用MySQL接口连接到SphinxQL（在端口9306上）。 您提示将改变为mysql> 。  
  
mysql -h0 -P9306  
让我们搜索一个句子。  
  
SELECT * FROM test1 WHERE MATCH('test document'); SHOW META;  
你应该得到类似下面的东西。  
  
Output+------+----------+------------+  
| id   | group_id | date_added |  
+------+----------+------------+  
|    1 |        1 | 1465979047 |  
|    2 |        1 | 1465979047 |  
+------+----------+------------+  
2 rows in set (0.00 sec)  
  
+---------------+----------+  
| Variable_name | Value    |  
+---------------+----------+  
| total         | 2        |  
| total_found   | 2        |  
| time          | 0.000    |  
| keyword[0]    | test     |  
| docs[0]       | 3        |  
| hits[0]       | 5        |  
| keyword[1]    | document |  
| docs[1]       | 2        |  
| hits[1]       | 2        |  
+---------------+----------+  
9 rows in set (0.00 sec)  
在上述结果可以看出，Sphinx发现从我们的2场比赛test1索引我们的测试句子。 该SHOW META;命令显示以及在句子中每个关键字的点击。  
  
让我们搜索一些关键字。  
  
CALL KEYWORDS ('test one three', 'test1', 1);  
你应该得到类似下面的东西。  
  
Output+------+-----------+------------+------+------+  
| qpos | tokenized | normalized | docs | hits |  
+------+-----------+------------+------+------+  
| 1    | test      | test       | 3    | 5    |  
| 2    | one       | one        | 1    | 2    |  
| 3    | three     | three      | 0    | 0    |  
+------+-----------+------------+------+------+  
3 rows in set (0.00 sec)  
在结果上面可以看到，在test1的指数，Sphinx发现：  
  
5个匹配在3个文档中的关键字'test'  
2在1个文档中匹配关键字“1”  
0匹配0个文档中的关键字'three'  
现在你可以离开MySQL shell了。  
  
quit  
结论  
在本教程中，我们向您展示了如何安装Sphinx，并使用SphinxQL和MySQL进行简单搜索。  
  
您还可以找到官方对于PHP，Perl，Python和Ruby和Java本地SphinxAPI实现 。 如果你正在使用的NodeJS，你也可以使用该SphinxAPI包  
