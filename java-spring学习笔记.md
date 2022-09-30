## 文档doc

https://spring.io/projects/spring-framework#learn   -> Reference Doc.

浏览器地址删到doc
https://docs.spring.io/spring-boot/docs
https://docs.spring.io/spring-framework/docs/

## 怎么微服务查看pom.xml里各依赖的版本号
点击引用关系(向上)
## 初始化多个listMap

You can then populate the list in a for loop :

for(int i=0;i<10;++i) {
    lists.put("list"+(i+1),new ArrayList<Model>());
}
You can access the lists using :

  lists.get("list1").add(new Model(...));
  lists.get("list2").add(new Model(...));
  
https://stackoverflow.com/questions/30097102/initializing-multiple-lists-in-java-simultaneously
## 添加元素到HashMap的ArrayList
Map<String, List<Item>> items = new HashMap<>();
items.computeIfAbsent(key, k -> new ArrayList<>()).add(item);
https://stackoverflow.com/questions/12134687/how-to-add-element-into-arraylist-in-hashmap
## 公司学习文档
1、JAVA基础知识系统学习
https://github.com/CyC2018/CS-Notes
主要看java部分，系统的介绍java语言；主要包括了Java基础、Java容器、Java并发、Java虚拟机、Java I/O
留意附件哦

2、spring boot学习
https://github.com/ityouknow/spring-boot-examples
以最简单、最实用为标准，此开源项目中的每个示例都以最小依赖，最简单为标准，帮助初学者快速掌握 Spring Boot 各组件的使用

3、微服务学习
https://www.cnblogs.com/xifengxiaoma/p/9474953.html

个人建议：
微服务学习可以马上进行；这个系列比较简单易懂；效果比较明显（有成就感）
## java开发流程
修改生成代码的配置，执行GeneratorBasisCode

修改basi-service的bootstrap.yml的灰度version
修改nacos配置管理第三页的cloud-zuul-service的 两处地方
查看nacos服务管理第三页的 BASIS-SERVICE

postman 配devurl 参数spathv

## WHERE (process_required_combination_uuid IN ())
-->Wrapper.in("uuid",[?])


http://www.51gjie.com/java/233.html
https://www.runoob.com/java/java-string.html

## postman接口调不通, sit配置灰度环境 fallback网络出问题啦

检查修改bootstrap.yml   dev  test
检查修改nacos配置

检查spathv=qianyong

 检查本地服务有没有启动 比如这种情况
 Web server failed to start. Port 8895 was already in use.
 
 
