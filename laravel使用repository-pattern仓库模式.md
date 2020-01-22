  
  
Eloquent的Query Scope([查询作用域](http://laravelacademy.org/post/138.html))，可以在模型层封装部分条件，在控制层可以实现复用。  
  
Repository Pattern仓库模式在模型层和控制层中间，通过将模型注入仓库，优点有：  
- 可以通过Repository封装一个基类，增加模型层的公共方法，方便复用；
- 多个模型交互，可以一起注入一个仓库，在仓库中编写部分逻辑，实现代码分离；
- 仓库可以定义契约接口，面向接口编程。
  
参考  
- [为什么要学习Repository Pattern(仓库模式)](https://segmentfault.com/a/1190000004875930) 解释了仓库模式的作用
- [[http://farll.com/2014/09/php-design-pattern-repository/]] 实现了MemoryStorage和Post数据映射层之间的Repository的PHP代码实例，代码的分层思想感觉有点乱。
- [Laravel 5 中使用仓库(Repository)模式](https://github.com/lanceWan/INote/blob/master/Laravel/Laravel%205%20%E4%B8%AD%E4%BD%BF%E7%94%A8%E4%BB%93%E5%BA%93(Repository)%E6%A8%A1%E5%BC%8F.md) 言简意赅
- https://github.com/andersao/l5-repository Laravel5的仓库组件 [官网](http://andersonandra.de/l5-repository/)
