环境  
Ubuntu16.04  
i5  
4核  
  
yaf  
```
ab -n 1000 -c 100 http://yaf-api.cc/

This is ApacheBench, Version 2.3 <$Revision: 1706008 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking yaf-api.cc (be patient)
Completed 100 requests
Completed 200 requests
Completed 300 requests
Completed 400 requests
Completed 500 requests
Completed 600 requests
Completed 700 requests
Completed 800 requests
Completed 900 requests
Completed 1000 requests
Finished 1000 requests


Server Software:        nginx/1.10.3
Server Hostname:        yaf-api.cc
Server Port:            80

Document Path:          /
Document Length:        26 bytes

Concurrency Level:      100
Time taken for tests:   0.148 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      172000 bytes
HTML transferred:       26000 bytes
Requests per second:    6777.41 [#/sec] (mean)
Time per request:       14.755 [ms] (mean)
Time per request:       0.148 [ms] (mean, across all concurrent requests)
Transfer rate:          1138.39 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.7      0       3
Processing:     1   14   2.1     14      18
Waiting:        1   14   2.1     14      18
Total:          4   14   1.7     14      19

Percentage of the requests served within a certain time (ms)
  50%     14
  66%     15
  75%     15
  80%     15
  90%     16
  95%     16
  98%     17
  99%     18
 100%     19 (longest request)
```
  
Laravel5.1  
已关闭debug  
已优化如下操作:  
```
php artisan route:cache
php artisan config:cache
php artisan optimize
```
  
```
ab -n 1000 -c 100 http://laratice.cc/

This is ApacheBench, Version 2.3 <$Revision: 1706008 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking laratice.cc (be patient)
Completed 100 requests
Completed 200 requests
Completed 300 requests
Completed 400 requests
Completed 500 requests
Completed 600 requests
Completed 700 requests
Completed 800 requests
Completed 900 requests
Completed 1000 requests
Finished 1000 requests


Server Software:        nginx/1.10.3
Server Hostname:        laratice.cc
Server Port:            80

Document Path:          /
Document Length:        1023 bytes

Concurrency Level:      100
Time taken for tests:   4.741 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      1986172 bytes
HTML transferred:       1023000 bytes
Requests per second:    210.93 [#/sec] (mean)
Time per request:       474.099 [ms] (mean)
Time per request:       4.741 [ms] (mean, across all concurrent requests)
Transfer rate:          409.12 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.0      0       5
Processing:   207  454  79.7    440     810
Waiting:      207  454  79.7    440     810
Total:        211  455  79.8    440     812

Percentage of the requests served within a certain time (ms)
  50%    440
  66%    455
  75%    465
  80%    471
  90%    569
  95%    635
  98%    736
  99%    772
 100%    812 (longest request)

