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


export MAVEN_HOME=${HOME}/java/apache-maven-3.6.3
export PATH=${PATH}:${MAVEN_HOME}/bin
## ubuntu16.04 java安装 
- https://www.digitalocean.com/community/tutorials/how-to-install-java-with-apt-get-on-ubuntu-16-04

```
Introduction
Java and the JVM (Java’s virtual machine) are widely used and required for many kinds of software. This article will guide you through the process of installing and managing different versions of Java using apt-get.

Prerequisites
To follow this tutorial, you will need:

One Ubuntu 16.04 server.

A sudo non-root user, which you can set up by following the Ubuntu 16.04 initial server setup guide.

Installing the Default JRE/JDK
The easiest option for installing Java is using the version packaged with Ubuntu. Specifically, this will install OpenJDK 8, the latest and recommended version.

First, update the package index.

sudo apt-get update

Next, install Java. Specifically, this command will install the Java Runtime Environment (JRE).

sudo apt-get install default-jre

There is another default Java installation called the JDK (Java Development Kit). The JDK is usually only needed if you are going to compile Java programs or if the software that will use Java specifically requires it.

The JDK does contain the JRE, so there are no disadvantages if you install the JDK instead of the JRE, except for the larger file size.

You can install the JDK with the following command:

sudo apt-get install default-jdk

Installing the Oracle JDK
If you want to install the Oracle JDK, which is the official version distributed by Oracle, you will need to follow a few more steps.

First, add Oracle’s PPA, then update your package repository.

sudo add-apt-repository ppa:webupd8team/java
sudo apt-get update

Then, depending on the version you want to install, execute one of the following commands:

Oracle JDK 8
This is the latest stable version of Java at time of writing, and the recommended version to install. You can do so using the following command:

sudo apt-get install oracle-java8-installer

Oracle JDK 9
This is a developer preview and the general release is scheduled for March 2017. It’s not recommended that you use this version because there may still be security issues and bugs. There is more information about Java 9 on the official JDK 9 website.

To install JDK 9, use the following command:

sudo apt-get install oracle-java9-installer

Managing Java
There can be multiple Java installations on one server. You can configure which version is the default for use in the command line by using update-alternatives, which manages which symbolic links are used for different commands.

sudo update-alternatives --config java

The output will look something like the following. In this case, this is what the output will look like with all Java versions mentioned above installed.

Output
There are 5 choices for the alternative java (providing /usr/bin/java).

  Selection    Path                                            Priority   Status
------------------------------------------------------------
* 0            /usr/lib/jvm/java-8-openjdk-amd64/jre/bin/java   1081      auto mode
  1            /usr/lib/jvm/java-6-oracle/jre/bin/java          1         manual mode
  2            /usr/lib/jvm/java-7-oracle/jre/bin/java          2         manual mode
  3            /usr/lib/jvm/java-8-openjdk-amd64/jre/bin/java   1081      manual mode
  4            /usr/lib/jvm/java-8-oracle/jre/bin/java          3         manual mode
  5            /usr/lib/jvm/java-9-oracle/bin/java              4         manual mode

Press <enter> to keep the current choice[*], or type selection number:
You can now choose the number to use as a default. This can also be done for other Java commands, such as the compiler (javac), the documentation generator (javadoc), the JAR signing tool (jarsigner), and more. You can use the following command, filling in the command you want to customize.

sudo update-alternatives --config command

Setting the JAVA_HOME Environment Variable
Many programs, such as Java servers, use the JAVA_HOME environment variable to determine the Java installation location. To set this environment variable, we will first need to find out where Java is installed. You can do this by executing the same command as in the previous section:

sudo update-alternatives --config java

Copy the path from your preferred installation and then open /etc/environment using nano or your favorite text editor.

sudo nano /etc/environment

At the end of this file, add the following line, making sure to replace the highlighted path with your own copied path.

/etc/environment
JAVA_HOME="/usr/lib/jvm/java-8-oracle"
Save and exit the file, and reload it.

source /etc/environment

You can now test whether the environment variable has been set by executing the following command:

echo $JAVA_HOME

This will return the path you just set.

Conclusion
You have now installed Java and know how to manage different versions of it. You can now install software which runs on Java, such as Tomcat, Jetty, Glassfish, Cassandra, or Jenkins.
```

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
    Build,Execution,Deployment/Build Tools/Maven
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
