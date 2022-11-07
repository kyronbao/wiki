## 文档doc

https://spring.io/projects/spring-framework#learn   -> Reference Doc.

浏览器地址删到doc
https://docs.spring.io/spring-boot/docs
https://docs.spring.io/spring-framework/docs/

公司学习文档
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
## java 常用写法
## stream语法


获取一个字段的list
```
List<Long> collect =
update.stream().map("id").collect(Collectors.toList());
```
获取其中一个
```
Optional<SyncOperationTypeEnum> first 
= Arrays.stream(SyncOperationTypeEnum.values()).filter(e -> e.getCode().equals(code)).findFirst();
return first.get();
```
过滤
```
List<AssessSpecific> update = 
requests.stream().filter(e -> null != e.getId()).collect(Collectors.toList());
 
 
filter(e->{
       return Objects.nonNull(e.getSupplierTypeId());
})
```
排序
```
List<Integer> transactionsIds = 
widgets.stream()
             .filter(b -> b.getColor() == RED)
             .sorted((x,y) -> x.getWeight() - y.getWeight())
             .mapToInt(Widget::getWeight)
             .sum();
```

去重，逗号连接
```
String output = list.stream().distinct().collect(Collectors.joining(","));

```
判断集合里面的所有值符合条件
```
List<Integer> list = List.of(2,5,8,9,4,20,11,43,55);

boolean bo = list.stream().allMatch(a -> a>1);
System.out.println(bo);
 
boolean bo2 = list.stream().allMatch(a -> a>10);
System.out.println(bo2);

运行结果：
true
false

anyMatch：判断的条件里，任意一个元素成功，返回true
allMatch：判断条件里的元素，所有的都是，返回true
noneMatch：与allMatch相反，判断条件里的元素，所有的都不是，返回tru
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
Map<String,String>
```
Map<String,String> countryMap = countryInfo.stream().collect(Collectors.toMap(CountryInfo::getAbbr, CountryInfo::getName));
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

or

customerBrandTemplateRelateService.lambdaUpdate()
.eq(CustomerBrandTemplateRelate::getCustomerId, request.getCustomerId())
.in(CustomerBrandTemplateRelate::getBrandId, idSet)
.remove();

```
update
```
boolean flag = supplierDocumentService.lambdaUpdate()
.set(SupplierDocument::getDocumentId, supplierDocumentUpdateRequest.getDocumentId())
.set(Objects.nonNull(userHeader), InquirySupplier::getBidderName, userHeader.getRealName())
.eq(SupplierDocument::getId, supplierDocumentUpdateRequest.getId())
.update();

or

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
逗号分隔字段查询,find_in_set
```
customerQueryWrapper.apply(StringUtils.isNotBlank(customerPageRequest.getCustomerTypeId()), "find_in_set({0},CUSTOMER_TYPE_ID)", customerPageRequest.getCustomerTypeId());
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
List<UserInfo> userInfos = new LambdaQueryChainWrapper<>(userInfoMapper).isNotNull(UserInfo::getAge)
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


queryWrapper.and(
    query->query.like(ProcessRequiredDyes::getName,names.get(0))
        .or()
    .like(ProcessRequiredDyes::getNameEn,names.get(0))
);
 ```
 联表查询
 询价单列表
 com/sfabric/cloud/pms/service/impl/InquiryServiceImpl.java:100
 com/sfabric/cloud/pms/mapper/xml/InquiryMapper.xml:51
 
 
## wrapper xml自定义 SQL 语句使用 Wrapper
传前端的参数
```
<if test="param.groupName != null and param.groupName != ''">
      and cbg.GROUP_NAME like CONCAT('%', #{param.groupName}, '%')
</if>

com/sfabric/cloud/customer/mapper/xml/BrandInfoMapper.xml:78
```

