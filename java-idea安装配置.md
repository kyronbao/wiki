
## win10安装1.8.0.271
oracle账号 ky...@qq fl..._AA11
oracle.com下载页面找Java archive->Java SE8(8u211...)
https://www.oracle.com/java/technologies/javase/javase8u211-later-archive-downloads.html
找到jdk-8u271-windows-x64下载
安装到D:/java/

一，配置环境变量步骤
1.右击桌面上的“此电脑”图标，选择属性。

2.选择高级系统设置

3.单击环境变量

4.单击系统变量中的新建

5.在变量名中输入JAVA_HOME

变量值中输入jdk安装路径，系统默认路径为

C:\Program Files\Java\jdk1.8.0_221

6.继续单击系统变量中的新建

7.在变量名中输入CLASSPATH

变量值为

.;%JAVA_HOME%lib;%JAVA_HOME%\lib\tools.jar

注意最前面的“.”不能忽略

8.先选择Path然后点击编辑

9.在编辑环境变量中点击新建

10.将%JAVA_HOME%\bin

%JAVA_HOME%\jre\bin

分别添加进去，然后单击确定按钮。

11.环境变量配置完成，单击确定保存。不点击确定直接退出，配置的环境变量没有保存就不会生效。


二，验证环境变量是否配置成功。
1.按住键盘的windows+R然后输入cmd

2.在命令行窗口分别输入“java”回车,“javac”回车和“java -version”回车出现如下图效果，则环境变量配置成功。可以开始你的java之旅

https://www.jb51.net/article/200295.htm


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

## linux maven安装
在 https://maven.apache.org/download.cgi
wget https://mirrors.gigenet.com/apache/maven/maven-3/3.6.3/binaries/apache-maven-3.6.3-bin.tar.gz

解压到HOME/java
```
vim .bashrc
export MAVEN_HOME=${HOME}/java/apache-maven-3.6.3
export PATH=${PATH}:${MAVEN_HOME}/bin
```
source .bashrc

或
解压到 /opt 目录

vim .bashrc
```
export M2_HOME=/opt/apache-maven-3.6.3
export M2=$M2_HOME/bin
export MAVEN_OPTS=-Xmx512m
export PATH=$M2:$PATH
```
source .bashrc
## win10配置maven
maven包也可以用linux版下载的tar.gz的文件

3.配置环境变量
右键“此电脑->属性->高级系统设置->环境变量”

在系统变量栏下点击新建
变量名：M2_HOME 变量值：C:\Program Files\Apache Software Foundation\apache-maven-3.5.4(该路径为你的Maven安装目录)

然后在系统变量栏下找到Path点击编辑

点击新建，填入%M2_HOME%\bin

4.检查Maven的环境变量是否配置成功
WIN+R打开运行输入cmd打开控制台
输入mvn -v




## 修改Maven仓库地址为国内 
修改远程中央仓库

我们用Maven的时候，因为Maven自带的远程中央仓库在国外，所以经常会很慢。我们可以把远程中央仓库改为国内阿里的远程仓库。
找到你的Maven安装位置，打开conf目录下的setting.xml

将原文件红色方框处改为：

<mirrors>
<mirror>
//该镜像的id
<id>nexus-aliyun</id>
//该镜像用来取代的远程仓库，central是中央仓库的id
<mirrorOf>central</mirrorOf>
<name>Nexus aliyun</name>
//该镜像的仓库地址，这里是用的阿里的仓库
<url>http://maven.aliyun.com/nexus/content/groups/public</url>
</mirror>
</mirrors>

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

## idea设置service,方便查看是否启动了服务
1.点击菜单栏：Views -> Tool Windows -> Services；中文对应：视图 -> 工具窗口 -> 服务
2.刚创建好的窗口是空白的，需要我们把服务加进去。也是比较简单：点击最右侧加号Add Service，选择Run Configuration Type，最后选择SpringBoot，IDEA就会把所有项目加进来了

设置好之后启动debug后看到服务的 端口有了就证明启动成功了
https://blog.csdn.net/csdn_mrsongyang/article/details/108254206

## idea设置
公司文档：将Bean提示错误勾选去掉
 去掉勾选
Editor->Inspections->Spring Core->Code->Autowire for Bean class
## idea插件

