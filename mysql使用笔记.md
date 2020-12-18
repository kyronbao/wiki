## mysql 紧急停止
ubuntu下 /etc/init.d/mysql stop  
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
### 导入导出
导入  
mysql -uroot -p laravel < laravel.sql  


mysql> CREATE DATABASE IF NOT EXISTS db1;
mysql> USE db1;
mysql> source dump.sql
导出  
导出数据库  
mysqldump -h127.0.0.1 -uroot -P3306 -p laravel > laravel.sql  
导出数据库的表  
mysqldump -uroot -p laravel users > laravel_users.sql  


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
  
## 修改列
删除列  
ALTER TABLE `trade_log`  
DROP COLUMN `business_type`;  
  
ALTER TABLE `trade_log`  
DROP COLUMN `business_type`,  
CHANGE COLUMN `business_flag` `business_type`  varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '业务类型(合同打款,邀请提现,会员购买,还款计划还款,还款计划退款)' AFTER `master_business_no`;  
  
  
ALTER TABLE `trade_log`  
MODIFY COLUMN `business_flag`  varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '业务标识(合同打款,邀请提现,会员购买,还款计划还款,还款计划退款)' AFTER `master_business_no`,  
MODIFY COLUMN `business_type`  varchar(100) NOT NULL COMMENT '业务种类(会员费支付,会员费退款,平台出款,支付回款,代扣回款,现金提现)' AFTER `business_flag`;  
  
  
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
