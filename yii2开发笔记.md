## 文档
- [Yii2.0高级版开发指南（推荐）](http://www.yii-china.com/doc/detail/1.html)
- https://www.yiichina.com/doc/guide/2.0
  
## GridView::widget 关联表显示
[  
        'label' => '业务类型',  
        'attribute' => 'business_type',  
        'value' => function ($data) {  
  
            $tradeLog = $data->trade_log;  
            $businessType = $tradeLog ? $tradeLog->business_type : '';  
            return TradeLog::BUSINESS_TYPE[$businessType];  
        },  
        'filter' => Html::dropDownList('TradeOffline[business_type]',  
            $searchModel->trade_log->business_type,  
            TradeLog::BUSINESS_TYPE,  
            ['class' => 'form-control']),  
  
    ],  
  
  
  
TradeOffline  
  
    public $business_type;  
  
[[...'business_type'], 'safe'],  
  
    public function getTrade_log()  
    {  
        return $this->hasOne(TradeLog::className(), ['id' => 'trade_log_id']);  
    }  
  
        if ($this->business_type) {  
            $query->andFilterWhere(['trade_log.business_type' => $this->business_type]);  
        }  
  
- http://admin-baoqy.dev23.jiumiaodai.com/trade-offline/index
  
## save()
save(false) 不验正保存  
## copy model的属性到另一个model
you can get all models attributes by:  
  
$data = $model->attributes;  
and assign them to another model  
  
$anotherModel = new AnotherActiveRecord();  
$anotherModel->setAttributes($data);  
now another model will extract whatever it can from $data  
- https://stackoverflow.com/questions/30961807/yii-copying-data-from-one-model-to-another
## 用户 认证
控制器中可以使用 $this->identity()->user_id;  
  
配置  
  
return [  
    'components' => [  
        'user' => [  
            'identityClass' => 'app\models\User',  
        ],  
    ],  
];  
  
  
## 打印sql
$query = User::find()->where(['id'=>[1,2,3,4])->select(['username'])  
  
// 输出SQL语句  
$commandQuery = clone $query;  
```
echo $commandQuery->createCommand()->getRawSql();
```
  
$users = $query->all();  
- https://www.yiichina.com/tutorial/1060
  
## 数据库相关语法
  
$this->hasOne(User::className(), ['user_id' => 'user_id'])->where(['status' => User::STATUS_ACTIVE]);  
  
  
  
  
static::find()->where(['and', ['access_token.access_token' => $accessToken], [">", 'access_token.expired_time', time()]])->one();  
  
## load()不起作用
起因：  
1 我搜索的字段param发过来后load()貌似不起作用  
2 搜索的select选择后会返回[全部]，也是1原因引起的  
  
解决  
搜索 yii2 load() doesn't function  
- https://www.google.com/search?q=yii+load+don%27t+function&oq=yii+load+don%27t+function&aqs=chrome..69i57j69i64.10216j0j7&sourceid=chrome&ie=UTF-8
  
搜索得知 rule的字段为safe才可以加载  
  
## Grid http://demos.krajee.com/grid#grid-export 列表组件
## 获取当前url
For Yii2:  
