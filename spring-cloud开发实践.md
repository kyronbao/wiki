

 
 依赖选择
　　Lombok
   
 https://blog.csdn.net/weixin_44364444/article/details/105045684
 基本控制器和pojo(Plain OrdinaryJava Object)的使用
 
 配置文件改为yml
  https://www.cnblogs.com/baoyi/p/SpringBoot_YML.html
  把application.properties改为application.yml
  比如配置文件中添加如下可以修改应用的端口
  server:
    port: 8080
 

多模块搭建教程　https://www.hangge.com/blog/cache/detail_2834.html
## 资料
 http://c.biancheng.net/spring_cloud/ 教程

同时发现又一spring_cloud教程　https://www.hangge.com/blog/cache/category_80_14.html
这个更加详细 

## idea设置
maven不显示时－>右击pom.xml,添加maven
添加依赖-->在pom.xml添加相应的配置后，点击maven的刷新，等会可以看到maven下相应的依赖也更新了

## 创建项目
版本选择
：公司项目spring cloud使用Hoxton版，
 查看https://spring.io/projects/spring-cloud#overview　 页面的依赖得知
 选择spring boot版本　2.3.10
    java版本8
　依赖选择　Spring Web
	
注意：建议使用 https://start.spring.io/ 来生成项目（如果用idea来生成，无法控制spring boot的版本）

除了使用idea启动和打包项目，也可以用命令行

启动项目
mvn spring-boot:run

打包启动
mvn package

打包完后，可以运行
nohup java -jar demo-0.0.1-SNAPSHOT.jar &
 &　表示后台运行
 nohup 表示当窗口关闭时服务不挂起，继续在后台运行。