easyYapi 生成yapi 文档
  配置token shift+alt+e 生成


MyBatis Log Free

Alibaba Java Coding Guidelines plugin support	阿里JAVA编码检测
GenerateSerialVersionUID	自动生成序列化的ID
Lombok	简化java代码工具
Mybatis-log-plugin	Mybatis日志查看

## idea中maven刷新不了依赖更新? 
设置拉代码时更新maven
刷新代码时更新不了对应snapshot的依赖
设置
  setting->build,Execution,Deployment->Maven->勾选 Always update snapshots
  
  比如依赖的snapshot版本写在properties里时就不能拉依赖下来，写在dependencies里
```
    <properties>
        <sfabric-crm.version>2.1.2.1-SNAPSHOT</sfabric-crm.version>
        <sfabric-mrp-service.version>1.0.1.24-123-SNAPSHOT</sfabric-mrp-service.version>
    </properties>
	
	<dependencies>
	        <dependency>
            <groupId>com.sfabric</groupId>
            <artifactId>mrp-service-api</artifactId>
            <version>${sfabric-mrp-service.version}</version>
        </dependency>
	</dependencies>
```
## idea项目不能run?

  File->project structure->Project  选择sdk

setting
  Bulid,Execution,Deployment
     Maven
	   Importing
	   
  

  
Runner

## 修改本地仓库位置（如果不想修改本地仓库位置则这一步骤可省略）
Maven会将下载的类库（jar包）放置到本地的一个目录下（一般默认情况下Maven在本机的仓库位于C:\Users\你的电脑用户账号\.m2\repository）
创建你要作为本地仓库的文件夹，我所创建文件夹的路径为C:\Program Files\Apache Software Foundation\maven-repository
在setting.xml里找到下图所示

在红方框代码下加上一行代码：<localRepository>C:\Program Files\Apache Software Foundation\maven-repository</localRepository>

检测以上关于仓库地修改是否成功
打开控制台，输入命令mvn help:system
下图代表远程中央仓库修改成功

然后打开本地仓库

如果出现下载文件，即本地仓库位置修改成功


原文链接：https://blog.csdn.net/qq_37904780/article/details/81216179



## 选择java 和spring版本
目前 
java -version
java version "1.8.0_271"

mvn -version
Apache Maven 3.6.3

spring boot 2.2.5
参考
https://zhuanlan.zhihu.com/p/51228073 jdk版本的选择（推荐1.8）
https://www.jianshu.com/p/9aad06d813e8 如何选择Spring Boot最稳定的版本，以及相应的Spring Cloud版本
https://github.com/alibaba/spring-cloud-alibaba/wiki/%E7%89%88%E6%9C%AC%E8%AF%B4%E6%98%8E

## 通过maven创建spring boot
首先创建一个普通的 Maven 项目，以 IntelliJ IDEA 为例，创建步骤如下：

new Project ->Maven

注意这里不用选择项目骨架（如果大伙是做练习的话，也可以去尝试选择一下，这里大概有十来个 Spring Boot 相关的项目骨架），直接点击 Next ，下一步中填入一个 Maven 项目的基本信息，如下图：

com.kyronbao
mbj


然后点击 Next 完成项目的创建。

创建完成后，在 pom.xml 文件中，添加如下依赖：
```
<parent>
    <groupId>org.springframework.boot</groupId>
    <artifactId>spring-boot-starter-parent</artifactId>
    <version>2.1.4.RELEASE</version>
</parent>
<dependencies>
    <dependency>
        <groupId>org.springframework.boot</groupId>
        <artifactId>spring-boot-starter-web</artifactId>
    </dependency>
</dependencies>
```
添加成功后，再在 java 目录下创建包，包中创建一个名为 App 的启动类，如下：
```
@EnableAutoConfiguration
@RestController
public class App {
    public static void main(String[] args) {
        SpringApplication.run(App.class, args);
    }
    @GetMapping("/hello")
    public String hello() {
        return "hello";
    }
}
```

@EnableAutoConfiguration 注解表示开启自动化配置。

然后执行这里的 main 方法就可以启动一个 Spring Boot 工程了。


这样创建的spring boot直接在idea里可以启动了

https://www.cnblogs.com/lenve/p/10694456.html
