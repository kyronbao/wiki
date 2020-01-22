  
- [[https://zh.cppreference.com/w/c]]
  
- [C 标准库头文件](https://zh.cppreference.com/w/c/header)
- gcc 4.7开始支持 c11; Ubuntu 16.04 gcc版本：5.4.0
- 库文件位置 /usr/include/
- [[https://zh.cppreference.com/w/cpp/language/types][基础类型]] [32位与64位下各类型长度对比](https://blog.csdn.net/Sky_qing/article/details/11650497)
  
## 知识点
  
### 优先级
[]和()优先级相同，比*优先级高。  
### 复杂的声明
char * risk[]; 是数组，指针数组；  
char (*rusk) [10]; 是指针，指向数组的指针；  
  
### [printf宽度控制和精度控制](https://blog.csdn.net/yss28/article/details/53538063)
  
### [C、C++数据类型所占字节数](https://blog.csdn.net/u014492609/article/details/38067599)
  
### char 数组 字符串
char ch = 'a';  
char * str = {'a', 'b', 'c'};  
char arr[3] = {'a', 'b', 'c'};  
char * str2 = "abc";  
char arr2[3] = "abc";  
char *argv [];  // 指针数组  char **argv与char *argv[]等价  
### reurn() vs exit()
如果main()在一个递归程序  
中,exit()仍然会终止程序,但是return只会把控制权交给上一级递归,直至  
最初的一级。然后return结束程序。return和exit()的另一个区别是,即使在其  
他函数中(除main()以外)调用exit()也能结束整个程序  
### 记录
11.5.5 声明数组将分配储存数据的空间,而声明指针只分配储存一个地址的空间  
  
11.9 C要求用数值形式进行数值运算(如,加法和比较)。但是在屏幕上显示数字则要求字符串形式,因为屏幕显示的是字符。printf()和sprintf()函数,通过%d和其他转换说明,把数字从数值形式转换为字符串形式,scanf()可以把输入字符串转换为数值形式。  
  
12 C语言能让程序员恰到好处地控制程序,这是它的优势之一。  
  
12.1.8  
int traveler = 1;      // 外部链接  
static int stayhome = 1;  // 内部链接  
int main()  
{  
...  
对于该程序所在的翻译单元,trveler和stayhome都具有文件作用域,但  
是只有traveler可用于其他翻译单元(因为它具有外部链接)。  
  
### 待学习
  - 变长数组
  - 复合字面量
## 概念
### 字面量(literal)
字面量是除符号常量外的常量。例如,5是int类型字  
面量, 81.3是double类型的字面量,'Y'是char类型的字面量,"elephant"是字  
符串字面量。--10.9  
### 复合字面量(compound literal)
(int [2]){10, 20}  --10.9  
### 左值(lvalue)
1.它指定一个对象,所以引用内存中的地址;  
2.它可用在赋值运算符的左侧,左值(lvalue)中的l源自left。  
  
一般而言,那些指定对象的表达式被称为左值(第5章介绍过)。 --12.1  
### 可修改的左值(modifiable lvalue)
用于标识可修改的对象  
### 对象
用于储存值的数据存储区域统称为数据对象(data object)。  
  
  本书目前所有编程示例中使用的数据都储存在内存中。从硬件方面来  
看,被储存的每个值都占用一定的物理内存,C 语言把这样的一块内存称为  
对象(object)。对象可以储存一个或多个值。一个对象可能并未储存实际  
的值,但是它在储存适当的值时一定具有相应的大小。  
### 标识符
int entity = 3;  
该声明创建了一个名为entity的标识符(identifier)。  
  
### 概念解释
const char * pc = "Behold a string literal!";  
程序根据该声明把相应的字符串字面量储存在内存中,内含这些字符值  
的数组就是一个对象。由于数组中的每个字符都能被单独访问,所以每个字  
符也是一个对象。该声明还创建了一个标识符为pc的对象,储存着字符串的  
地址。由于可以设置pc重新指向其他字符串,所以标识符pc是一个可修改的  
左值。const只能保证被pc指向的字符串内容不被修改,但是无法保证pc不指  
向别的字符串。由于*pc指定了储存'B'字符的数据对象,所以*pc  
是一个左值,但不是一个可修改的左值。与此类似,因为字符串字面量本身指定了储  
存字符串的对象,所以它也是一个左值,但不是可修改的左值。  
### 文件(file)
通常是在磁盘或固态硬盘上的一段已命名的存储区。  
## 语言比较
### C和Javascript的遍历作用域
C中变量在块中的作用域是从定义后到块结束；  
Javascript中有变量提升的概念，变量定义后在作用域为整个块区域。  
### PHP和C
  
字符串  
  
在C中，字符串可以用数组和指针来表示。比如：  
  
char heart[] = "I love Tillie!";  
const char *head = "I love Millie!";  
两者主要的区别是:数组名heart是常量,而指针名head是变量；  
  
区别：只有指针表示法可以进行递增操作:  
while (*(head) != '\0')  /* 在字符串末尾处停止*/  
putchar(*(head++));  /* 打印字符,指针指向下一个位置 */  
  
const char * pl = "Klingon";  // 推荐用法  
