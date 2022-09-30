## kafka　安装
### zookeeper 因为linux版本下载的自带zookeeper,所以这里跳过
下载zookeeper
https://zookeeper.apache.org/releases.html
解压到/opt
4.2 启动
在Windows环境下，直接双击zkServer.cmd即可。在Linux环境下，进入bin目录，执行命令
cd /opt/apache-zookeeper-3.6.2-bin/bin

sudo ./zkServer.sh start

这个命令使得zk服务进程在后台进行。如果想在前台中运行以便查看服务器进程的输出日志，可以通过以下命令运行：

./zkServer.sh start-foreground

执行此命令，可以看到大量详细信息的输出，以便允许查看服务器发生了什么。

使用文本编辑器打开zkServer.cmd或者zkServer.sh文件，可以看到其会调用zkEnv.cmd或者zkEnv.sh脚本。zkEnv脚本的作用是设置zk运行的一些环境变量，例如配置文件的位置和名称等。

4.3 连接
如果是连接同一台主机上的zk进程，那么直接运行bin/目录下的zkCli.cmd（Windows环境下）或者zkCli.sh（Linux环境下），即可连接上zk。
sudo ./zkCli.sh

直接执行zkCli.cmd或者zkCli.sh命令默认以主机号 127.0.0.1，端口号 2181 来连接zk，如果要连接不同机器上的zk，可以使用 -server 参数，例如：
bin/zkCli.sh -server 192.168.0.1:2181

### kafka
下载kafka
https://kafka.apache.org/downloads
解压到/opt
cd /opt/kafka_2.13-2.6.0
进入kafka解压目录，修改kafka-server 的配置文件

vim config/server.properties
修改配置文件中21、31、36和60行

broker.id=1
listeners=PLAINTEXT://172.16.2.26:9092  # 注意这里必须要写这种局域网内域名,不然虚拟机里offset Exploer客户端连接不了
#advertised.listeners=PLAINTEXT://host_ip:9092  #这一行可以不用改
log.dirs=/tmp/kafka-logs/1   #注意日志要修改,在配置多个服务器的时候

注意:测试时最好也创建3个server,因为改成一个时消费者会收不到数据了



四、功能验证
1、启动Zookeeper，Zookeeper部署的是单点的。

su

bin/zookeeper-server-start.sh -daemon config/zookeeper.properties
关闭
bin/zookeeper-server-stop.sh -daemon config/zookeeper.properties

2、启动Kafka服务，使用 kafka-server-start.sh 启动 kafka 服务
bin/kafka-server-start.sh config/server.properties
3、创建topic

 注意以下localhost如果在配置文件配置了ip格式,这里也要用ip格式

使用 kafka-topics.sh 创建单分区单副本的 topic test

bin/kafka-topics.sh --create --zookeeper localhost:2181 --replication-factor 1 --partitions 1 --topic test

查看 topic 列表

bin/kafka-topics.sh --list --zookeeper localhost:2181
4、产生消息，创建消息生产者

bin/kafka-console-producer.sh --broker-list localhost:9092 --topic test
bin/kafka-console-producer.sh --broker-list 172.16.2.26:9092 --topic test
5、消费消息，创建消息消费者


bin/kafka-console-consumer.sh --bootstrap-server localhost:9092 --topic test --from-beginning
bin/kafka-console-consumer.sh --bootstrap-server 172.16.2.26:9092 --topic test --from-beginning


单机多broker 集群配置
利用单节点部署多个 broker。 不同的 broker 设置不同的 id，监听端口及日志目录。 例如：

cp config/server.properties config/server-2.properties

cp config/server.properties config/server-3.properties

vim config/server-2.properties

vim config/server-3.properties
修改 ：

broker.id=2

listeners = PLAINTEXT://your.host.name:9093

log.dir=/tmp/kafka/2
和

broker.id=3

listeners = PLAINTEXT://your.host.name:9094

