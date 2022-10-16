## awesome
- 手册
  - https://zh.cppreference.com/w/c/program
  - http://www.shouce.ren/api/c/index.htm
  
- 书籍推荐
  - https://www.cnblogs.com/ggjucheng/archive/2012/11/18/2776280.html
  -http://www.ruanyifeng.com/blog/2011/09/c_programming_language_textbooks.html
  - https://github.com/szaydel/c-primer-plus-book-6ed C Primer Plus 源码
  
  - [[http://net.pku.edu.cn/~yhf/linux_c/][Linux 常用C函数（中文版）]失效
  - C语言程序-现代方法推荐的资源
    - http://c-faq.com/ [中文版](http://c-faq-chn.sourceforge.net/ccfaq/index.html)
    - [如果对C库有疑问,可以访问这个站点获得信息](https://www-s.acm.illinois.edu/webmonkeys/book/c_guide/index.html)
    - [A TUTORIAL ON POINTERS AND ARRAYS IN C](http://pweb.netcom.com/~tjensen/ptr/pointers.htm) 全面讨论指针
  
- 工具
  - 检查语法
    - splint
    - cppcheck
  - [Linux 下进行 C/C++ 开发一般使用什么开发环境？](https://www.zhihu.com/question/19848310)
  - [有用的C语言工具（Ubuntu Linux版本）](https://blog.csdn.net/jubincn/article/details/7284164)
  - https://askubuntu.com/questions/753635/lint-command-not-found
  - [how to i download and install lint](https://stackoverflow.com/questions/6881269/how-do-i-download-and-install-lint)

# 调试记录
  
## Segmentation fault (core dumped)

最后发现，错误原因为未输入输入参数，如下  
```
int main(int argc, char *argv[])
{
  int i, n = atoi(argv[1]);
...
```
运行程序时需要：=a.out 11= 格式，输入参数，不然会报如上错误。  
