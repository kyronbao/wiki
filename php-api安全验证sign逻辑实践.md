客户端和服务端约定算法，含有时间戳，这样每个sign值是不同的；  
  
设置过期时间  
假如sign值被获取了，可以设置13位time值，服务端判断超过几秒后失效。举例来说，当别人拿到sign值，这个sign只能取到当前几秒内的API数据，过期后sign值无效。  
  
sign唯一校验  
当API访问时，redis缓存sign值，再次通过sign访问则无效。  
  
代码片段  
  
```
/**
 * aes 加密 解密类库
 * @by singwa
 * Class Aes
 * @package app\common\lib
 */
class Aes {

    private $key = null;

    /**
     *
     * @param $key 		密钥
     * @return String
     */
    public function __construct() {
        // 需要小伙伴在配置文件app.php中定义aeskey
        $this->key = config('app.aeskey');
    }

    /**
     * 加密
     * @param String input 加密的字符串
     * @param String key   解密的key
     * @return HexString
     */
    public function encrypt($input = '') {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = $this->pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $this->key, $iv);

        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);

        return $data;

    }
    /**
     * 填充方式 pkcs5
     * @param String text 		 原始字符串
     * @param String blocksize   加密长度
     * @return String
     */
    private function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
     * @return String
     */
    public function decrypt($sStr) {
        $decrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$this->key,base64_decode($sStr), MCRYPT_MODE_ECB);
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);

        return $decrypted;
    }

}
```
  
```
/**
 * Iauth相关
 * Class IAuth
 */
class IAuth {

    /**
     * 设置密码
     * @param string $data
     * @return string
     */
    public static  function setPassword($data) {
        return md5($data.config('app.password_pre_halt'));
    }

    /**
     * 生成每次请求的sign
     * @param array $data
     * @return string
     */
    public static function setSign($data = []) {
        // 1 按字段排序
        ksort($data);
        // 2拼接字符串数据  &
        $string = http_build_query($data);
        // 3通过aes来加密
        $string = (new Aes())->encrypt($string);

        return $string;
    }

    /**
     * 检查sign是否正常
     * @param array $data
     * @param $data
     * @return boolen
     */
    public static function checkSignPass($data) {
        $str = (new Aes())->decrypt($data['sign']);

        if(empty($str)) {
            return false;
        }

        // diid=xx&app_type=3
        parse_str($str, $arr);
        if(!is_array($arr) || empty($arr['did'])
            || $arr['did'] != $data['did']
        ) {
            return false;
        }
        if(!config('app_debug')) {
            if ((time() - ceil($arr['time'] / 1000)) > config('app.app_sign_time')) {
                return false;
            }
            //echo Cache::get($data['sign']);exit;
            // 唯一性判定
            if (Cache::get($data['sign'])) {
                return false;
            }
        }
        return true;
    }
}
```
  
```
/**
 * 时间
 * Class IAuth
 */
class Time {

    /**
     * 获取13位时间戳
     * @return int
     */
    public static function get13TimeStamp() {
        list($t1, $t2) = explode(' ', microtime());
        return $t2 . ceil($t1 * 1000);
    }
}
```
  
  
```
    /**
     * 初始化的方法
     */
    public function _initialize() {
        $this->checkRequestAuth();
        //$this->testAes();
    }

    /**
     * 检查每次app请求的数据是否合法
     */
    public function checkRequestAuth() {
        // 首先需要获取headers
        $headers = request()->header();
        // todo

        // sign 加密需要 客户端工程师 ， 解密：服务端工程师
        // 1 headers body 仿照sign 做参数的加解密
        // 2
        // 3

        // 基础参数校验
        if(empty($headers['sign'])) {
            throw new ApiException('sign不存在', 400);
        }
        if(!in_array($headers['app_type'], config('app.apptypes'))) {
            throw new ApiException('app_type不合法', 400);
        }

        // 需要sign
        if(!IAuth::checkSignPass($headers)) {
            throw new ApiException('授权码sign失败', 401);
        }
        Cache::set($headers['sign'], 1, config('app.app_sign_cache_time'));

        // 1、文件  2、mysql 3、redis
        $this->headers = $headers;
    }

    public function testAes() {
        $data = [
            'did' => '12345dg',
            'version' => 1,
            'time' => Time::get13TimeStamp(),
        ];

        //$str = 'sRCvj52mZ8G+u2OdHYwmysvczmCw+RrAYWiEaXFI/5A=';
        // col9j6cqegAKiiey3IrXWo2zCRGHw8vogniwQZab0fgIVnKDb7Rin03dOqY2qLWP
        echo IAuth::setSign($data);exit;
        echo (new Aes())->decrypt($str);exit;
    }
```
  
  
