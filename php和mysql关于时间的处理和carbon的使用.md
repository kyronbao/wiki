  
首先是Mysql的时间格式有datetime，timestamp，该怎么选择  
  
- [怎么选择datetime timestap](https://stackoverflow.com/questions/409286/should-i-use-the-datetime-or-timestamp-data-type-in-mysql)
- [怎么创建mysql datatime字段](https://stackoverflow.com/questions/168736/how-do-you-set-a-default-value-for-a-mysql-datetime-column)
  
- [Mysql时间字段格式如何选择，TIMESTAMP，DATETIME，INT？](https://segmentfault.com/q/1010000000121702)
  
总结来说，  
一般created_at,updated_at使用timestamp，  
初始值使用CURRENT_TIME  
  
carbon  
- https://9iphp.com/web/laravel/php-datetime-package-carbon.html
创建时间  
$bbbb = \Carbon\Carbon::createFromDate(2018, 12, 25);  
$bbbb = \Carbon\Carbon::yesterday();  
$bbbb = \Carbon\Carbon::now();  
  
一天的开始时间 结束时间  
$this->yesterday = Carbon::yesterday();  
$this->startOfDay = $this->yesterday->startOfDay()->toDateTimeString();  
$this->endOfDay = $this->yesterday->endOfDay()->toDateTimeString();  
时间戳  
$this->yesterday->startOfDay()->timestamp  
日期格式  
$this->yesterday->format("Y-m-d")  
  
  
date()  
昨天  
date('Y-m-d', strtotime('-1 days'));  
date('Ym', strtotime($date));  
  
打印时间戳  
```
