  
## Segmentation fault (core dumped)
最后发现，错误原因为未输入输入参数，如下  
```
int main(int argc, char *argv[])
{
  int i, n = atoi(argv[1]);
...
```
运行程序时需要：=a.out 11= 格式，输入参数，不然会报如上错误。  
