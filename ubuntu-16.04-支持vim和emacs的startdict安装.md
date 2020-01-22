  
安装ui版 sudo apt install stardict  
  安装本地词典 http://download.huzheng.org/  
  tar -xjvf star....tar.bz2 -C /usr/share/stardict/dic  
安装命令行版 sudo apt install sdcv  
  
  
支持vim翻译  
  ~/.vim/plugin/sdcv.vim  
  
function! Mydict()  
  "执行sdcv命令查询单词的含义,返回的值保存在expl变量中  
  let expl=system('sdcv -n ' . expand("<cword>"))  
  "在每个窗口中执行命令，判断窗口中的文件名是否是dict-tmp，如果是，强制关闭  
  windo if expand("%")=="dict-tmp" |q!|endif  
  "纵向分割窗口，宽度为25，新窗口的内容为dict-tmp文件的内容  
  25vsp dict-tmp  
  "设置查询结果窗口的属性，不缓存，不保留交换文件  
  setlocal buftype=nofile bufhidden=hide noswapfile  
  "将expl的内容显示到查询结果窗口  
  1s/^/\=expl/  
  "跳转回文本窗口  
  wincmd p  
endfunction  
g"按键绑定，将调用函数并执行  
nmap F :call Mydict()<CR>  
  
  
用法：  
  非编辑模式下 调用 shift + f  
  退出 C-w o  
  
man 模式下 !sdcv hello  
  
参考http://renwolang521.iteye.com/blog/1317789  
    http://blog.codepiano.com/2012/03/24/translate-word-under-cursor-in-vim  
  
支持emacs  
;; author: pluskid  
;; 调用 stardict 的命令行接口来查辞典  
;; 如果选中了 region 就查询 region 的内容，  
;; 否则就查询当前光标所在的词  
(global-set-key [mouse-3] 'kid-star-dict);;鼠标右键  
(defun kid-star-dict ()  
  (interactive)  
  (let ((begin (point-min))  
        (end (point-max)))  
    (if mark-active  
        (setq begin (region-beginning)  
              end (region-end))  
      (save-excursion  
        (backward-word)  
        (mark-word)  
        (setq begin (region-beginning)  
              end (region-end))))  
    ;; 有时候 stardict 会很慢，所以在回显区显示一点东西  
    ;; 以免觉得 Emacs 在干什么其他奇怪的事情。  
    (message "searching for %s ..." (buffer-substring begin end))  
    (tooltip-show  
     (shell-command-to-string  
      (concat "sdcv -n "  
              (buffer-substring begin end))))))  
