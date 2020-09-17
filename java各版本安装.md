
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
