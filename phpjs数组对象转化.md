js  
JSON 字符串 -> JavaScript 对象  
JSON.Parse()  
  
JavaScript 对象 -> JSON 字符串  
JSON.stringify()  
  
php  
Converting an array -> stdClass  
$stdClass = (object) $array;  
$stdClass = json_decode(json_encode($booking));  
  
Converting an array/stdClass -> array  
$array = json_decode(json_encode($booking), true);  
stdClass -> array  一维  
$array = (array)$stdClass;  
