  
php提供了加密的函数  
//查看哈希值的相关信息  
array password_get_info (string $hash)  
  
//创建hash密码  
string password_hash(string $password , integer $algo [, array $options ])  
  
//判断hash密码是否特定选项、算法所创建  
boolean password_needs_rehash (string $hash , integer $algo [, array $options ]  
  
boolean password_verify (string $password , string $hash)  
//验证密码  
  
问： 这样和用md5自己设计规则的算法相比有什么不同呢？  
 md5,sha1这种在加盐后得到的值为固定一样的密码，也容易被反向破解  
password_hash默认采用CRYPT_BLOWFISH加密算法，目前不能被反向破解；每次加的盐值随机（官方建议不使用固定的盐：PASSWORD_BCRYPT算法提供，PHP7.0.0版本后废弃），即使使用原生密码相同，加密后的值也是不同的  
  
参考  
- https://www.php.net/manual/zh/faq.passwords.php
- https://zh.wikipedia.org/wiki/Blowfish
