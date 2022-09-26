## Debug  
刷新不出页面  
1检查和html列和datatable js的列对应关系  
2 如果以上对应关系正确，清除缓存  
## 组件备注  
DOM / jQuery events 获取一行的数据  
DataTables events  点击搜索，分页等事件  
Column rendering 可以渲染链接的列，自定义列，按钮等  
Setting defaults 设置所有datatable的相同的共同的一些参数  
Row created callback 对每一列的数据处理显示 比如判断大小  
Footer callback 计算每页价格的总计  
Custom toolbar elements 定义div button标签到datatable里  
Generated content for a column  列中显示按钮，获取数据  
Custom data source property  ajax获取的数据是对象格式，对象有属性比如{"data":[[...],[...]]}  
Deferred rendering for speed  延迟加载，datatable只渲染当前页面的数据，提高速度  
  
Row selection (multiple rows) 获取所选数据  
  
Select  
单选，全选等按钮 已选择状态 Buttons  
重新加载时可以维护已选择的不消失 Retain selection on reload  
点击按钮获取datatable数据 Get selected items  
  
例子  
  
## 结合daterangepicker实现Datatables表格带参数查询
 http://datatables.club/example/user_share/send_extra_param.html  
## 操作按钮用js表现，checkbox第一列
                    "columnDefs": [  
                    {  
                    "render": function ( data, type, row ) {  
                            return ' <a href="{{ $_SERVER['HTTP_HOST'] }}/admin/catalog/'+row.id+'/edit">' +  
                                '<button id="'+row.id+'" class="btn btn-xs btn-success">' +  
                                '<i class="fa fa-pencil"></i> 编辑 </button></a> ' +  
                                ' <button id="'+row.id+'" class="btn btn-xs btn-danger">' +  
                                '<i class="fa fa-trash"></i> 删除 </button> ';  
                        },  
                        "targets": 4  
                    },  
                    {  
                        render: function ( data, type, row ) {  
                            return '';  
                        },  
                        orderable: false,  
                        className: 'select-checkbox cursor-pointer',  
                        targets:   0  
                    }  
]  
## 修改datatable 的默认英文如Previous为中文
google 搜索datatables文档  
文档中找language 的菜单  
http://l-lin.github.io/angular-datatables/archives/#!/api  
ctrl+F 搜索lang  
然后到文档中修改  
## datatables + vue 实现增加删除列表功能
```
<div class="form-group">
  <label class="control-label col-md-2 col-sm-2" for="url">资源选择 * :</label>
  <div class="col-md-4 col-sm-4">
    <table class="table table-bordered table-hover" id="datatable">
      <thead>
        <tr>
          <th style="width: 10px;"></th>
          <th>资源列表</th>
          <th style="width:20px;"></th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="col-md-4 col-sm-4">
    {{--<div class="input-group">--}}
    {{--<input type="hidden" name="resource_id" value="" />--}}
    {{--<input class="form-control" type="text" name="resource_name" placeholder="已选资源展示" />--}}
    {{--<div class="input-group-btn">--}}
    {{--<button type="button" class="btn btn-success">选择资源</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    <div class="height-50"></div>
    {{--<div id="textareaShow" class="form-control" style="height:60px;margin-bottom:5px;">
    <div id="app">
    <button v-on:click="add">add</button>
    <button v-on:click="del(22)">del</button>
    <div v-for="(item, index) in items" style="height:25px;">
    <span v-bind:id="item.id" class="bg-info btn-xs"> ${ item.name }
    <i style="cursor:pointer"> &times;</i>
    </span>
    ${ index } - ${ item.id } - ${ item.name }
    </div>
    </div>
    </div>--}}
    <div id="inner-content-div">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            {{--<th style="width: 10px;"></th>--}}
            <th>已选资源</th>
            <th style="width:50px;"></th>
          </tr>
        </thead>
        <tbody id="app">
          <tr  v-for="(item, index) in items">
            <td>${ item.name }</td>
            <td><a v-bind:id="item.id" v-on:click="del(item.id)" class="btn btn-xs">
              <i class="fa fa-trash"></i></a></td>
          </tr>
        </tbody>
      </table>
    </div>


  </div>

</div>

<script>
 var table = $('#datatable').DataTable({
	 "processing": true,
	 'language': {
		 "url": "{!! asset('asset_admin/assets/lang/datatable.zh_cn.lang') !!}"
	 },
	 "serverSide": true,
	 'searchDelay': 300,//搜索延时
	 'search': {
		 regex: true//是否开启模糊搜索
	 },
	 "dom": 'frtpB',
	 'order': [[1, 'desc']],
	 'select': {
		 style: 'multi',
		 selector: 'td:first-child',
		 info: false
	 },
	 buttons: [
		 {
			 text: '批量添加',
			 action: function () {
				 var count = table.rows( { selected: true } ).count();
				 // $('#textareaShow').val(count)
				 var data = table.rows( { selected: true } ).data().toArray();
				 var str = '', selected = [], target = []
				 for(var i=0;i<count;i++){
                     selected[i] = {id:data[i].id, name:filterHTML(data[i].name)}
				 }

				 for(var j=0;j<selected.length;j++){
                     app.add(selected[j])
				 }

				 // for(var i=0;i<count;i++){
				 //     console.log(data[i].id)
				 //     str += ' <span data-id="'+data[i].id+'" class="bg-info btn btn-xs">'+filterHTML(data[i].name)
				 //         +'<i> &times;</i></span> '
				 // }
				 // $('#textareaShow').append(str)
			 }
		 }
	 ],
	 "columnDefs": [
		 {
			 render: function (data, type, row) {
				 return '';
			 },
			 orderable: false,
			 className: 'select-checkbox cursor-pointer',
			 targets: 0
		 },
		 {
			 render: function (data, type, row) {
				 return '<a data-id="'+data+'"  data-name="'+filterHTML(row.name)+'" class="btnAdd btn btn-xs"><i class="fa fa-plus"></i></a>';
			 },
			 orderable: false,
			 targets: 2
		 }
	 ],
	 "ajax": {
		 'url': "/admin/catalog/ajaxIndex",
		 'data': {
			 'parent': function () {
				 return $('input[name="parent"]').val();
			 }
		 }
	 },
	 "columns": [
		 {"data": "id", "name": "id", "orderable": false},
		 {"data": "name", "name": "name", "orderable": false},
		 {"data": "id", "name": "id", "orderable": false},
	 ]
 });//end table



 var app = new Vue({
	 delimiters: ['${', '}'],
	 el: '#app',
	 data: {
		 items: [
			 { id: 11, name: 'aaaa' },
			 { id: 22, name: 'bbbb' },
			 { id: 33, name: 'cccc' },
		 ]
	 },
	 methods: {
		 add: function (obj) {
			 // var str = ''
			 // for(var i=0;i<this.items.length;i++){
			 //     str += this.items[i].id+'--'+this.items[i].name
			 // }
			 // console.log(str)
			 var bool=true;
			 this.items.forEach(function(element) {
				 if(element.id==obj.id){
					 $.gritter.add({
						 title: '操作消息！',
						 text: element.name+' 已经添加了，请重新操作！'
					 });
					 console.log(element.name+' 重复了')
					 bool = false
				 }
			 });

			 if(bool){
				 this.items.push(obj)
			 }

			 table.rows().deselect();

		 },
		 del: function(id){

			 var target = []
			 this.items.forEach(function(element) {
				 if(element.id!=id){
					 target.push({id:element.id,name:element.name})
				 }else{
					 console.log('已删除 '+element.name)
				 }
			 });
			 this.items = target
		 }
     }
 })//end app


 //添加资源
 $('#datatable').on('click','.btnAdd',function(){
     var id = $(this).attr('data-id')
     var name = $(this).attr('data-name')
     app.add({id:id,name:name})
 })

 //固定选择区域
 $('#inner-content-div').slimScroll({
     height: '400px',
     railVisible: true,
	 //alwaysVisible: true
 });
</script>
