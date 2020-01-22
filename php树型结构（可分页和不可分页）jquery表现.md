  
### 可分页版
从数组看依次取出10条id,在根据id取出相应的父节点数据，最后过滤10条里的重复数组  
#+ATTR_HTML: :textarea t :height 200  
```
private function createTree($array, $pid = 0)
{
    $ret = array();

    foreach($array as $key => $value){
        if($value['pid'] == $pid){
            $tmp = $value;
            unset($array[$key]);
            $tmp['list'] = $this->createTree($array, $value['id']);
            $ret[] = $tmp;
        }
    }

    return $ret;
}

private function array_multiToSingle($array,$clearRepeated=false)
{
    if(!isset($array)||!is_array($array)||empty($array)){
        return false;
    }
    if(!in_array($clearRepeated,array('true','false',''))){
        return false;
    }
    static $result_array=array();
    foreach($array as $value){
        if(is_array($value)){
            $this->array_multiToSingle($value);
        }else{
            $result_array[]=$value;
        }
    }
    if($clearRepeated){
        $result_array=array_unique($result_array);
    }
    return $result_array;
}


private function array_SingleTo2($array)
{
    static $result_array=array();
    $len = count($array)/10;
    for($i=0;$i<$len;$i++){
        $result_array[$i]['level'] = array_shift($array);
        $result_array[$i]['id'] = array_shift($array);
        $result_array[$i]['pid'] =array_shift($array);
        $result_array[$i]['name'] = array_shift($array);
        $result_array[$i]['user'] = array_shift($array);
        $result_array[$i]['auth'] = array_shift($array);
        $result_array[$i]['updated'] = array_shift($array);
        $result_array[$i]['title'] = array_shift($array);
        $result_array[$i]['user_id'] = array_shift($array);
        $result_array[$i]['comments_id'] = array_shift($array);
    }

    return $result_array;
}

private function array_addLevel($arr)
{

    foreach($arr as $key=>$val){

        array_unshift($arr[$key],0);

        if(isset($val['list']) && is_array($val['list']) && !empty($val['list'])){
            foreach($val['list'] as $k=>$v){
                array_unshift($arr[$key]['list'][$k],1);

                //
                if(isset($v['list']) && is_array($v['list']) && !empty($v['list'])){
                    foreach($v['list'] as $kk=>$vv){
                        array_unshift($arr[$key]['list'][$k]['list'][$kk],2);
                    }
                }
                //
            }
        }

    }

    return $arr;
}

function array_unique_2d($array2D){
    $temp = $res = array();
    foreach ($array2D as $v){
        $v = json_encode($v);  //降维,将一维数组转换字符串
        $temp[] = $v;
    }
    $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
    foreach ($temp as $item){
        $res[] = json_decode($item,true);   //再将拆开的数组重新组装
    }
    return $res;
}

/**
 * 管理端AJAX数组
 * @param Request $request
 * @param String 'comments_resource'
 * @return mixed
 */
public function listResourceIndex(Request $request)
{
    $draw = $request->input('draw', 1);
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);
    $auth = intval($request->input('auth', 0));
    $order['name'] = $request->input('columns.' . $request->input('order.0.column').'.name');
    $order['dir'] = $request->input('order.0.dir', 'asc');
    $search['value'] = $request->input('search.value', '');
    $search['regex'] = $request->input('search.regex', false);

	//$model = DB::table('comments_resource as cr');
	//
	//if ($search['value']) {
	//    if ($search['regex'] == 'true') {//传过来的是字符串不能用bool值比较
	//        $model = $model->where('title', 'like', "%{$search['value']}%");
	//    } else {
	//        $model = $model->where('title', $search['value'])->orWhere('title', $search['value']);
	//    }
	//}
	//$model = $model->leftJoin('comments as c', 'c.comments_id', '=', 'cr.comments_id');
	//$model = $model->leftJoin('users as u', 'u.id', '=', 'cr.user_id');
	//$count = $model->count();
	//
	//
	//$model = $model->orderBy('cr.updated_at', $order['dir']);
	//$arr = $model->offset($start)->limit($length)->get([
	//    'level','comments_resource_id as id','parent_id as pid','txt as name','u.name as user',
	//    'is_check as auth','cr.updated_at as updated','title','cr.user_id','cr.comments_id']);
	//$auth = Comments::COMMENTS_CHECK_ING;

    if($auth == '0'){

        $arr0 = DB::select('
                    SELECT comments_resource_id as id
                    FROM comments_resource t2
                    LEFT JOIN comments as c ON c.comments_id = t2.comments_id
                    LEFT JOIN users as u ON u.id = t2.user_id
                    WHERE t2.is_check = '.$auth.'
                    ORDER BY t2.comments_resource_id
                ');

        $arr1 = DB::select('
                    SELECT comments_resource_id as id
                    FROM comments_resource t2
                    LEFT JOIN comments as c ON c.comments_id = t2.comments_id
                    LEFT JOIN users as u ON u.id = t2.user_id
                    WHERE t2.is_check = '.$auth.'
                    ORDER BY t2.comments_resource_id
                    LIMIT 10 OFFSET 0;
                ');

        $arr2 = [];
        foreach($arr1 as $val){
            $arr2[]= DB::select('
                SELECT level,comments_resource_id as id,parent_id as pid,txt as name,u.name as user,
                    is_check as auth,t2.updated_at as updated,title,t2.user_id,t2.comments_id
                FROM (
                    SELECT
                            @r AS _id,
                            (SELECT @r := parent_id as pid FROM comments_resource WHERE comments_resource_id = _id) AS pid,
                             @l := @l + 1 AS lvl
                    FROM
                            (SELECT @r := '.$val->id.', @l := 0) vars,
                            comments_resource h
                    WHERE @r <> 0) t1
                JOIN comments_resource t2 ON t1._id = t2.comments_resource_id
                LEFT JOIN comments as c ON c.comments_id = t2.comments_id
                LEFT JOIN users as u ON u.id = t2.user_id
                ORDER BY t2.comments_resource_id
            ');

        }

        $arr3 = [];
        foreach($arr2 as $val){
            foreach($val as $v){
                array_push($arr3, $v);
            }
        }

        $arr = $this->array_unique_2d($arr3);

        $count = count($arr0);

    }else{

        $arr12 = DB::select('
                SELECT comments_resource_id as id
                FROM comments_resource t2
                LEFT JOIN comments as c ON c.comments_id = t2.comments_id
                LEFT JOIN users as u ON u.id = t2.user_id
                WHERE t2.is_check = '.$auth.';
            ');

        $arr11 = DB::select('
                SELECT level,comments_resource_id as id,parent_id as pid,txt as name,u.name as user,
                    t2.is_check as auth,t2.updated_at as updated,title,t2.user_id,t2.comments_id
                FROM comments_resource t2
                LEFT JOIN comments as c ON c.comments_id = t2.comments_id
                LEFT JOIN users as u ON u.id = t2.user_id
                WHERE t2.is_check = '.$auth.'
                ORDER BY t2.comments_resource_id
                LIMIT '.$length.' OFFSET '.$start.';
            ');
        $arr = json_decode(json_encode($arr11), true);

        $count = count($arr12);
    }


	//$arr = json_decode(json_encode($arr1), true);
	//$arr = $this->createTree($arr);
	//$arr = $this->array_multiToSingle($arr);
	//$arr = $this->array_SingleTo2($arr);

    return [
        'draw' => $draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $arr
    ];
}
```
参考 [php函数二维数组惟一过滤](http://www.dewen.net.cn/q/1511/%E5%A6%82%E4%BD%95%E5%AF%B9php+%E5%81%9A%E4%BA%8C%E7%BB%B4%E6%95%B0%E7%BB%84%E7%9A%84array_unique)  
### 不可分页版
控制器二维变嵌套，再变一维，再变二维返回前端  
```
function createTree($array, $pid = 0)
{
    $ret = array();

    foreach($array as $key => $value){
        if($value['pid'] == $pid){
            $tmp = $value;
            unset($array[$key]);
            $tmp['list'] = $this->createTree($array, $value['id']);
            $ret[] = $tmp;

        }
    }

    return $ret;
}


function array_multiToSingle($array,$clearRepeated=false)
{
    if(!isset($array)||!is_array($array)||empty($array)){
        return false;
    }
    if(!in_array($clearRepeated,array('true','false',''))){
        return false;
    }
    static $result_array=array();
    foreach($array as $value){
        if(is_array($value)){
            $this->array_multiToSingle($value);
        }else{
            $result_array[]=$value;
        }
    }
    if($clearRepeated){
        $result_array=array_unique($result_array);
    }
    return $result_array;
}

function array_SingleTo2($array){
    static $result_array=array();
    $len = (count($array)+1)/3-1;
    for($i=0;$i<$len;$i++){
        $result_array[$i]['id'] = array_shift($array);
        array_shift($array);
        $result_array[$i]['name'] = array_shift($array);
    }

    return $result_array;
}

public function index()
{
    $arr = array(
        array('id'=>1,'pid'=>0,'name'=>'1'),
        array('id'=>2,'pid'=>1,'name'=>'1-1'),
        array('id'=>3,'pid'=>0,'name'=>'2'),
        array('id'=>4,'pid'=>3,'name'=>'3-3'),
        array('id'=>5,'pid'=>3,'name'=>'3-4'),
        array('id'=>6,'pid'=>1,'name'=>'1-2')
    );

    $arr = $this->createTree($arr);
    $arr = $this->array_multiToSingle($arr);
    $arr = $this->array_SingleTo2($arr);
    dd($arr);die;

    $tree = json_encode($this->createTree($arr), JSON_UNESCAPED_UNICODE);

    return view('admin.comments.index',['tree'=>$tree]);
}
```
### 参考版 json树形数组->html
  
var menulist = {  
    "menulist": [  
        { "MID": "M001", "MName": "首页", "Url": "#", "menulist": "" },  
        { "MID": "M002", "MName": "车辆买卖", "Url": "#", "menulist":  
            [  
                { "MID": "M003", "MName": "新车", "Url": "#", "menulist":  
                    [  
                        { "MID": "M006", "MName": "奥迪", "Url": "#", "menulist": "" },  
                        { "MID": "M007", "MName": "别克", "Url": "#", "menulist": "" }  
                    ]  
                },  
                { "MID": "M004", "MName": "二手车", "Url": "#", "menulist": "" },  
                { "MID": "M005", "MName": "改装车", "Url": "#", "menulist": "" }  
            ]  
        },  
        { "MID": "M006", "MName": "宠物", "Url": "#", "menulist": "" }  
    ]  
};  
  
$("#click").click(function () {  
     var showlist = $("<ul></ul>");  
     showall(menulist.menulist, showlist);  
     $("#tree").append(showlist);  
});  
  
  
//menu_list为json数据  
//parent为要组合成html的容器  
function showall(menu_list, parent) {  
    for (var menu in menu_list) {  
        //如果有子节点，则遍历该子节点  
        if (menu_list[menu].menulist.length > 0) {  
            //创建一个子节点li  
            var li = $("<li></li>");  
            //将li的文本设置好，并马上添加一个空白的ul子节点，并且将这个li添加到父亲节点中  
            $(li).append(menu_list[menu].MName).append("<ul></ul>").appendTo(parent);  
            //将空白的ul作为下一个递归遍历的父亲节点传入  
            showall(menu_list[menu].menulist, $(li).children().eq(0));  
        }  
        //如果该节点没有子节点，则直接将该节点li以及文本创建好直接添加到父亲节点中  
        else {  
            $("<li></li>").append(menu_list[menu].MName).appendTo(parent);  
        }  
    }  
 }  
  
参考 http://www.cnblogs.com/hxhbluestar/archive/2011/11/17/2252009.html  
### 优化版：php二维数组处理返回嵌套数组，前端循环变量显示
```

function createTree($array, $pid = 0){
    $ret = array();

    foreach($array as $key => $value){
        if($value['pid'] == $pid){
            $tmp = $value;
            unset($array[$key]);
            $tmp['list'] = $this->createTree($array, $value['id']);
            $ret[] = $tmp;
        }
    }

    return $ret;
}

public function index()
{
    $array = array(
        array('id'=>1,'pid'=>'0','name'=>'11111'),
        array('id'=>2,'pid'=>'1','name'=>'22222'),
        array('id'=>3,'pid'=>'0','name'=>'33333'),
        array('id'=>4,'pid'=>'3','name'=>'44444'),
        array('id'=>5,'pid'=>'4','name'=>'55555'),
        array('id'=>6,'pid'=>'1','name'=>'66666')
    );

    $tree = json_encode($this->createTree($array), JSON_UNESCAPED_UNICODE);

    return view('admin.comments.index',['tree'=>$tree]);
}

```
```

<button id="click">click</button>
            <div id="tree">

            </div>

var tree = {}
    tree.list = {!! $tree !!}

$("#click").click(function () {
    var showlist = $("<ul></ul>");
    showall(tree.list, showlist);
    $("#tree").append(showlist);
});

function showall(list, parent) {
    for (var index in list) {
        if (list[index].list.length > 0) {
            var li = $("<li></li>");
            $(li).append(list[index].name).append("<ul></ul>").appendTo(parent);
            showall(list[index].list, $(li).children().eq(0));
        }else {
            $("<li></li>").append(list[index].name).appendTo(parent);
        }
    }
}

