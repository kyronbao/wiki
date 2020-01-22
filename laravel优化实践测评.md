  
 ab -c100 -n1000 http://laratice.cc/post/1  
```

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

Document Path:          /post/1
Document Length:        201 bytes

Concurrency Level:      100
Time taken for tests:   5.042 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      1164012 bytes
HTML transferred:       201000 bytes
Requests per second:    198.34 [#/sec] (mean)
Time per request:       504.190 [ms] (mean)
Time per request:       5.042 [ms] (mean, across all concurrent requests)
Transfer rate:          225.46 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.6      0       3
Processing:    14  479  87.2    496     623
Waiting:       14  479  87.2    496     623
Total:         17  479  86.7    496     623

Percentage of the requests served within a certain time (ms)
  50%    496
  66%    507
  75%    513
  80%    517
  90%    538
  95%    562
  98%    574
  99%    581
 100%    623 (longest request)
