## 文档doc

https://spring.io/projects/spring-framework#learn   -> Reference Doc.

浏览器地址删到doc
https://docs.spring.io/spring-boot/docs
https://docs.spring.io/spring-framework/docs/

## java 常用写法
## stream语法
过滤
```
List<AssessSpecific> update = 
requests.stream().filter(e -> null != e.getId()).collect(Collectors.toList());
 
```
获取一个字段的list
```
List<Long> collect =
update.stream().map("id").collect(Collectors.toList());
```
Map<String, Object>
```
Map<String, ProcessRequiredClassifications> listMap =
list.stream().collect(Collectors.toMap("UUID", Function.identity()));
```
Map<String,List<Object>>
```
Map<String, List<ProcessRequiredCombinationDetails>> combinationDyesMap =
list.stream().collect(Collectors.groupingBy("UUID"));
```
## wrapper sql写法
insert
```
Area area = new Area();
        area.setAreaName("成都");
        areaMapper.insert(area);
```
delete
```
Map<String,Object> columnMap = new HashMap<>();
columnMap.put("user_name", "hangge");
columnMap.put("age", 22);
// 返回删除的记录数
int i = userInfoMapper.deleteByMap(columnMap);

```
update
```
boolean success = new LambdaUpdateChainWrapper<>(userInfoMapper)
        .like(UserInfo::getUserName,"ha")
        .lt(UserInfo::getAge,40)
        .set(UserInfo::getPassWord, "8888")
        .set(UserInfo::getAge, null)
        .update();
 
/*********** 二者可以结合使用的，下面效果等效于上面的 ****************/
 
UserInfo userInfo = new UserInfo();
userInfo.setPassWord("8888");
boolean success = new LambdaUpdateChainWrapper<>(userInfoMapper)
        .like(UserInfo::getUserName,"ha")
        .lt(UserInfo::getAge,40)
        .set(UserInfo::getAge, null)
        .update(userInfo);
```
listObjs 返回一个字段的list
```
 List<Long> ids = this.listObjs(
                new LambdaQueryWrapper<AdUser>()
                        .select(AdUser::getId)
                        .eq(AdUser::getStatus, 1), o -> Long.valueOf(o.toString()));

参考 https://www.cnblogs.com/lyn8100/p/16574395.html
    /**
     * mybatis-plus的listObjs()原理演示
     */
    @Test
    public void test2(){
        List<Dto> list = new ArrayList<>();
        Dto d1 = new Dto();
        d1.setId(1);
        d1.setName("java");
        list.add(d1);
        Dto d2 = new Dto();
        d2.setName("php");
        list.add(d2);

        //相当于getBaseMapper().selectObjs(queryWrapper),
        // 从数据源中查询id的集合,类型用Object,而不再用LambdaQueryWrapper中的泛型接收了
        //select id from table;
        List<Object> objects = list
                .stream()
                .map(Dto::getId)
                .collect(Collectors.toList());

        List<Integer> collect = objects
                .stream()
                .filter(Objects::nonNull)
                //因为元素是Object,所以只能调用Object的方法
                .map(o->Integer.valueOf(o.toString()))
                .collect(Collectors.toList());
        System.out.println(collect);
        //[1]
    }

```

分组、筛选
下面是 groupBy 和 having 的用法
```
List<UserInfo> userInfos = new LambdaQueryChainWrapper<>(userInfoMapper)
        .groupBy(UserInfo::getUserName, UserInfo::getAge) // group by user_name,age
        .having("sum(age) > 20") // HAVING sum(age) > 20
        .having("sum(age) > {0}", 30) // HAVING sum(age) > 30
        .select(UserInfo::getUserName, UserInfo::getAge)
        .list();
```
查询
```
如果数据库中符合传入条件的记录有多条，这个方法会返回第一条数据，不会报错。

UserInfo user= new UserInfo().selectOne(queryWrapper);
```
链式查询

