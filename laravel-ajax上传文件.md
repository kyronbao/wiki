  
## 直接上传到服务器交互
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
  
## 只有前端交互，可预览
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

