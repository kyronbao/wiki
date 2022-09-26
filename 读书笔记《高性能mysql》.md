* 安装  
ubuntu wiki  
http://wiki.ubuntu.org.cn/MySQL%E5%AE%89%E8%A3%85%E6%8C%87%E5%8D%97  
  
root改密码  
GRANT ALL PRIVILEGES ON *.* TO root@localhost IDENTIFIED BY "root"  
创建arpher拥有db库  
create database db;  
GRANT ALL PRIVILEGES ON db.* TO arpher@localhost IDENTIFIED BY "2";  
  
* 3 服务器性能解析  
网站性能分析  
ab  
http_load 工具  
  
数据库测试  
sysbench  
  
tpcc-mysql  
安装  
```
sudo apt-get install libmysqlclient-dev--否则会出现‘/bin/sh: 1: mysql_config: not found  ’错误
sudo git clone https://github.com/Percona-Lab/tpcc-mysql.git
cd tpcc...
cd src
```
make  
   参考http://www.voidcn.com/blog/john1337/article/p-6575442.html  
3.1  
性能用查询的响应时间来度量  
1 优化就是在一定的工作负载下降低响应时间  每秒查询量是吞吐量，是性能优化的副产品  
2 无法测量就无法有效的优化  
  
3.1  
好用的服务器监控软件New Relic  
PHP监控软件xhprof  facebook开发的，2009年开源  
  
PHP性能剖析工具，自己开发的ifP 更关注数据库的调用  
  
* 4 Schema与数据类型优化  
简单的数据类型 就好  
尽量NOT NULL 索引列尤其  
  
4.3.3 最常见的反范式化数据的方法是复制或者缓存，在不同的表中存储相同的列。  
可以使用触发器更新缓存列  
  
缓存表  
计算24小时内发送的消息数，可以每小时生成一张汇总表  
  
精确计算时，23小时+余的  
LEFT(NOW(), 14) 最近的一小时  
INTERVAL 23 HOUR 系统23小时时长  
  
见P215  
  
4.4.2 计数器表  
  
  
ON DUPLICATE KEY UPDATE   原理：在确定主键值已经存在后，会进行update修改操作  
http://blog.csdn.net/cdy102688/article/details/16829213  
  
Mysql 多表联合查询效率分析及优化  
1. on a.c1 = b.c1 等同于 using(c1)  
2. INNER JOIN 和 , (逗号) 在语义上是等同的  
3. 当 MySQL 在从一个表中检索信息时，你可以提示它选择了哪一个索引。  
如果 EXPLAIN 显示 MySQL 使用了可能的索引列表中错误的索引，这个特性将是很有用的。  
通过指定 USE INDEX (key_list)，你可以告诉 MySQL 使用可能的索引中最合适的一个索引在表中查找记录行。  
可选的二选一句法 IGNORE INDEX (key_list) 可被用于告诉 MySQL 不使用特定的索引。  
http://blog.csdn.net/hguisu/article/details/5731880  
  
  
4.5  
修改表ALTER TABLE的方法  
  
 修改列默认值快的方法  
mysql>ALTER TABLE sakila.film  
ALTER COLUMN rental_duration SET DEFAULT 5;  
  
* 5 索引  
5.2 推荐的索引的书 Relational Database Index Design and the Optimizers, by Tapio Lahdenmaki and Mike Leach (Wiley)  
  
mysql 子查询  
IS NULL 判断空值 IS NOT NULL判断非空值  
列子查询中使用 IN、ANY、SOME 和 ALL 操作符 http://www.5idev.com/p-mysql_volumn_subquery.shtml  
MySQL UNION 与 UNION ALL 语法与用法 http://www.5idev.com/p-mysql_union.shtml  
 MySQL 子查询 EXISTS 和 NOT EXISTS http://www.5idev.com/p-mysql_exists_subquery.shtml  
  
mysql函数  
DISTINCT 用于返回唯一不同的值  
SELECT DISTINCT Company FROM Orders http://www.w3school.com.cn/sql/sql_distinct.asp  
  
sakila 示例库安装  
```
sudo wget http://downloads.mysql.com/docs/sakila-db.tar.gz
cd saki..
```
mysql -u root -p < sakila-schema.sql  
mysql -u root -p < sakila-data.sql  
  
5.3.4 选择合适的索引列顺序  
正确的顺序依赖与索引的查询,同时考虑更好的满足排序和分组的需要  
  
5.3.8  
压缩索引使MyISAM适合I/O密集型应用  
5.3.9  
在一个字段 设置主键、惟一键、索引（KEY）是重复索引，要避免，不同索引不算重复索引  
冗余索引  
  
* 6 查询优化  
6.2 EXPLAIN + 语句  
查看type类型   rows扫描的行数  
6.3  
6.7 优化特定类型的查询  
最好使用count(*)  
MyISAM的count(*)在没有where时非常快，直接获取  
当前活跃数 30分钟缓冲  
memcached 汇总表  
快速，精确，实现简单往往只能满足2个  
5 优化分页 延迟查询  
mysql>SELECT film.film_id, film.description  
FROM sakila.film  
INNER JOIN (  
SELECT film_id FROM sakila.film  
ORDER BY title LIMIT 50, 5  
) AS lim USING(film_id);  
  
工具安装 sudo apt install percona-tookit  
  
热数据 冷数据  
6.8 案例学习  
  
书籍推荐 Bill Karwin 的 SQL antipatterns  