传list数组,GROUP分组
```
<select id="queryBySummaryIds" resultType="com.sfabric.cloud.pms.response.PurchaseOrderBillDetailInfoResponse">
    SELECT
        detail.SUMMARY_ID,
        GROUP_CONCAT(DISTINCT demand.DEMAND_NUMBER) as DEMAND_NUMBER,
        GROUP_CONCAT(DISTINCT demand.TASK_NUMBER) as TASK_NUMBER
    FROM pms_purchase_order_bill_detail detail
             JOIN pms_purchase_demand demand ON demand.ID = detail.DEMAND_ID
    WHERE detail.SUMMARY_ID IN
    <foreach collection="summaryIds" open="(" close=")" separator="," item="summaryId">
        #{summaryId}
    </foreach>
    GROUP BY detail.SUMMARY_ID
</select>
```
基础
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
## listMap添加多个,List遍历/初始化,StringBuilder,随机
随机数字串
```
nextInt(int x)则会生成一个范围在0~x（不包含X）内的任意正整数

String randomNum = String.format("%04d",new Random().nextInt(9999));
```
List初始化
```
 List<String>  list = Arrays.asList("bb", "cc");
 
 List<Long> list = Lists.newArrayList(1L, 2L)
```
遍历list
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
添加元素到HashMap的ArrayList
```
Map<String, List<Item>> items = new HashMap<>();
items.computeIfAbsent(key, k -> new ArrayList<>()).add(item);
```
https://stackoverflow.com/questions/12134687/how-to-add-element-into-arraylist-in-hashmap

StringBuilder
```
StringBuilder builder = new StringBuilder();
        extraBanks.stream().forEach(t -> {
            builder.append(t.getBankName()).append("-").append(t.getAccountName()).append(",");
        });
        builder.deleteCharAt(builder.length() - 1);
        return builder.toString();
```
## 判断相等List,String,decimal
Bigdecimal
```
BigDecimal weight = BigDecimal.ZERO;
weight = weight.add(purchaseDemand.getDemandWeight());
if (weight.compareTo(new BigDecimal("99999999.99")) > 0) {
    throw new BaseException("采购需求的重量相加不能超过99999999.99");
}
```

1、基本变量的比较方式我就用“==”
2、如果要比较实际内存中的内容，我们就要用“equals”方法

a.equals(b)：如果此时a为null，则在程序运行的时候，会发生空指针异常


Object
```
Integer a; Integer b;
Objects.equals(a, b)

注:
a和b必须类型相同,a或b为null时不报错
a，b两个参数都为 null， 返回 true 
其中一个参数为 null ，返回 false 
两个参数都不为 null， 则调用 a.equals(b)

https://blog.csdn.net/lisu061714112/article/details/123647907
```

String
```
roleName.equals(new String("系统管理员")
```

## 转化数组字符串/时间/对象等和json
String->Long
```
String str;
Long id = Long.valueOf(str);

String str = String.valueOf(id);
```

保存时间
```
Date date = new Date();
multiType.setCreatedTime(date);
```
数组和字符串join split
```
String string = String.join(",",list);
List<String> list = Lists.newArrayList(string.split(StrUtil.COMMA))
```
时间
```
String fileName = "供应商列表-" + DateFormatUtils.format(new Date(), "yyyyMMddHHmmss");

LocalDate nowDate = LocalDate.now();
                    generator.setYear(nowDate.getYear());
                    generator.setMonth(nowDate.getMonthValue());
                    generator.setDay(nowDate.getDayOfMonth());
```
对象等和json字符串
```
e.setUserInfo(JsonUtils.objectToJson(e.getUser()));

JsonUtils.jsonToList(assessSpecific.getUserInfo(), AssessSpecific.class)

object->json string
String str = JSON.toJSONString(messageDto)
String str = JSONUtil.toJsonStr(messageDto)
```
object->list  object是接口返回的对象
```
Object country;

List<CountryInfo> countryInfo = JSONUtil.toList(JSONUtil.parseArray(country), CountryInfo.class);
```

## spring 常用
## 转化spring request/response对象字段,时间
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
## spring异步
```
事件
    @Resource
    private ApplicationEventPublisher applicationEventPublisher;
	
	@Override
    public void register() {
        Student student = new Student();
        student.setId(1);
        student.setName("tom");
        applicationEventPublisher.publishEvent(student);
        System.out.println("结束了");
    }
	
	
监听	
@Component
public class StudentEventListener {
    @EventListener(condition = "#student.id != null")
    public void handleEvent(Student student){
        try {
            Thread.sleep(5000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
        System.out.println(student);
    }
}
```
com/sfabric/cloud/pms/service/impl/PurchaseDemandServiceImpl.java:222

https://blog.csdn.net/u012843873/article/details/113364753 spring异步
## 配置多数据库
spring nacos mybatis配置多数据库
查看mapper的xml的namespace

https://juejin.cn/post/6844904086593077256
https://blog.csdn.net/qq_34972627/article/details/121655441
## 公司java开发相关
## 获取uuid/用户/获取权限字段/调用feign/批量保存/redis锁
获取uuid
```
supplier.setUuid(IdUtil.fastSimpleUUID());
```
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
 获取权限字符串
