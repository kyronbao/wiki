

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
              :s/bad/good/gi   i 大小写敏感  
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
  
复制粘贴  
  参考Linux笔记  
  
  
粘贴缩进混乱  
  已配置vimrc, 按F12  
     set pastetoggle=<F12> "粘贴时缩进混乱处理  
  
插入时间  
  配置vimrc, 按F3  
    :map <F3> :r! date +"\%Y-\%m-\%d \%H:\%M:\%S"<cr>  
  输入下面的命令：  
  : r !date  
  或从输入模式返回到命令模式后，直接输入下面的命令  
