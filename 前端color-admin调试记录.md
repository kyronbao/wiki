## 多个表格，不能绘制显示
desc 能ajax返回数据，但是不能在页面显示出来，提示处理中...  
answ 删掉页面的data-sort-id，导致的冲突解决  
## div js click on 等事件失效
@section('admin-content')  
    <div id="content" class="content">  
        <!-- begin breadcrumb -->  
        <ol class="breadcrumb pull-right">  
            <li><a href="javascript:;">主页</a></li>  
            <li><a href="javascript:;">资源管理</a></li>  
            <li class="active">新增资源</li>  
        </ol>  
        <!-- end breadcrumb -->  
        <!-- begin page-header -->  
        <h1 class="page-header">新增资源 <small></small></h1>  
        <!-- end page-header -->  
  
        <!-- begin row -->  
        <div class="row">  
            {{--<!-- begin col-6 加上这层div js click on 等事件失效 -->--}}  
            {{--<div class="col-md-12">--}}  
