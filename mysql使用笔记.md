
## 查询每种状态的数量
SELECT 
SUM(case when is_erp = 1 then 1 else 0 end) as is_erp_1,
SUM(case when is_erp = 0 then 1 else 0 end) as is_erp_0
 FROM company_accounts;
 https://stackoverflow.com/questions/10356293/count-different-status-in-my-sql-table
## mysql中set autocommit=0与start transaction区别
set autocommit=0,
当前session禁用自动提交事物，自此句执行以后，每个SQL语句或者语句块所在的事务都需要显示"commit"才能提交事务。

start transaction

指的是启动一个新事务。

 

     在默认的情况下，MySQL从自动提交（autocommit）模式运行，这种模式会在每条语句执行完毕后把它作出的修改立刻提交给数据库并使之永久化。事实上，这相当于把每一条语句都隐含地当做一个事务来执行。如果你想明确地执行事务，需要禁用自动提交模式并告诉MySQL你想让它在何时提交或回滚有关的修改。
执行事务的常用办法是发出一条START TRANSACTION（或BEGIN）语句挂起自动提交模式，然后执行构成本次事务的各条语句，最后用一条 COMMIT语句结束事务并把它们作出的修改永久性地记入数据库。万一在事务过程中发生错误，用一条ROLLBACK语句撤销事务并把数据库恢复到事务开 始之前的状态。
https://www.cnblogs.com/langtianya/p/4777662.html
## 彻底搞懂 MySQL 事务的隔离级别
 https://developer.aliyun.com/article/743691
## 事务隔离级别中的可重复读能防幻读吗?
 https://cloud.tencent.com/developer/article/1506516

## explain索引优化
　https://segmentfault.com/a/1190000008131735
同一个SQL语句，为啥性能差异咋就这么大呢？（1分钟系列）
Original 58沈剑  架构师之路 https://mp.weixin.qq.com/s?__biz=MjM5ODYxMDA5OQ==&mid=2651962514&idx=1&sn=550c48c9395b52b7ec561741e86e5ce0&chksm=bd2d094e8a5a80589117a653a30d062b5760ec20f8ab9e2154a63ab782d3353d1b1da50b9bc2&scene=21#wechat_redirect
## mysql 紧急停止
ubuntu下 /etc/init.d/mysql stop  

## 清除表命令
truncate table 表名;     清除表  
 
## mysql like模糊匹配无法匹配_0的问题
如果like模糊匹配 0_0_0  、_001、0 、PRD190820002 等时，搜索 0_0_0时也会匹配出PRD190820002等值，不精确。
参考 https://dev.mysql.com/doc/refman/5.7/en/string-comparison-functions.html

转义掉_
```
$v = str_replace(['_', '%'], ['\_', '\%'], $v);
```
## replace into语法,插入时覆盖旧数据
mysql 5.7:
  
REPLACE works exactly like INSERT, except that if an old row  
in the table has the same value as a new row for a PRIMARY KEY or  
a UNIQUE index, the old row is deleted before the new row is inserted.  
  
例如  
```
CREATE TABLE test (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  data VARCHAR(64) DEFAULT NULL,
  ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);
When we create this table and run the statements shown in the mysql client, the result is as follows:


mysql> REPLACE INTO test VALUES (1, 'Old', '2014-08-20 18:47:00');
Query OK, 1 row affected (0.04 sec)

mysql> REPLACE INTO test VALUES (1, 'New', '2014-08-20 18:47:42');
Query OK, 2 rows affected (0.04 sec)

mysql> SELECT * FROM test;
```
  
+----+------+---------------------+  
| id | data | ts                  |  
+----+------+---------------------+  
|  1 | New  | 2014-08-20 18:47:42 |  
+----+------+---------------------+  
1 row in set (0.00 sec)  
Now we create a second table almost identical to the first,  
except that the primary key now covers 2 columns, as shown here (emphasized text):  
```
CREATE TABLE test2 (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  data VARCHAR(64) DEFAULT NULL,
  ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id, ts)
);
When we run on test2 the same two REPLACE statements as we did on the original test table, we obtain a different result:

mysql> REPLACE INTO test2 VALUES (1, 'Old', '2014-08-20 18:47:00');
Query OK, 1 row affected (0.05 sec)

mysql> REPLACE INTO test2 VALUES (1, 'New', '2014-08-20 18:47:42');
Query OK, 1 row affected (0.06 sec)

mysql> SELECT * FROM test2;
```
  
