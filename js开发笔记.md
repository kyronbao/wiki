  
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
