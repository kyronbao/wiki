Lumen是Laravel的轻量级框架，那么开发Api使用Laravel还是Lumen呢？  
  
最近做个项目，打算提供前端页面和后台管理的API，后台使用Cookie管理状态，使用Lumen了搭建了一波。说一下遇到的问题，Lumen测试组件不支持Cookie测试，于是使用了 [lumen-testing](https://github.com/albertcht/lumen-testing) 代替了，然后使用sqlite内存测试时，需要创建Migration表来支持测试，然后呢，使用不了 =Use DatabaseMigrations= ...，折腾...  
  
那么开发API到底该选用Lumen还是Laravel呢？  
  
参考了下  
- https://laracasts.com/discuss/channels/general-discussion/lumen-or-laravel-for-big-apis
- https://www.quora.com/Is-it-good-to-use-Laravel-for-API-development
  
总结：  
- 当你要使用的包Lumen没有时，使用Laravel
- 如果开发的项目较大，需求不太确定，用Laravel
- 如果需求确定，只提供少量API服务，选Lumen，所以才称为轻量级
- 如果从性能纠结，PHP也有其他更快的框架服务选择的
  