+----+------+---------------------+  
| id | data | ts                  |  
+----+------+---------------------+  
|  1 | Old  | 2014-08-20 18:47:00 |  
|  1 | New  | 2014-08-20 18:47:42 |  
+----+------+---------------------+  
2 rows in set (0.00 sec)  
This is due to the fact that, when run on test2, both the id and  
ts column values must match those of an existing row for the row to be replaced; otherwise, a row is inserted.  
  
  
sphinx 增量索引创建时的疑问  
```
CREATE TABLE IF NOT EXISTS `sph_counter` (
  `counter_id` int(11) NOT NULL,
  `max_doc_id` int(11) NOT NULL,
  PRIMARY KEY (`counter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='增量索引标示的计数表';

INSERT INTO `sph_counter` VALUES (1, 11);
INSERT INTO `sph_counter` VALUES (2, 12);


-- 以下语句执行一次时表里替换第一条，第二次创建时替换第二条，以后再执行时不会修改表里数据，为什么？
REPLACE INTO sph_counter VALUES (1, 22);
```
  
## 索引相关语句
添加唯一索引  
//create unique index RequestNoIndex on platform_trade_log (request_no);  
删除唯一索引  
// ALTER TABLE platform_trade_log DROP INDEX RequestNoIndex;  
  
删除索引  
alter table platform_trade_log drop index request_no;  
  
alter table platform_trade_log add index request_no(request_no, result_status);  
  
UPDATE platform_trade_log set platform='yeepay';  
UPDATE diff_log set platform='yeepay';  
  
alter table trade_statistics drop index platform;  
UPDATE trade_statistics set platform='yeepay';  
  
- http://www.10tiao.com/html/283/201704/2650862624/1.html
  
## 修改列｜删除列｜新增列

https://stackoverflow.com/questions/14767174/modify-column-vs-change-column
修改列名用CHANGE
ALTER TABLE MyTable CHANGE COLUMN foo bar VARCHAR(32) NOT NULL FIRST;
除了修改列名，修改限制大小等用MODIFY
ALTER TABLE MyTable MODIFY COLUMN foo VARCHAR(32) NOT NULL AFTER baz comment "修改后的字段注释";

删除列  
ALTER TABLE `trade_log` DROP COLUMN `business_type`;  

添加列
ALTER TABLE vendors　ADD COLUMN phone VARCHAR(15) AFTER name;
  
## 查询2天内的数据
查询时间戳格式  
SELECT * from trade WHERE created_time > UNIX_TIMESTAMP(DATE_SUB(CURDATE(),INTERVAL 2 DAY));  
查询date格式  
SELECT count(1) FROM platform_trade_log where date = DATE_SUB(CURDATE(),INTERVAL 1 DAY);  
  
统计总数和各分组数量  
SELECT coalesce(`level`,'总数') ,COUNT(`id`) '会员数' FROM `user_member` GROUP BY `level`  WITH ROLLUP  
  
MySQL巧用sum,case...when...优化统计查询  
select S.syctime_day,  
   sum(case when S.o_source = 'CDE' then 1 else 0 end) as 'CDE',  
   sum(case when S.o_source = 'SDE' then 1 else 0 end) as 'SDE',  
   sum(case when S.o_source = 'PDE' then 1 else 0 end) as 'PDE',  
   sum(case when S.o_source = 'CSE' then 1 else 0 end) as 'CSE',  
   sum(case when S.o_source = 'SSE' then 1 else 0 end) as 'SSE'  
 from statistic_order S where S.syctime_day > '2015-05-01' and S.syctime_day < '2016-08-01'  
 GROUP BY S.syctime_day order by S.syctime_day asc;  
  
  
：https://www.jianshu.com/p/c19c99a60bb7  
  
- http://jackyrong.iteye.com/blog/2384030 MySQL统计一个列中不同值的数量
## 批量插入测试数据
### 复制 一个存储过程生成1000万条数据的方法
http://www.bcty365.com/content-35-4815-1.html
-- 创建测试的test表
DROP TABLE IF EXISTS test;  
CREATE TABLE test(  
    ID INT(10) NOT NULL,  
    `Name` VARCHAR(20) DEFAULT '' NOT NULL,  
    PRIMARY KEY( ID )  
)ENGINE=INNODB DEFAULT CHARSET utf8;  
  
-- 创建生成测试数据的存储过程
DROP PROCEDURE IF EXISTS pre_test;  
DELIMITER //  
CREATE PROCEDURE pre_test()  
BEGIN  
DECLARE i INT DEFAULT 0;  
SET autocommit = 0;  
WHILE i<10000000 DO  
INSERT INTO test ( ID,`Name` ) VALUES( i, CONCAT( 'Carl', i ) );  
SET i = i+1;  
IF i%2000 = 0 THEN  
COMMIT;  
END IF;  
END WHILE;  
END; //  
DELIMITER ;  
  
-- 执行存储过程生成测试数据
CALL pre_test();  
  
### 插入30天播放量数据
DROP PROCEDURE IF EXISTS pre_test;  
  
DELIMITER //  
  
CREATE PROCEDURE pre_test()  
BEGIN  
DECLARE i INT DEFAULT 1;  
DECLARE totals INT;  
DECLARE mydate DATETIME;  
SET autocommit = 0;  
  
WHILE i< 31 DO  
  
 IF i<10 THEN  
 SET mydate = CONCAT( '2017-10-0', i );  
 END IF;  
 IF i>9 THEN  
 SET mydate = CONCAT( '2017-10-', i );  
 END IF;  
  
INSERT INTO `user_plays_total` (`totals`, `pcs`, `wechats`, `mobiles`, `equipments`, `others`, `created_at`)  
 VALUES (ROUND(RAND()*(1500-1300)+1300), ROUND(RAND()*(90-10)+10), ROUND(RAND()*(900-800)+800), '0',  
ROUND(RAND()*(500-400)+400), '0', mydate);  
  
SET i = i+1;  
  
END WHILE;  
  
COMMIT;  
END; //  
  
DELIMITER ;  
  
-- 执行存储过程生成测试数据
CALL pre_test();  
  
### 插入30用户数据,每日增加100个
DROP PROCEDURE IF EXISTS pre_test;  
  
DELIMITER //  
  
CREATE PROCEDURE pre_test()  
BEGIN  
DECLARE i INT DEFAULT 1;  
DECLARE totals INT;  
DECLARE mydate DATETIME;  
SET autocommit = 0;  
  
WHILE i< 31 DO  
  
 IF i<10 THEN  
 SET mydate = CONCAT( '2017-10-0', i );  
 END IF;  
 IF i>9 THEN  
 SET mydate = CONCAT( '2017-10-', i );  
 END IF;  
  
INSERT INTO `user_total` (`creaters`, `updaters`,`created_at`)  
 VALUES (ROUND(RAND()*(1500-1000)+1000)+100*i, ROUND(RAND()*(5000-4000)+4000)+100*i, mydate);  
  
SET i = i+1;  
  
END WHILE;  
  
COMMIT;  
END; //  
  
DELIMITER ;  
  
-- 执行存储过程生成测试数据
CALL pre_test();  
  
## 统计查询昨天的信息记录
https://yq.aliyun.com/ziliao/65088?spm=5176.8246799.blogcont.24.cLUOtc  
--查询昨天的信息记录：
--注意 修改原来<= 为=
1 select * from `article` where to_days(now()) – to_days(`add_time`) = 1;  
测试  
DB::select('SELECT plays_os,SUM(plays) AS num FROM user_plays  
            WHERE to_days(now()) - to_days(`created_at`) = 1 GROUP BY plays_os');  
## 关于mysql时间类型datetime与timestamp范围
  
datetime类型取值范围：1000-01-01 00:00:00 到 9999-12-31 23:59:59  
  
timestamp类型取值范围：1970-01-01 00:00:00 到 2037-12-31 23:59:59  
  


## 报错 Integrity constraint violation: 1048 Column 'updated_at' cannot be null
修改配置 
debian9.0 percona5.7版本：
/etc/mysql/percona-server.conf.d/mysqld.cnf
explicit_defaults_for_timestamp = false
## 报错 mysql "Plugin '******' is not loaded"
原文链接：https://blog.csdn.net/baidu_35085676/article/details/72180391  
遇到问题  
登录非匿名账户提示’Plugin ‘******’ is not loaded’.  
  
解决办法  
1.开启无密码登录  
修改mysql.cnf 在 [mysqld]下添加skip-grant-tables  
  
2 .sudo service mysqld restart 重启mysql服务.  
3. 现在就可以登录了。登录root账户执行以下语句.  
  
use mysql;  
update user set authentication_string=PASSWORD("") where User='root';  
update user set plugin="mysql_native_password";  
flush privileges;  
quit;  
  
## 报错 Can't connect to local MySQL server through socket
ubuntu 下  
ERROR 2002 (HY000): Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (2)  
解决 systemctl start mysql  
