## 时间查询
```
created_time >= date_format(now(),'%Y-%m-%d 00:00:00')
```
##  新增或更新 ON DUPLICATE KEY UPDATE
在MySQL数据库中，如果在insert语句后面带上ON DUPLICATE KEY UPDATE 子句，而要插入的行与表中现有记录的惟一索引或主键中产生重复值，那么就会发生旧行的更新；如果插入的行数据与现有表中记录的唯一索引或者主键不重复，则执行新纪录插入操作。

说通俗点就是数据库中存在某个记录时，执行这个语句会更新，而不存在这条记录时，就会插入。
```
INSERT INTO table (a,b,c) VALUES (1,2,3)  
  ON DUPLICATE KEY UPDATE c=c+1;  
  
UPDATE table SET c=c+1 WHERE a=1;
```
https://www.cnblogs.com/better-farther-world2099/articles/11737376.html
## mysql where in 子查询优化为inner join时会重复
https://www.jianshu.com/p/3989222f7084
where in改为inner join时,
如果主查询是主表,会查出重复数据
SELECT * FROM t1 WHERE t1.a IN (SELECT t2.a FROM t2 WHERE a < 10);
SELECT t1.* FROM t1 right join t2 on t1.a=t2.a where t2.a<10;
如果主查询是不是主表,不会查出重复数据
SELECT * FROM t2 WHERE t2.a IN (SELECT t1.a FROM t1 WHERE a < 10);
SELECT t2.* FROM t2 inner join t1 on t1.a=t2.a where t1.a<10;
## 设置自增id
alter table knit_bd_fabrications AUTO_INCREMENT=100000001;
## group having
### 查看分组内的数量
SELECT company_type,count(*) FROM knit_auth_user group by company_type;
## left join right join
https://blog.csdn.net/Knight_Key/article/details/106004550

## 慢查询
MySQL慢查询日志　https://cloud.tencent.com/developer/article/1702927

## 查看数据库中占用空间多的表
```
use information_schema;
select table_name,table_rows from  tables  where table_schema='db_knit_erp'  order by table_rows desc limit 20;
```
## 表字段不同时联合查询 union all  where

SELECT author,book_name FROM book_test where book_name like '%大东%'
union all
SELECT author,book_name FROM t_book where book_name like '%大东%';


select * from (
SELECT author,book_name FROM book_test
union all
SELECT author,book_name FROM t_book 
) t
where t.book_name like '%大东%';
;
以上两个sql查询结果相同

参考
https://segmentfault.com/a/1190000007926959 MySQL必知必会：组合查询Union）union all
https://blog.csdn.net/u010173095/article/details/78436979 union all  where用法
## 一条语句修改多种条件对应的值 update case when 
update proforma_invoice_details set transport_goods_tolerance_unit = 
case
when transport_goods_tolerance_unit = 'LB' then '磅'
when transport_goods_tolerance_unit = 'KG' then '千克'
when transport_goods_tolerance_unit = 'P' then '条'
when transport_goods_tolerance_unit = 'M' then '米'
when transport_goods_tolerance_unit = 'Y' then '码'
when transport_goods_tolerance_unit = 'T' then '吨'
else transport_goods_tolerance_unit
 end
where created_at > '2021-12-01 00:00:00' and id!=0 and transport_goods_tolerance_unit != '';

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
replace into 跟 insert 功能类似，不同点在于：replace into 首先尝试插入数据到表中， 1. 如果发现表中已经有此行数据（根据主键或者唯一索引判断）则先删除此行数据，然后插入新的数据。 2. 否则，直接插入新数据。
replace into tbl_name(col_name, ...) values(...)

 https://www.cnblogs.com/c-961900940/p/6197878.html

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
  
  

  
## 索引相关语句
添加唯一索引  
//create unique index RequestNoIndex on platform_trade_log (request_no);  
删除唯一索引  
// ALTER TABLE platform_trade_log DROP INDEX RequestNoIndex;  
  
删除索引  
alter table platform_trade_log drop index request_no;  



  
- http://www.10tiao.com/html/283/201704/2650862624/1.html

1.2 在已建表中添加索引
① 普通索引

create index index_name
             on t_dept(name);
 

② 唯一索引

create unique index index_name
              on t_dept(name);
 

③ 全文索引

create fulltext index index_name
              on t_dept(name);
 

④ 多列索引

create index index_name_no
               on t_dept(name,no)

https://www.cnblogs.com/bruce1992/p/13958166.html  
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
