## Eloquent ORM
  
实践了以下功能  
HTTP 路由、HTTP 控制器、迁移、填充数据、关联关系  
  
通过Eloquent ORM的关联关系功能实现了数据库映射的功能，具体有  
一对一：User和UserAccount一一对应  
一对多：User一对多Post/Post一对多Comment  
```
这里提一下怎么记忆hasMany(), belongsTo()里面的id foreignKey
举例来说，
order
id, name   表中没有order_id, 使用hasMany(OrderDetail, order_id)
order_detail
id, order_id  表中含有order_id，使用belongsTo(Order, order_id)
```
  
多对多：Role可以有多个User，同时User也可以有多个Role，通过中间表role_user关联  
远层一对多：Country一对多User，User下一对多Post  
多态关联：比如文章、视频和评论的关系，Post可以有多个Comment，Vidoe也可以有多个Comment，  
- Comment的数据都保存在comments表中，含有item_id、item_type(数据格式App\Models\Post)来实现和Post、Video的映射关系
多对多多态关联：比如文章、视频和标签的关系，Post多对多Tag，Video也多对多Tag，通过中间表taggable实现，  
具体字段为taggable_id,taggable_type(数据格式App\Models\Post),tag_id  
  
另外也实践了渴求式加载、save()、create()、associate()、attach()方法  
  
参考资料  
[[ Laravel 5.1 文档 ] Eloquent ORM —— 关联关系](http://laravelacademy.org/post/140.html#polymorphic-relations])  
[实例教程 —— 关联关系及其在模型中的定义（一）](http://laravelacademy.org/post/1095.html)  
[实例教程 —— 关联关系及其在模型中的定义（二）](http://laravelacademy.org/post/1174.html)  
  
## 访问器 & 修改器
预处理数据，可以在显示和保存数据时处理数据  
例如：用户名first_name的大小写处理，金钱数据的处理等  
密码预处理的demo  
  
    public function setPasswordAttribute($value){  
        $this->attributes['password']=Hash::make($value);  
    }  
  
## 日期修改器
定义模型的日期字段，日期属性可以使用Carbon的方法  
  
    $user->disabled_at->getTimestamp()  
  
## 数组转化
模型的属性可以保存为json,打印显示为array  
例如：示例Post模型的addition属性，图片的附加参数，有些模型可能会有很多附加参数，  
但没必要每个字段都在数据库中保存，可以通过json格式保存  
  
## 序列化
由于模型和集合在转化为字符串的时候会被转化为JSON，你可以从应用的路由或控制器中直接返回Eloquent对象  
  
    $user = User::with('roles')->first();  
    var_dump($user->toArray());  // array  
    var_dump($user->toJson());   // string  
    return $user;                // json  
  
    $users = User::all();  
    var_dump($users->toArray()); // array  
    var_dump($users->toJson());  // string  
    return $users;               // json  
  
