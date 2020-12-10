## debian9/deepin15.11 安装默认java版本

在本机测试
java -version
提示
openjdk version "1.8.0_181"
OpenJDK Runtime Environment (build 1.8.0_181-8u181-b13-2~deb9u1-b13)
OpenJDK 64-Bit Server VM (build 25.181-b13, mixed mode)
说明java已安装

测试
javac -version
提示未安装，原因是未安装 jdk版

安装步骤
sudo apt update
sudo apt install default-jre
sudo apt install default-jdk


然后测试 
javac -version 

javac 1.8.0_181
安装成功

## debian9/deepin15.11 安装 spring boot 推荐的AdoptOpenJDK 11 

Debian/Ubuntu 用户
首先信任 GPG 公钥:

wget -qO - https://adoptopenjdk.jfrog.io/adoptopenjdk/api/gpg/key/public | sudo apt-key add -
再选择你的 Debian/Ubuntu 版本，文本框中内容写进 /etc/apt/sources.list.d/AdoptOpenJDK.list

你的Debian/Ubuntu版本:debian9
deb http://mirrors.tuna.tsinghua.edu.cn/AdoptOpenJDK/deb stretch main
再执行

sudo apt-get update
sudo apt install adoptopenjdk-11-hotspot

3. Check java Version
java -version
javac -version

4. Set Java Home Environment
We need to set Java Home Environment Variable in order to use java with some applications. Let’s get started.

$ sudo update-alternatives --config java
There is only one alternative in link group java (providing /usr/bin/java): /usr/lib/jvm/java-8-openjdk-amd64/jre/bin/java
Nothing to configure.

$ vim ~/.bashrc

and paste the following and save and quit.

$ export JAVA_HOME=/usr/lib/jvm/adoptopenjdk-11-hotspot-amd64/bin/java

Now source the file.

$ source ~/.bashrc

Now check the Java Home

$ echo $JAVA_HOME


参考 
https://spring.io/quickstart
https://mirrors.tuna.tsinghua.edu.cn/help/adoptopenjdk/
https://installvirtual.com/install-java-8-on-debian-10-buster/
## debian9/deepin15.11 安装java version "1.8.0_271"
配置.bashrc

export JAVA_HOME=/opt/jdk1.8.0_271  
export JRE_HOME=${JAVA_HOME}/jre  
export CLASSPATH=.:${JAVA_HOME}/lib:${JRE_HOME}/lib  
export PATH=${JAVA_HOME}/bin:$PATH

## maven安装
在 https://maven.apache.org/download.cgi
wget https://mirrors.gigenet.com/apache/maven/maven-3/3.6.3/binaries/apache-maven-3.6.3-bin.tar.gz

解压到 /opt 目录

vim .bashrc

export M2_HOME=/opt/apache-maven-3.6.3
export M2=$M2_HOME/bin
export MAVEN_OPTS=-Xmx512m
export PATH=$M2:$PATH

source .bashrc
## idea配置maven国内源
  第一步：找到idea中maven中的“settings.xml”位置
  一般在idea安装目录下的
  “D:\IntelliJ IDEA 2017.2.5\plugins\maven\lib\maven3\conf”（参照左面地址）
  本地是
sudo vim /opt/idea-IU-193.7288.26/plugins/maven/lib/maven3/conf/settings.xml
  第二步：找到“<mirrors>”标签
  在“<mirrors>”标签下加下面语句：
  
<mirror>
<id>nexus-aliyun</id>
<mirrorOf>central</mirrorOf>
<name>Nexus aliyun</name>
<url>http://maven.aliyun.com/nexus/content/groups/public</url>
</mirror>

测试
mvn -version

然后点击maven工具那边的刷新按钮，就可以安装依赖到 ~/.m2/ 目录下了