```
Collection<? extends GrantedAuthority> authorities = SecurityContextHolder.getContext().getAuthentication().getAuthorities();
List<String> list = new ArrayList<>();
for (GrantedAuthority grantedAuthority : authorities) {
     if (PermissionsConstant.SUPPLIER_PERMISSIONS.contains(grantedAuthority.getAuthority())) {
           list.add(grantedAuthority.getAuthority());
     }
}

com/sfabric/cloud/srm/controller/api/ApiSupplierController.java:192
```
 调用feign获取,获取角色名
 ```
         UserHeader userHeader = RequestUtils.getUserHeader();
        SysRoleListRequest sysRoleListRequest = new SysRoleListRequest();
        sysRoleListRequest.setUserId(userHeader.getUserId());
        sysRoleListRequest.setAppSystemIds(org.assertj.core.util.Lists.newArrayList(SystemIdEnum.SRM.getCode()));
        BaseResponse<ListVo<List<SysRoleInfoResponse>>> listVoBaseResponse = sysRoleServiceApi.list(sysRoleListRequest);
        BaseResponse.checkResponseCode(listVoBaseResponse);
        List<SysRoleInfoResponse> rolesList = listVoBaseResponse.getData().getList();
 ```

批量保存
 ```
//供应商额外信息表(开户行)
if (!CollectionUtils.isEmpty(supplierRequest.getSupplierExtra().getBank())) {
    List<SupplierExtraBank> banks = Lists.newArrayList();
    supplierRequest.getSupplierExtra().getBank().forEach(bankAddRequest -> {
        bankAddRequest.setSupplierId(supplierId);
        banks.add(BeanUtils.copyProperties(bankAddRequest, SupplierExtraBank.class));
    });
    bankService.saveBatch(banks);
}
 ```
 调用php feign,转化 objectMapper.convertValue()  new TypeReference
 ```
BaseResponse<BasicGenericGetResponse> result =
         objectMapper.convertValue(productResponse, new TypeReference<BaseResponse<BasicGenericGetResponse>>() {
});

com/sfabric/cloud/product/component/GenericProductComponent.java:73

https://www.cnblogs.com/qingmuchuanqi48/p/13224173.html ObjectMapper处理从远程获取的Object对象
https://blog.csdn.net/zhuzj12345/article/details/102914545 Java中TypeReference用法说明
 ```
 调用feign校验，json转化
```
BaseResponse resp = areasServiceApi.search(new JSONObject());
BaseResponse.checkResponseCode(resp);
List<AreaInfoDto> areaInfoDtos = JsonUtils.jsonToList(JsonUtils.objectToJson(resp.getData()), AreaInfoDto.class);

com/sfabric/cloud/srm/controller/api/ApiSupplierController.java:129
```


redis锁,失误锁,当这个类型操作在处理中时 不同时处理这种类型
```
String lockKey = supplierNumber.getRediskeyPreFix() + year + StrUtil.COLON + supplierNumber.getBusinessType(); 
String lockVal = IdUtil.fastSimpleUUID();

try {
    boolean lock = redisLock.tryLock(lockKey, lockVal, 60L, 20L);
    if (lock) {
		...
    }
} finally {
    redisLock.release(lockKey, lockVal);
}

com/sfabric/cloud/srm/service/impl/KeygeneratorServiceImpl.java:199
```
## 开发流程/调用服务调试/查看依赖版本/接口时好时坏

开发流程
```
修改生成代码的配置，执行GeneratorBasisCode

修改basi-service的bootstrap.yml的灰度version
修改nacos配置管理第三页的cloud-zuul-service的 两处地方
查看nacos服务管理第三页的 BASIS-SERVICE

postman 配devurl 参数spathv
```
调用服务调试
```
supplier-portal 调用srm

本地配置门户和srm环境灰度qianyong nacos配置 和对应的修改bootstrap 的version
修改srm bug
postman调试或浏览器灰度qianyong测试
  修改srm 4个 pom.xml version 为1.8.1.SNAPSHOT
  修改门户-service和srm-service 文件加下面pom.xml的srm-service-api为1.8.1.SNAPSHOT
  (当门户service引用srm-service-api的response对象时,需要修改依赖的版本号)
  完了记得刷新maven
  直接localhost:9988 这样调用本地feign调试,
  
发布

nacos配置 和对应的修改bootstrap 的version 

编辑发布门户和srm的jenkins
```