```
List<UserInfo> users = userInfoService.lambdaQuery()
        .like(UserInfo::getUserName,"ha")
        .lt(UserInfo::getAge,40)
        .list();

UserInfo userInfo = new LambdaQueryChainWrapper<>(userInfoMapper)
        .like(UserInfo::getUserName,"ha")
        .lt(UserInfo::getAge,40)
		.last("limit 1")
        .one();
```
拼接 sql（sql 注入） 原生sql
```
// WHERE age IS NOT NULL AND id = 3 AND user_name = 'hangge'
List<UserInfo> userInfos = new LambdaQueryChainWrapper<>(userInfoMapper)
        .isNotNull(UserInfo::getAge)
        .apply("id = 3") // 有sql注入的风险
        .apply("user_name = {0}", "hangge") //无sql注入的风险
        .list();
```
 子查询
 ```
//uuid所属下级
String uuids = request.getParentUuid();
if (StringUtils.isNotBlank(uuids)) {
   queryWrapper.inSql(ProcessRequiredDyes::getParentId,
       "select ID from process_required_dyes where LEVEL = 1 and UUID = '" + uuids + "'");
        }
 ```
 or查询
 ```
// WHERE age IS NOT NULL AND ((id = 1 AND user_name = 'hangge') OR (id = 2 AND user_name = '航歌'))
List<UserInfo> userInfos = new LambdaQueryChainWrapper<>(userInfoMapper)
        .isNotNull(UserInfo::getAge)
        .and(
			i -> i.nested(j -> j.eq(UserInfo::getId,1).eq(UserInfo::getUserName,"hangge"))
                .or(j -> j.eq(UserInfo::getId,2).eq(UserInfo::getUserName,"航歌"))
        )
        .list(); 
 
 //是否特殊处理搜索
 if (StringUtils.isNotBlank(request.getIsSpecial())) {
     queryWrapper.nested(
         query->query.or(q->q.eq("level",1).eq("special", "N"))
             .or(q->q.eq("level",2).eq("special","Y"))
     );
}

//第一个or待验证
queryWrapper.or(
    query->query.like(ProcessRequiredDyes::getName,names.get(0))
        .or()
    .like(ProcessRequiredDyes::getNameEn,names.get(0))
);
 ```
 附：自定义 SQL 语句使用 Wrapper
```

    mybatis-plus 在 3.0.7 版本之后，也支持自定义 SQL 语句使用 Wrapper，具体有如下两种方案。注意：使用 Wrapper 的话自定义 sql 中不能有 WHERE 语句。

1，注解方式（Mapper.java）
（1）我们可以直接在自定义方法上使用 @Select 设置对应的 sql 语句，然后添加 Wrapper 参数：

public interface UserInfoMapper extends BaseMapper<UserInfo> {
    @Select("SELECT * FROM user_info ${ew.customSqlSegment}")
    List<UserInfo> getAll(@Param(Constants.WRAPPER) Wrapper wrapper);
}

（2）下面调用这个自定义方法：

List<UserInfo> userInfos = userInfoMapper.getAll(
        Wrappers.<UserInfo>lambdaQuery().eq(UserInfo::getId, 1)
);

2，XML 形式（Mapper.xml）
（1）首先在 mapper.xml 中添加自定义的 sql 语句：

<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE mapper PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN"
        "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<mapper namespace="com.example.demo.mapper.UserInfoMapper">
    <select id="getAll" resultType="com.example.demo.model.UserInfo">
        SELECT * FROM user_info ${ew.customSqlSegment}
    </select>
</mapper>

（2）然后在 mapper.java 中添加相应的接口方法即可：

public interface UserInfoMapper extends BaseMapper<UserInfo> {
    List<UserInfo> getAll(@Param(Constants.WRAPPER) Wrapper wrapper);
}
```
## 比较list
!compareList(supplierTypeIdList, data.getSupplierTypeIdList())
## 调用feign
```
            BaseResponse resp = areasServiceApi.search(new JSONObject());
            BaseResponse.checkResponseCode(resp);
            List<AreaInfoDto> areaInfoDtos = JsonUtils.jsonToList(JsonUtils.objectToJson(resp.getData()), AreaInfoDto.class);
			```
			com/sfabric/cloud/srm/controller/api/ApiSupplierController.java:1293
## 数组和字符串转化join split
String.join(",",list)
list.split(",")
## 时间转化
String fileName = "供应商列表-" + DateFormatUtils.format(new Date(), "yyyyMMddHHmmss");
## 遍历list
```
//方法一:
        list.forEach(p -> p.setName(UUID.randomUUID().toString().replaceAll("-", "")));
//方法三:
list=list.stream().map(detailVo -> {
            FiveDao detail = new FiveDao();
            BeanUtils.copyProperties(detailVo, detail);
            detail.setName(UUID.randomUUID().toString().replaceAll("-", ""));
            return detail;
        }).collect(Collectors.toList());
		
//
for list.size()
list.get(i)

```
## 对象等和json字符串转化
```
e.setUserInfo(JsonUtils.objectToJson(e.getUser()));

JsonUtils.jsonToList(assessSpecific.getUserInfo(), AssessSpecific.class)
```

