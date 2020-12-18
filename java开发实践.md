## kafka　使用
zookeeper 
https://zhuanlan.zhihu.com/p/69114539 为什么需要 Zookeeper

https://blog.csdn.net/u010889616/article/details/80641922 ubuntu18.04下Kafka安装与部署

bin/zkServer.sh start

https://www.digitalocean.com/community/tutorials/how-to-install-apache-kafka-on-ubuntu-18-04

First, create a topic named TutorialTopic by typing:

bin/kafka-topics.sh --create --zookeeper localhost:2181 --replication-factor 1 --partitions 1 --topic TutorialTopic
 
You can create a producer from the command line using the kafka-console-producer.sh script. It expects the Kafka server’s hostname, port, and a topic name as arguments.

Publish the string "Hello, World" to the TutorialTopic topic by typing:

echo "Hello, World" | bin/kafka-console-producer.sh --broker-list localhost:9092 --topic TutorialTopic > /dev/null
 
Next, you can create a Kafka consumer using the kafka-console-consumer.sh script. It expects the ZooKeeper server’s hostname and port, along with a topic name as arguments.

The following command consumes messages from TutorialTopic. Note the use of the  --from-beginning flag, which allows the consumption of messages that were published before the consumer was started:

bin/kafka-console-consumer.sh --bootstrap-server localhost:9092 --topic TutorialTopic --from-beginning


启动
sudo bin/kafka-server-start.sh config/server.properties