log.dir=/tmp/kafka/3
启动Kafka服务：

sudo bin/kafka-server-start.sh config/server-2.properties

sudo bin/kafka-server-start.sh config/server-3.properties


多机多 broker 集群配置
分别在多个节点按上述方式安装 Kafka，配置启动多个 Zookeeper 实例。

假设三台机器 IP 地址是 ： 192.168.153.135， 192.168.153.136， 192.168.153.137

分别配置多个机器上的 Kafka 服务，设置不同的 broker id，zookeeper.connect 设置如下:

vim config/server.properties
里面的 zookeeper.connect

修改为：

zookeeper.connect=192.168.153.135:2181,192.168.153.136:2181,192.168.153.137:2181

检查配置情况
在另一个窗口,不使用sudo命令
ps aux | grep kafka


### 其他命令参考

创建topic
First, create a topic named TutorialTopic by typing:

bin/kafka-topics.sh --create --zookeeper localhost:2181 --replication-factor 1 --partitions 1 --topic TutorialTopic
创建生产者并发送消息
 
You can create a producer from the command line using the kafka-console-producer.sh script. It expects the Kafka server’s hostname, port, and a topic name as arguments.

Publish the string "Hello, World" to the TutorialTopic topic by typing:

echo "Hello, World" | bin/kafka-console-producer.sh --broker-list localhost:9092 --topic TutorialTopic > /dev/null
创建消费者接受消息
 
Next, you can create a Kafka consumer using the kafka-console-consumer.sh script. It expects the ZooKeeper server’s hostname and port, along with a topic name as arguments.

The following command consumes messages from TutorialTopic. Note the use of the  --from-beginning flag, which allows the consumption of messages that were published before the consumer was started:

bin/kafka-console-consumer.sh --bootstrap-server localhost:9092 --topic TutorialTopic --from-beginning

### 参考
https://segmentfault.com/a/1190000012730949  主要参考
https://www.w3cschool.cn/apache_kafka/apache_kafka_basic_operations.html 教程

 https://zhuanlan.zhihu.com/p/69114539 为什么需要 Zookeeper

https://blog.csdn.net/u010889616/article/details/80641922 ubuntu18.04下Kafka安装与部署(后面有些命令不准确，参考下面的链接的内容实践)



https://www.digitalocean.com/community/tutorials/how-to-install-apache-kafka-on-ubuntu-18-04
## 配置时bug记录
启动kafka服务2时
[2022-09-29 15:21:48,275] INFO shutting down (kafka.server.KafkaServer)
[1]+  已杀死               sudo bin/kafka-server-start.sh config/server-2.properties

--->修改配置文件端口号

Configured broker.id 2 doesn't match stored broker.id 1 in meta.properties. If you moved your data, make sure your configured broker.id matches. If you intend to create a new broker, you should remove all data in your data directories (log.dirs).
	at kafka.server.KafkaServer.getOrGenerateBrokerId(KafkaServer.scala:808)
	at kafka.server.KafkaServer.startup(KafkaServer.scala:238)
	at kafka.server.KafkaServerStartable.startup(KafkaServerStartable.scala:44)
	at kafka.Kafka$.main(Kafka.scala:82)
	at kafka.Kafka.main(Kafka.scala)
https://www.cnblogs.com/gudi/p/7847100.html log.dirs目录下的meta.properties中配置的broker.id和配置目录下的server.properties中的broker.id不一致了，解决问题的方法是将两者修改一致后再重启
--->删除日志文件夹 /tmp/kafka  server2 3用不同的文件夹

## 客户端offset Explorer设置和使用
https://www.cnblogs.com/frankdeng/p/9452982.html
连接kafka 可以不用设置 zookeeper host
just set 

填写
Cluster name

Advanced -->Bootstraps servers
172.16.1.132:9092,172.16.1.133:9092,172.16.1.134:9092

Done

查看topic数据乱码?
点击topic名字->Properties->Content Types->String String

参考

