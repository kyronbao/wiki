## awesome
教程  
- [Node.js 前端开发指南](https://www.zcfy.cc/article/node-js-guide-for-frontend-developers)
- https://survivejs.com/webpack/ 老外的webpack教程
文档  
- [Set集合与Map集合](https://segmentfault.com/a/1190000010311301)
- [生成器函数](https://imququ.com/post/generator-function-in-es6.html) function*
- [ES6 编码规范](https://www.jianshu.com/p/f82932d85f35)
- http://es6.ruanyifeng.com
概念  
- [认识 Fetch API](https://www.zcfy.cc/article/understanding-the-fetch-api)
- [大白话讲解Promise（一）](https://www.cnblogs.com/lvdabao/p/es6-promise-1.html)
- [Promise迷你书](http://liubin.org/promises-book/)
- [JavaScript初学者必看“箭头函数”](https://blog.fundebug.com/2017/05/25/arrow-function-for-beginner/)
- [触摸ES6 - 模板字符串](https://segmentfault.com/a/1190000003092875)
- [JavaScript中的不可变性(Immutability)](https://segmentfault.com/a/1190000004906518)
 - http://www.css88.com/archives/8183
 - https://zhuanlan.zhihu.com/p/28508611
- https://github.com/webpack/webpack/issues/1114 commonjs2
代码规范  
- http://www.runoob.com/html/html5-syntax.html HTML(5) 代码规范
- [配置ESlint](https://stackoverflow.com/questions/32547463/how-to-configure-eslint-to-work-with-phpstorm-to-autofix-eslint-errors/38718327)
移动端适配  
- [移动端的适配 大漠](https://www.zhihu.com/question/275803537)
- http://www.alloyteam.com/2016/03/mobile-web-adaptation-tool-rem/
- [移动端高清、多屏适配方案 - 移动端 H5 - 前端乱炖](https://juejin.im/entry/56ce78eac24aa800545af276)
- [微信h5快速开发框架推荐](https://cnodejs.org/topic/56dce476502596633dc2c3f1)
  - https://vux.li
- [设备像素比devicePixelRatio简单介绍](https://www.zhangxinxu.com/wordpress/2012/08/window-devicepixelratio/)
前端工具  
- https://yarnpkg.com/zh-Hans/docs yarn中文文档
- https://icomoon.io/ svg 图标字体u制作
- https://tool.lu/favicon/
- https://cssreset.com/scripts/eric-meyer-reset-css/ css reset
  
字体  
css引入外部字体 https://blog.csdn.net/qq_17034925/article/details/53585153  
如何优雅的选择字体(font-family) https://segmentfault.com/a/1190000006110417  
中文字体网页开发指南 http://www.ruanyifeng.com/blog/2014/07/chinese_fonts.html  
- css
- [新手flex布局入门篇，看这篇文章就够了](https://segmentfault.com/a/1190000009979975#articleHeader112)
- http://www.ruanyifeng.com/blog/2015/07/flex-grammar.html
- https://blog.csdn.net/lyn1772671980/article/details/80507699
- [网页中 li 标签内元素 不换行的解决办法](https://blog.csdn.net/zsg88/article/details/50801075)
- [左右固定宽度，中间自适应的三列布局](https://www.cnblogs.com/xulei1992/p/6834678.html)
- [何时使用 Em 与 Rem](https://webdesign.tutsplus.com/zh-hans/tutorials/comprehensive-guide-when-to-use-em-vs-rem--cms-23984)
  
- 好用的组件
- serve 全局启动服务 https://www.npmjs.com/package/serve
- [你是如何构建 Web 前端 Mock Server 的？](https://www.zhihu.com/question/35436669)
- https://github.com/marak/Faker.js/ 模拟数据
- rimraf 删除包
- rollup 打包工具，性能更高，可以只加载import的特定函数
  
  

## Vue
  
安装 vue-cli  
```
sudo npm install -g vue-cli
```
  
启动项目  
```
vue init webpack sell

cd sell
sudo npm install
```
  
- [vue中 关于$emit的用法](https://blog.csdn.net/sllailcp/article/details/78595077)
- [使用自定义事件的表单输入组件](https://github.com/Kelichao/vue.js.2.0/issues/19)
## 前端框架
Taro  
- https://github.com/NervJS/taro
  React 语法风格  
  快速开发微信小程序  
- https://juejin.im/book/5b73a131f265da28065fb1cd Taro 多端开发实现原理与项目实战
omi  下一代前端统一框架 - 支持桌面Web、移动H5、小程序、云开发  
- https://github.com/Tencent/omi
  
react-weui  weui for react  
- https://github.com/weui/react-weui
  
wepy 小程序组件化开发框架 Vue.j风格  
- https://github.com/Tencent/wepy
  
chameleon  一套代码运行多端，一端所见即多端所见  
- https://github.com/didi/chameleon
  
ui-app  uni-app 是一个使用Vue.js开发跨平台应用的前端框架，可编译到多个平台  
- https://uniapp.dcloud.io/
  
项目  
 - https://github.com/kuhami/wxbestcake-master
   电商类小程序 包含预览、购物车、添加地址、支付、购买等一系列完整的流程  
- https://github.com/hua1995116/react-shopping 基于react的购物车实战项目
- https://github.com/itmifen/bookdrift 一个基于微信react-weui打造的图书交换平台
- https://github.com/huangzhuangjia/taro-music
- https://github.com/imageslr/taro-library 面向人群主要是 Taro/React/Redux 的初学者
- https://github.com/huangjianke/Gitter
  
测评  
- [我们评测了 5 个主流跨端框架，这是它们的区别](https://www.infoq.cn/article/abC26cpsX44yCGT*hLzb) Taro团队成员的测评
## 对象和数组转化
JSON 字符串 -> JavaScript 对象  
JSON.Parse()  
  
JavaScript 对象 -> JSON 字符串  
JSON.stringify()  
  
## bower install jstree --save 总是报错
使用bower install jstree 在bower_components生成jstree目录  
在次bower install jstree --save 在bower.js添加jstree项  
## checkbox 在jqury和js的操作
### jquery
  
$("input[type='checkbox']").prop("checked");  //选中复选框为true，没选中为false  
$("input[type='checkbox']").prop("disabled", false);  
$("input[type='checkbox']").prop("checked", true);  
  
  
    $(function(){  
        $('#sourceAll').click(function(ev){  
            $('INPUT[name="chk"]').attr('checked',$('#sourceAll').prop('checked'));  //attr可以改为prop试试  
        });  
  
        $('INPUT[name="chk"]').click(function(ev){  
            $('#sourceAll').attr('checked',  
                $('INPUT[name="chk"]:checked').length == $('INPUT[name="chk"]').length);  
        });  
    });  
  
	$('input[name="chkUsers"]:checked').each(function () {  
            id_array.push($(this).val());  
    });  
  
### js
    全选  
    $("#sourceAll").click(function() {  
        if (this.checked) {  
            allCheck('chk',true);  
        } else {  
            allCheck('chk',false);  
        }  
    })  
  
    function allCheck(name,boolValue) {  
        var allvalue = document.getElementsByName(name);  
        for (var i = 0; i < allvalue.length; i++) {  
            if (allvalue[i].type == "checkbox")  
                allvalue[i].checked = boolValue;  
        }  
    }  
  
  
       var checkbox=document.getElementsByName('chkUsers');  
        for(var i=0;i<checkbox.length;i++){  
            if(checkbox[i].checked==true){  
                id_array.push(checkbox[i].value);  
            }  
        }  
## laravel ajax上传文件  
### 直接上传到服务器交互
         $.ajaxSetup({  
            headers: {  
                'X-CSRF-TOKEN': $("input[name='_token']").val()  
            }  
        });  
  
        $('#pic').on('click', function(){  
  
            $('#photo_upload').trigger('click');  
  
            $('#photo_upload').on('change', function(){  
                var obj = this;  
                var formData = new FormData();  
                formData.append('thumb', this.files[0]);  
  
                $.ajax({  
                    url: '/admin/source/uploadPic/',  
                    type: 'post',  
                    data: formData,  
                    processData: false,  
                    contentType: false,  
                    beforeSend:function(){  
                        $('#pic').attr('src', '/img/uploading.png');  
                    },  
                    success: function(data){  
                        if(data['ServerNo']=='200'){  
                            $('#pic').attr('src', '/uploads/'+data['ResultData']);  
                            $('#thumb').val(data['ResultData']);  
                            $(obj).off('change');  
                        }else{  
                            alert(data['ResultData']);  
                        }  
                    },  
                    error: function(XMLHttpRequest, textStatus, errorThrown) {  
                        $('#pic').attr('src', '/img/error.png');  
                        var number = XMLHttpRequest.status;  
                        alert("错误号"+number+"文件上传失败!");  
                    },  
                    async: true  
                });  
            });  
        });  
  
注:url项/admin/source/uploadPic/ 前面和后面的/可以去掉测试有不同的效果，比如form里action有/source/144 的情况，file按钮在form里时  
  
/**  
     * 检查文件  
     *  
     * @param $file  
     * @return array  
     */  
    private function checkFile($file)  
    {  
        if ($file->getClientSize() > $file->getMaxFilesize()) {  
            return ['status' => false, 'msg' => '文件大小不能大于2M'];  
        }  
  
        if (!$file->isValid()) {  
            return ['status' => false, 'msg' => '上传文件不符合要求'];  
        }  
  
        return ['status' => true];  
    }  
  
    /**  
     * 文件上传  
     *  
     * @param  \Illuminate\Http\Request  $request  
     * @return \Illuminate\Http\Response  
     */  
    public function uploadPic(Request $request)  
    {  
        $file = $request->file('thumb');  
  
        $check = $this->checkFile($file);  
  
        if(!$check['status']){  
            return response()->json(['ServerNo' => '400','ResultData' => $check['msg']]);  
        }  
  
        $path = public_path('uploads');  
        $postfix = $file->getClientOriginalExtension();  
        $fileName = md5(time().rand(0,10000)).'.'.$postfix;  
  
        if(!$file->move($path,$fileName)){  
            return response()->json(['ServerNo' => '400','ResultData' => '文件保存失败']);  
        }else{  
            return response()->json(['ServerNo' => '200','ResultData' => $fileName]);  
        }  
  
    }  
  
### 只有前端交互，可预览
```
                            <div class="form-group" id="areaPic">
                                <label class="control-label col-md-2 col-sm-2" for="thumb">资源缩略图 </label>
                                <div class="col-md-8 col-sm-8">
                                    <img src="/uploads/{{ $data['thumb']? $data['thumb']:'noimage.gif'
                                    }}" id="pic" style="cursor: pointer;height:100px"/>
                                    <p class="help-block">点击图片上传(格式：png/jpg/jpeg/gif, 不大于2M)</p>
                                    <input type="file" id="fileUpload" style="display: none;" />
                                    <input type="hidden" id="inputUpload" name="thumb" value="{{ $data['thumb'] }}" />
                                </div>
                            </div>


        //上传图片
        $('#pic').on('click', function(){
            $('#fileUpload').trigger('click');
        });

        $('#fileUpload').on('change', function(event){

            $('#inputUpload').removeAttr('name')
            $('#fileUpload').attr('name','thumb')

            if(fileUploadSize(event.target) > 1024*1024*2){
                $.gritter.add({
                    title: '操作消息！',
                    text: '文件超出大小限制'
                });
                return;
            }

            var src = event.target || window.event.srcElement; //获取事件源，兼容chrome/IE
            var filename = src.value;
            var postfix = filename.substring( filename.lastIndexOf('.')+1 );

            if(['png','jpeg','jpg','gif'].indexOf(postfix) == '-1'){
                $.gritter.add({
                    title: '操作消息！',
                    text: '文件格式不符合'
                });
                return;
            }

            var $file = $(this);
            var fileObj = $file[0];
            var windowURL = window.URL || window.webkitURL;
            var dataURL;

            if(fileObj && fileObj.files && fileObj.files[0]){
                dataURL = windowURL.createObjectURL(fileObj.files[0]);
                $("#pic").attr('src',dataURL);
            }else{
                dataURL = $file.val();
                var imgObj = document.getElementById("pic");
                imgObj.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                imgObj.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = dataURL;
            }
        })
        //end 上传图片

```
```
    /**
     * 文件上传
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
        if($thumb = $request->input('thumb')){
            return ['code' => 2000,'img' => $thumb, 'error'=>'没有修改文件'];
        }

        if($file = $request->file('thumb')){
            $path = public_path('uploads');
            $postfix = $file->getClientOriginalExtension();
            $fileName = md5(time().rand(0,10000)).'.'.$postfix;

            if(!in_array($postfix, array('png','jpeg','jpg','gif'))){
                return ['code' => 2001,'img' => $fileName, 'error'=>'文件格式不对'];
            }

            if($file->getSize() > 1024*1024*2){
                return ['code' => 2002,'img' => $fileName, 'error'=>'文件太大'];
            }

            if($file->move($path, $fileName)){
                return ['code' => 2000,'img' => $fileName, 'error'=>''];
            }else{
                return ['code' => 5000,'img' => $fileName, 'error'=>'文件上传失败'];
            }
        }else{
            return ['code' => 2000,'img' => '', 'error'=>'无上传文件'];
        }

    }

    /**
     * 新建数据
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $params = $request->except('jsonStrTags');
        $params['tags'] = json_decode($request->input('jsonStrTags'),true);

        $arr = $this->uploadFile($request);
        if($arr['code'] !== 2000){
            flash($arr['error'],'error');
            return back();
        }else{
            $params['thumb'] = $arr['img'];
        }

        $res = $this->catalog->insertCatalog($params);

        if($res){
            flash('保存成功','success');
            $pid = intval($request->input('parent_id',0));
            return redirect('admin/catalogs'.($pid>0?'/'.$pid:''));
        }else{
            $code = $this->catalog->getMessageErrorCode();
            if(isset($code)){
                if(is_string($code) && $code>2000 && $code<2100){
                    flash($this->catalog->getMessageError(),'error');
                }elseif($code=='-1005'){
                    flash('分类名称重名','error');
                }
            }
            return back()->withInput();
        }
    }

```
## nvm yarn npm
### nvm
安装nvm  
参考 - https://github.com/nvm-sh/nvm#git-install  
  
使用nvm安装node  
查看node最新版本  
nvm ls-remote node  
安装  
nvm install v10.15.3  
  
使用  
nvm list  
nvm use 10.12  
### archlinux 安装yarn
kyron@ThinkPad:~$ sudo pacman -S npm  
[sudo] password for kyron:  
resolving dependencies...  
looking for conflicting packages...  
  
Packages (6) c-ares-1.15.0-1  libuv-1.29.0-1  node-gyp-4.0.0-1  nodejs-11.15.0-1  
             semver-6.0.0-1  npm-6.9.0-1  
  
Total Download Size:    9.85 MiB  
Total Installed Size:  45.25 MiB  
  
  
配置  
PATH="$HOME/.node_modules/bin:$PATH"  
```
export npm_config_prefix=~/.node_module
```
  
### archlinux安装yarn
kyron@ThinkPak:~$ sudo pacman -S yarn  
resolving dependencies...  
looking for conflicting packages...  
  
Packages (1) yarn-1.16.0-1  
  
Total Download Size:   0.80 MiB  
Total Installed Size:  4.69 MiB  
  
### yarn管理
全局安装  
yarn global add gitbook-cli  
查看安装后目录  
which gitbook  
相关链接  
/home/kyron/.node_modules/bin/gitbook  
/home/kyron/.node_modules/bin/gitbook -> ../../.config/yarn/global/node_modules/.bin/gitbook*  
.config/yarn/global/node_modules/.bin/gitbook -> ../gitbook-cli/bin/gitbook.js*  
  
配置  
  
PATH="$HOME/.node_modules/bin:$PATH"  
```
export PATH=${PATH}:$HOME/.config/yarn/global/node_modules/.bin
```
  
  
  
### 国内源npm yarn
```
国内优秀npm镜像推荐及使用 https://segmentfault.com/a/1190000002576600

npm，yarn如何查看源和换源

npm config get registry  // 查看npm当前镜像源

npm config set registry https://registry.npm.taobao.org/  // 设置npm镜像源为淘宝镜像

yarn config get registry  // 查看yarn当前镜像源

yarn config set registry https://registry.npm.taobao.org/  // 设置yarn镜像源为淘宝镜像
镜像源地址部分如下：

npm --- https://registry.npmjs.org/

cnpm --- https://r.cnpmjs.org/

taobao --- https://registry.npm.taobao.org/

nj --- https://registry.nodejitsu.com/

rednpm --- https://registry.mirror.cqupt.edu.cn/

npmMirror --- https://skimdb.npmjs.com/registry/

deunpm --- http://registry.enpmjs.org/

```
### deepin深度npm安装问题 node-sass 下载不下来
过程：试过npm换淘宝源，cnpm等。。。都不能解决
解决：深度换 阿里的源

vim /etc/apt/sources.list
deb [by-hash=force] http://mirrors.aliyun.com/deepin lion main contrib non-free
#deb [by-hash=force] https://mirrors.tuna.tsinghua.edu.cn/deepin panda main contrib non-free
#deb-src http://mirrors.aliyun.com/deepin lion main contrib non-free

然后
npm install 

npm install cnpm -g --registry=https://registry.npm.taobao.org
cnpm install 

等等操作,竟然好了

### 调试 Unexpected end of JSON input while parsing near '...e","version":"0.1.5",'
```
解决
https://github.com/vuejs-templates/webpack/issues/990

npm cache clean --force
try
if false
delete package.lock.json
try again
if false
npm set registry https://registry.npmjs.org/ don't use taobao mirror
try again
```
### 参考
- https://www.npmjs.com/package/npm-check-updates npm更新package.json依赖的版本
- http://www.fly63.com/article/detial/554 yarn和npm的区别对比_比较npm和yarn 命令行
- [使用 nvm 管理不同版本的 node 与 npm](http://bubkoo.com/2017/01/08/quick-tip-multiple-versions-node-nvm/)
  

