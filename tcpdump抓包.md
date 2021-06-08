sudo tcpdump -n -S -i eno1 host www.baidu.com tcp port 80

其中 eno1为网卡,一般为eth0


然后 curl www.baidu.com

输出
17:46:45.738590 IP 172.16.2.12.36266 > 14.215.177.39.80: Flags [S], seq 2348404544, win 29200, options [mss 1460,sackOK,TS val 3715398325 ecr 0,nop,wscale 7], length 0
17:46:45.744585 IP 14.215.177.39.80 > 172.16.2.12.36266: Flags [S.], seq 4084711694, ack 2348404545, win 8192, options [mss 1448,sackOK,nop,nop,nop,nop,nop,nop,nop,nop,nop,nop,nop,wscale 5], length 0
17:46:45.744608 IP 172.16.2.12.36266 > 14.215.177.39.80: Flags [.], ack 4084711695, win 229, length 0

17:46:45.744680 IP 172.16.2.12.36266 > 14.215.177.39.80: Flags [P.], seq 2348404545:2348404622, ack 4084711695, win 229, length 77: HTTP: GET / HTTP/1.1
17:46:45.751418 IP 14.215.177.39.80 > 172.16.2.12.36266: Flags [.], ack 2348404622, win 908, length 0
17:46:45.752818 IP 14.215.177.39.80 > 172.16.2.12.36266: Flags [P.], seq 4084711695:4084714476, ack 2348404622, win 908, length 2781: HTTP: HTTP/1.1 200 OK
17:46:45.752824 IP 172.16.2.12.36266 > 14.215.177.39.80: Flags [.], ack 4084714476, win 272, length 0

17:46:45.752941 IP 172.16.2.12.36266 > 14.215.177.39.80: Flags [F.], seq 2348404622, ack 4084714476, win 272, length 0
17:46:45.759491 IP 14.215.177.39.80 > 172.16.2.12.36266: Flags [.], ack 2348404623, win 908, length 0
17:46:45.759523 IP 14.215.177.39.80 > 172.16.2.12.36266: Flags [F.], seq 4084714476, ack 2348404623, win 908, length 0
17:46:45.759546 IP 172.16.2.12.36266 > 14.215.177.39.80: Flags [.], ack 4084714477, win 272, length 0

其中
[S] 代表发送
[.] 代表返回　
[P] 代表数据
[F] 代表结束
win 缓存窗口

三次握手
发送　seq 
返回　seq ack = seq+1
发送　ack = seq+1

四次挥手
发送　seq
返回　ack = seq+1
返回　seq ack = ack
发送　ack = seq+1

