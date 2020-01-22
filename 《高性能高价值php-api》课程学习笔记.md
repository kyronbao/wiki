高性能高价值PHP API学习总结  
  
Yaf框架足够精简，所以可以自己实现一些方法的封装，比如：  
Request，Response，Password加密；  
DAO层抽离；  
异常处理，错误字典管理管理，TryCatch集中捕获；  
权限校验抽离；  
  
编写文档，通过代码注释来生成phpDocument很有用。  
  
性能方面  
定位分析方法：  
通过nginx中配置开启计时日志，可以分析API的相应时间；  
xhprof工具提供了表格和图的UI展示程序开销，非常方便。  
  
稳定性  
介绍了supervisord工具，监控程序，通过配置可以实现程序挂掉重启。  
  
  
  
  
