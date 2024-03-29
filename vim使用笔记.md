## 基础
vim的配置文件位置： .vimrc, /etc/vimrc  
  
移动光标：  
  
方向键             h j k l  
基于单词移动        b e w  
批量移动光标        8j 8k  
光标移到居中        zz  
全文首尾行          gg G  
某行首              :22  
  
一行中查找字母      fb Fb 向后向前定位到本单词  
                  t" T" 向后向前定位到本单词附近  
  
{}[]()对应括号      %  
行首行尾            0 行首  ^句子首 $句子尾  
  
查找本单词         * 向后查找光标所在单词 # 向前查找光标所在单  
  
  
查找                /hello 向后查找 ?hello 向前查找  
                   * 向后查找光标所在单词 # 向前查找光标所在单  
                   n 继续查找 N 反向查找  
  
  
批量输入            30i-Esc 4a*Esc  
  
替换           r 替换单子母  
              :s/bad/good     替换行内首个单词  
              :s/bad/good/g   替换行内全部单词  
              :s/bad/good/gc   c 提示确认  
              :%s/bad/good/gc  % 全部替换  
              :s/bad/good/gi   i 大小写不敏感  
              :3,7s/bad/good/gc  3-7行替换  
插入一行            o O  
删除                x X  
  
粘贴                p 3p  
操作  
      分别选择这些配对标点符号中的文本内容  
            vi'  vi"  vi(或vib  vi{或viB  vi[  vi<  
        其中d为剪切,  
        其他操作为  
            c 修改  
            v 选择  
            y 复制  
            d 剪切  
          其中i可以换为a 例如 va(或vab 可以选择上括号和里面的内容  
             i可以换为t 例如 vt( 从当前光标到(  
                           vt" 从当前到"  
其他选择范围操作  
            vip 选择连续行  
            vis 选择一段内容（段首开头于行）  
  
            v3l    l选择向后移动5个字母  
                   l同理 h  j  k 方向键  
                         w  e  b 单词移动  
                         0  ^  $ 行内移动  
  
删除      x删除       3x删3个字  D删到行尾  
		  :3,5d删3到5行   dG删到文章尾  
  
重复上个命令        .  
虚拟模式选择        ve vw vW vi" va" vis vap  
撤销重做            u C+r  
同时打开切换        :e <path>  :bn  
  
  
p粘贴在行下 P粘贴在行上  
替换      r替换一个   R开始替换  
  
插入一块注释  
    1 Ctrl+v 进入VISUAL BLOCK模式  
    2 移动箭头  
    3 Shift+i进入INSERT模式，按#  
    4 按Esc  
取消注释：第3步按x  
  
保存退出  
          保存readonly        :w !sudo tee %  
          :w 保存   :w name.php 另存  
		  :wq == ZZ 保存退出  
		  :wq! 强制保存退出  
		  :q 不保存退出  
		  :q! 强制不保存退出  
一些命令  
		  :set nu设置行号  :set nonu取消行号  
		  :set nohls设置vim中空格不显示颜色块  
		  :r name.php 导入文件内容  
		  :which ls 不退出vim的情况下使用命令  
快捷键设置  
		  map (crl+v crl+字母) 命令  定义快捷键  
  
          ab mymail kyronbao@gmail.com  
		  ab myWeb www.kyronbao.com  

  
粘贴缩进混乱  
  已配置vimrc, 按F12  
     set pastetoggle=<F12> "粘贴时缩进混乱处理  
  
插入时间  
  配置vimrc, 按F3  
    :map <F3> :r! date +"\%Y-\%m-\%d \%H:\%M:\%S"<cr>  
  输入下面的命令：  
  : r !date  
  或从输入模式返回到命令模式后，直接输入下面的命令  
  
  
## 复制粘贴
按住ctrl + shift,  然后移动鼠标选取, 之后普通的复制粘贴即可.

当然, 说是普通的复制, 也得看你用的啥终端, 直接ctrl +c 一般都会关闭你的vim, 大部分终端下的复制都是 ctrl + shift + C, 这样就更顺手了.首先鼠标模式至少要持支insert, 我这里比较容易一点, 直接 set mouse = a然后复制的时候, 按住ctrl + shift,  鼠标就可以自由选择需要复制的矩形范围了, 形同截图~Manjaro / Arch 下本机亲测有效, 另外 SSH连接远程服务器下的VIM一样有效. 

原理上说, 应该是在按住shift键时,  vim就把鼠标的活动交给X去处理了, 因此无论本地还是远程都有效,  加上ctrl是因为单shift 的话是针对整个window, 而加ctrl只针对整个buffer.  

作者：彭亚伦 链接：https://www.zhihu.com/question/19863631/answer/1821367137 
## 复制粘贴(没用)
  
```
vim 有些版本不支持系统剪贴板
```
通过下面命令查看  
```
vim --version | grep clipboard
```
如果显示 -clipboard代表不支持 +clipboard代表支持  
  
ubuntu下推荐安装：  
```
sudo apt-get install vim-gnome
```
archlinux推荐安装：  
```
sudo pacman -S gvim
```
  
vim复制一行到系统剪贴板  
"+yy  
在不同的vim，或terminal中粘贴  
Ctrl+Shift+v  
  
在vim中可以查看寄存器中的内容  
:reg "*+  
 " 默认的unamed寄存器  
 * 系统剪贴板，鼠标选中的内容  
 + 系统剪贴板，使用"+y的内容  
  
注意：使用:q :wq等退出后不能使用  
- https://www.zhihu.com/question/19863631
具体操作  
鼠标从 terminal 复制到 terminal  
  
  鼠标选取复制到 "* ，然后鼠标中键粘贴  
  
  鼠标选取，Ctrl+Shift+c 复制，Ctrl+Shift+v 粘贴  
鼠标从vim 复制到 ”*  
  复制：Shift 鼠标选择  
  
从 vim 复制到其他地方  
设置  
:set clipboard=unnamedplus  
经在archlinux测试，设置后，鼠标中键复制无效  
参考vim wiki  
Vim commands such as :yank or :paste operate with the unnamed register, which by default corresponds to the "* register. If the +clipboard feature is available, the "* register is reflected to the PRIMARY buffer in X.  
  
To change the default register, you can :set clipboard=unnamedplus to use the "+ register instead. The "+ register corresponds to the CLIPBOARD buffer in X.  

