  
在yii项目中调试发现 有个类找不到，试了各种办法：  
- 重新拉取masster代码
- composer install
- copy别的项目可用的vender
最后，都不管用  
  
解决办法是：  
  
```
composer dump-autoload -o
```
