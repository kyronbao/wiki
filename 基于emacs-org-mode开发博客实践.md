## css隐藏滚动条
chrome浏览器测试  
```
pre.example::-webkit-scrollbar {
    display: none;
}

pre.example {
    overflow-x: scroll;
}
```
其他的  
```
overflow: hidden;
```
参考 [Hide scroll bar, but while still being able to scroll](https://stackoverflow.com/questions/16670931/hide-scroll-bar-but-while-still-being-able-to-scroll)  
  
## 手机屏幕适配css知识
  
px = dp (dpi / 160)  公式中dpi也就是ppi 参考[fn:231]  
360px = 196 (294 /160) 红米手机  
540px ＝ 196 (441 / 160)  华为 所以 108  
  
[fn:231] [如何知道手机屏幕的CSS像素宽度？](http://www.webhek.com/post/device-pixel-and-css-pixel.html)  
[Android 屏幕密度解惑](http://liukun.engineer/2016/11/27/%E5%B1%8F%E5%B9%95%E5%AF%86%E5%BA%A6%E8%A7%A3%E6%83%91/)  
http://detail.zol.com.cn/1171/1170042/param.shtml 华为nova2参数  
[每英寸像素wiki](https://zh.wikipedia.org/wiki/%E6%AF%8F%E8%8B%B1%E5%AF%B8%E5%83%8F%E7%B4%A0)  
http://blog.qiji.tech/archives/10167 结尾有些推荐的@media写法  
  
## css 在手机端需要放大字体像素的解决办法
  
meta标签内加入  
  : <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
参考 https://developer.mozilla.org/zh-CN/docs/Mobile/Viewport_meta_tag 在移动浏览器中使用viewport元标签控制布局  
  
## css 在html标签外出现空白的解决办法
原因大多要是因为行内字体超出容器宽度，所以导致浏览器增加横向滚动条显示超出的部分  
pre标签下可采用 =overflow-x:scroll=  
https://greyli.com/white-space-appears-on-the-right-side-of-the-page-try-this-css-debugger/ 推荐了[ GhostPage](https://chrome.google.com/webstore/detail/ghostpage/hegpcollkgldlimbhkimijhhhoaicipp) 扩展用起来不错  
  
  
  
  
## 博客css设置目录目录固定
  CLOCK: [2017-12-22 五 17:40]--[2017-12-22 五 17:40] =>  0:00  
  
参考  
[[https://readthedocs.org/][Read the Docs]] [Getting Started](https://docs.readthedocs.io/en/latest/getting_started.html#in-rst) 主要使用两种语法  
 - In reStructuredText
 - In Markdown
  参考  
```
reStructuredText 是扩展名为.rst的纯文本文件，含义为"重新构建的文本"，也被简称为：RST或reST；是Python编程语言的Docutils项目的一部分，Python Doc-SIG (Documentation Special Interest Group)。该项目类似于Java的JavaDoc或Perl的POD项目。 Docutils 能够从Python程序中提取注释和信息，格式化成程序文档。

.rst 文件是轻量级标记语言的一种，被设计为容易阅读和编写的纯文本，并且可以借助Docutils这样的程序进行文档处理，也可以转换为HTML或PDF等多种格式，或由Sphinx-Doc这样的程序转换为LaTex、man等更多格式。

作者：seayxu
链接：https://www.jianshu.com/p/1885d5570b37
來源：简书
著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。
```
## 重写一个简单的scheduled的css版本
  
  
## 学慕课网css 侧栏工具条开发 课程
  CLOCK: [2017-12-20 三 09:54]--[2017-12-20 三 11:05] =>  1:11  
   https://www.imooc.com/learn/425  
  
## 移动端css字体调节时，字体突然变大问题解决
调试时移动端，不管在chrome模拟时或在手机上真实测试时，调整css font-size时，用chrome逐渐跳转变大时，测试效果字体会突然变大，搜索问题才发现这是webkit内核下的特性 Text Autosizer」，又称「Font Boosting」、「Font Inflation」导致的  
解决  
    给元素设置 -webkit-text-size-adjust: none;  
参考 [开发移动端页面时，字体自动变大解决](http://www.jianshu.com/p/b62e081fd53f)  
  
  
## 博客css调整目录固定到左侧
  CLOCK: [2017-12-18 一 09:32]--[2017-12-18 一 15:47] =>  6:15  
调整了快一个小时的css,依然没有进展。原来打算在网上一个版本的基础上逐步修改为适配移动端的css，现在发现困难重重。现在决定，开始重写一版本的css,实现在电脑端和手机端自适应的效果。顺便也学学css3,sass等知识点  
  
## 利用chrome对css对本地文件实时编辑
前端调整css时，经常需要在本地编辑器和浏览器之间切换。chrome浏览器提供了工作区的概念，实现了在浏览器调整查看效果后实时保存到本地文件的功能，可谓前端必备神器。  
  
操作步骤参考https://developers.google.com/web/tools/setup/setup-workflow?hl=zh-cn  
  
## 让博客适配手机端准备工作完成
  - 配置通过chrome浏览器实时修改css功能
  - 配置手机端可以实时查看
  - 按每次写的博客内容调整手机端css
  
  
  
## 文件目录同步研究
打算把博客～/blog/src 实时同步到～/Documents/blog/src，实现编辑css时能同步到另一个目录  
  
参考资料有python定时实现更新的简单脚本，也有服务器间 [rsync+sersync单向文件实时同步配置详解](http://www.madown.com/2017/05/10/rsyncsersync%E5%8D%95%E5%90%91%E6%96%87%E4%BB%B6%E5%AE%9E%E6%97%B6%E5%90%8C%E6%AD%A5%E9%85%8D%E7%BD%AE%E8%AF%A6%E8%A7%A3/) 的方案，待有空了在学习  
[How to sync two folders with command line tools?](https://unix.stackexchange.com/questions/203846/how-to-sync-two-folders-with-command-line-tools) 也是推荐一个工具，待参考  
answer  
生成的博客html css直接链接到=～/blog/src=目录，实现本地只有一份css文件，管理，提交也方便。src目录下其他文件也使用通用的方案。  
  
  
  
  
## emacs导出html,pdf等格式的方法
## 设置emacs定制导出html,pdf等格式
### 方法一 配置emacs设置html模板
  
### 方法二 emacs通过muse插件导出各种格式
需要配置muse插件，文件后缀名为.muse，对常用org-mode的人来说muse又是另一套语法，较麻烦，所以放弃使用  
```
Emacs Muse 是 Emacs 的一个扩展插件，它的前身就是 Emacs Wiki。由于 Emacs Wiki Mode 原作者 Michael Olson 需要重新架构代码，才另外创立了一个新的 Emacs Muse 项目。通过该插件，我们可以在 Emacs 中写 Wiki 文档，生成各种格式，包括网页，pdf ，DocBook ，LaTex 等等，并可以直接发布到网络中。
```
参考  
[用 Emacs Muse 来制作测试结果报告](https://www.ibm.com/developerworks/cn/linux/l-cn-emacsmuse/index.html)  
[Muse Markup 语法指南](http://vision.ouc.edu.cn/~zhenghaiyong/projects/muse/QuickStart-zh_cn.html#sec3)  
## org-mode导出pdf文件时没有中文
emacs通过～C-c C-e l p～命令导出文件时中文无法显示  
  
Answer  
### 配置emacs与在org文件头添加参数
默认的配置使用latex来导出org为pdf, 但是这样的活是不支持中文的, 因此要修改配置让org导出时用xelatex(当然前提是系统里装了这个). 在.emacs文件中加入以下代码:  
```
;; set latex to xelatex
(setq org-latex-pdf-process '("xelatex -shell-escape -interaction nonstopmode %f"
                              "xelatex -shell-escape -interaction nonstopmode %f"))
```
上面xelatex命令的参数-shell-escape是为了调用minted包, 如果不加这个参数,代码高亮这部分会出错.  
  
同时在编辑org文件时, 还要在开头添加metadata:  
```
#+LATEX_HEADER: \usepackage{xeCJK}
#+LATEX_HEADER: \setCJKmainfont{Songti SC}
```
这两行的作用是在生成的.tex文件中加入两行引入xeCJK包, 并设置中文的字体,这样在用xelatex编译.tex文件就不会出错.  
参考 http://www.kohn.com.cn/wordpress/?p=78  
  
### ubuntu默认支持的latex不支持中文，所以安装xelatex
```
sudo apt-get install texlive-full
sudo apt-get install texlive-xetex latex-cjk-all
sudo apt-get install texmaker
```
参考 [Ubuntu安装支持中文的Latex----xelatex](https://sites.google.com/site/cssolutionbook/doc/page-4)  
### 设置中文字体
查看emacs使用的中文字体，我使用的是 cnfonts ，查看 =~/.emacs.d/cnfonts/cnfonts.el= ，所以在org文件头添加代码 =#+LATEX_HEADER: \setCJKmainfont{微软雅黑}=  
  
## 基于Docker的自动部署方案
参考 [5分钟搭建基于Docker的静态服务器](https://antscript.com/post/2016-02-26-dockerweb/)  
  
## 有空弄弄从org模式转换为html,可定制css的样式
缘由  
emacs org-mode 生成的html带有固定的css类和html结构，定制性有局限性  
打算再次学一下响应式布局，如果能用在自己的博客，日程管理的html实现上，岂不是很爽  
  
又读过了一遍 [[http://xiaohanyu.me/posts/2014-05-04-build-static-site-with-nanoc-1/][Build Static Site with Nanoc (I)]] 了解了 [static site generator](https://staticsitegenerators.net/) 的概念，鉴于折腾的复杂度，再一次暂时打消了从org到html手动定制的念头。  
