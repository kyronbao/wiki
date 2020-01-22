用户注册完成后代码：  
```
return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
```
vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php:37  
注：这里用到一个PHP三元运算的简化语法。  
  
注册成功后预留给客户端一个方法registered()，可以留给业务端中实现具体逻辑，如果没有实现的话则跳转。  
  
举个例子，在控制器实现注册后保存token，返回用户json数据：  
```
protected function registered(Request $request, $user)
{
    $user->generateToken();

    return response()->json(['data' => $user->toArray()], 201);
}
