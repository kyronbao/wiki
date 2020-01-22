  
## Rename pip Import Error:cannot import name main
后来发现是因为将pip更新为10.0.0后库里面的函数有所变动造成这个问题。  
  
```
Traceback (most recent call last):
  File "/usr/bin/pip", line 9, in <module>
    from pip import main
ImportError: cannot import name main
```
解决方案：  
```
sudo vim /usr/bin/pip
```
  
将原来的：  
```
from pip import main
if __name__ == '__main__':
    sys.exit(main())

```
  
改成：  
```
from pip import __main__
if __name__ == '__main__':
    sys.exit(__main__._main())
```
就OK了  
  
