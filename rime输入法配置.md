安装rime五笔后怎么配置生效
```
cd ~/.config/ibus/rime
cp /usr/share/rime-data/wubi* ./
```

修改rime后重启ibus命令
```
/usr/bin/ibus restart
```

备注：
如果有奇怪的问题，重启电脑
删除过一次rime文件夹下的配置文件，死活恢复不了，最后参考下面百度的文章，
新建了default.custom.yaml
然后重启，发现配置文件恢复


参考：
(https://jingyan.baidu.com/article/4853e1e5b090a31909f7269c.html)
```
一、先安装必备程序

1、sudo apt install ibus-rime（安装rime输入法）

2、sudo apt install librime-data-wubi（安装五笔库）

3、sudo apt install librime-data-pinyin-simp （安装简体拼音库）

二、在 ~/.config/ibus/rime/ 下新建一个文件  default.custom.yaml （覆盖默认设置）

内容是：

patch:
   schema_list:
       - schema: wubi_pinyin
       - schema: pinyin_simp
       - schema: wubi86

说明：schema 是输入法顺序，如果仅用拼音或五笔，则将对应的项移到最前面，本人要五笔拼音一起混用，所以将wubi_pinyin放到了前面。

并且修改

 wubi_pinyin.schema.yaml 

switches下的reset 值由0改为1，意思是重启后默认由中文状态改为英文状态。


三、重启操作系统，使安装生效。


四、打开“setting（设置）”，“Region&Language（区域和语言）”，点+号，添加输入法 Chinese(Rime) 。如果不用其它输入法，可以删除，其实也真不用其它输入法了


五、在系统右上角选择 输入法，下拉、部署 。（意思是重新载入）

并重启操作系统
```