## request response转化对象字段,时间
FillRequestParam FillMethod相互配合
```

    /**
     * 创建时间
     */
    @JsonFormat(pattern="yyyy-MM-dd HH:mm:ss",timezone="GMT+8")
    private Date createdAt;
	
    /**
     * 申请人部门id
     */
    @FillRequestParam(value = "department",type = FillRequestField.VALUE)
    private Long applicantDepartmentId;

    /**
     * 申请人部门
     */
    @FillRequestParam(value = "department",type = FillRequestField.LABEL)
    private String applicantDepartment;


    /**
     * 申请人部门id
     */
    @NotNull(message = "申请人部门不能为空")
    @FillRequestParam(value = "department",type = FillRequestField.VALUE)
    private Long applicantDepartmentId;
	
	
    /**
     * 修改
     */
    @FillMethod(request = true)
    @PreAuthorize("hasAnyAuthority('srm:supplierApplication:modify')")
    @PostMapping("/modify")
    public BaseResponse<Boolean> update(@RequestBody @Validated SupplierApplicationUpdateRequest supplierApplicationUpdateReq) {
	
    /**
     * 详情信息
     */
    @FillMethod(response = true)
    @PostMapping("/info")
    public BaseResponse<SupplierApplicationInfoResponse> info(@RequestBody @Validated SupplierApplicationInfoRequest supplierApplicationInfoReq) {	
```
## listMap初始化多个
```
You can then populate the list in a for loop :

for(int i=0;i<10;++i) {
    lists.put("list"+(i+1),new ArrayList<Model>());
}
You can access the lists using :

  lists.get("list1").add(new Model(...));
  lists.get("list2").add(new Model(...));
```
  
https://stackoverflow.com/questions/30097102/initializing-multiple-lists-in-java-simultaneously
## 添加元素到HashMap的ArrayList
```
Map<String, List<Item>> items = new HashMap<>();
items.computeIfAbsent(key, k -> new ArrayList<>()).add(item);
```
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
## 公司java开发流程

获取登录用户信息
 ```
        UserHeader userHeader = RequestUtils.getUserHeader();
        if (null == userHeader) {
            throw new BaseBizException("无法辨别用户信息,请您先登录!");
        }
        supplierApplicationReq.setApplicantUuid(userHeader.getUserId());
        supplierApplicationReq.setApplicantUserName(userHeader.getRealName());
		
 
 
 com/sfabric/cloud/srm/controller/api/ApiSupplierApplicationController.java:75
 
 ```


修改生成代码的配置，执行GeneratorBasisCode

修改basi-service的bootstrap.yml的灰度version
修改nacos配置管理第三页的cloud-zuul-service的 两处地方
查看nacos服务管理第三页的 BASIS-SERVICE

postman 配devurl 参数spathv

cloud-common-core 这个包里包含了大部分基础的依赖
如spring-boot-starter-validation spring-webmvc  lombok 等等

## 怎么微服务查看pom.xml里各依赖的版本号
点击引用关系(向上)
## java 调试bug
### Failed to parse multipart servlet request; /opt/www/java/tmp/
Failed to parse multipart servlet request; nested exception is java.lang.RuntimeException: java.nio.file.NoSuchFileException: /opt/www/java/tmp/undertow4854571290840549126upload

解决
sudo mkdir -p /opt/www/java/tmp
chmod 777 /opt/www/java/tmp -R

https://blog.csdn.net/qq_35971258/article/details/84867895
## WHERE (process_required_combination_uuid IN ())
-->Wrapper.in("uuid",[?])


http://www.51gjie.com/java/233.html
https://www.runoob.com/java/java-string.html


 http://www.mamicode.com/info-detail-2878823.html

## postman接口调不通, sit配置灰度环境 fallback网络出问题啦

检查修改bootstrap.yml   dev  test
检查修改nacos配置

检查spathv=qianyong

 检查本地服务有没有启动 比如这种情况
 Web server failed to start. Port 8895 was already in use.
 
 