怎么微服务查看pom.xml里各依赖的版本号
```
点击引用关系(向上)
```
接口时好时坏
```
检查nacos配置
```

cloud-common-core 这个包里包含了大部分基础的依赖
```
如spring-boot-starter-validation spring-webmvc  lombok 等等
```


## java 组件

## Hibernate Validator
```

@Max(value=)
Checks whether the annotated value is less than or equal to the specified maximum

Supported data types
BigDecimal, BigInteger, byte, short, int, long  CharSequence, any sub-type of Number and javax.money.MonetaryAmount


@Length(min=, max=)
Validates that the annotated character sequence is between min and max included
Supported data types
CharSequence

@Size(min=, max=)
Checks if the annotated element’s size is between min and max (inclusive)
Supported data types
CharSequence, Collection, Map and arrays


@Range(min=, max=)
Checks whether the annotated value lies between (inclusive) the specified minimum and maximum

Supported data types
BigDecimal, BigInteger, CharSequence, byte, short, int, long and the respective wrappers of the primitive types


@Size(max = 20, message = "统一社会信用代码长度不能超过20个字符")
private String creditCode;

@DecimalMin(value = "0.01",message = "plantCapacity min 0.01")
@DecimalMax(value = "99999999.99",message = "plantCapacity max 99999999.99")
private BigDecimal plantCapacity;


@Range(max = 2,min = 0,message = "单位输入错误")
private Integer registeredCapitalUnit;

/**
* srm.v1.0.5.1 实磅标识 Y, N, T
*/
@Pattern(regexp = "^|Y|N|T$" ,message = "reallyPoundFlag out of value")
private String reallyPoundFlag;


@Valid
@FillNestedField("supplierEquipment")
private SupplierEquipmentAddRequest supplierEquipment;


@Valid：没有分组的功能。
@Valid：可以用在方法、构造函数、方法参数和成员属性（字段）上
@Validated：提供了一个分组功能，可以在入参验证时，根据不同的分组采用不同的验证机制
@Validated：可以用在类型、方法和方法参数上。但是不能用在成员属性（字段）上

两者是否能用于成员属性（字段）上直接影响能否提供嵌套验证的功能


https://docs.jboss.org/hibernate/validator/5.4/reference/en-US/html_single/#section-builtin-method-constraints
https://blog.csdn.net/sunnyzyq/article/details/103527380 基础,介绍很详细
https://blog.csdn.net/qq_32352777/article/details/108424932 介绍深入
```
## 汉字转拼音
```
 <dependency>
     <groupId>com.belerweb</groupId>
     <artifactId>pinyin4j</artifactId>
     <version>2.5.0</version>
</dependency>


    public static void main(String[] args) throws Exception {
        System.out.println(getPinyin("haha你笑起来真好看", " "));
        System.out.println(getPinyinInitials("你笑起来真好看"));
    }

    /**
     * 将汉字转换为全拼
     *
     * @param text 文本
     * @param separator 分隔符
     * @return {@link String}
     */
    public static String getPinyin(String text, String separator) {
        char[] chars = text.toCharArray();
        HanyuPinyinOutputFormat format = new HanyuPinyinOutputFormat();
        // 设置大小写
        format.setCaseType(HanyuPinyinCaseType.LOWERCASE);
        // 设置声调表示方法
        format.setToneType(HanyuPinyinToneType.WITHOUT_TONE);
        // 设置字母u表示方法
        format.setVCharType(HanyuPinyinVCharType.WITH_V);
        String[] s;
        String rs = StringUtils.EMPTY;
        try {
            StringBuilder sb = new StringBuilder();
            for (int i = 0; i < chars.length; i++) {
                // 判断是否为汉字字符
                if (String.valueOf(chars[i]).matches("[\\u4E00-\\u9FA5]+")) {
                    s = PinyinHelper.toHanyuPinyinStringArray(chars[i], format);
                    if (s != null) {
                        sb.append(s[0]).append(separator);
                        continue;
                    }
                }
                sb.append(String.valueOf(chars[i]));
                if ((i + 1 >= chars.length) || String.valueOf(chars[i + 1]).matches("[\\u4E00-\\u9FA5]+")) {
                    sb.append(separator);
                }
            }
            rs = sb.substring(0, sb.length() - 1);
        } catch (BadHanyuPinyinOutputFormatCombination e) {
            e.printStackTrace();
        }
        return rs;
    }
```
https://www.cnblogs.com/pcheng/p/12871373.html
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
 
 

