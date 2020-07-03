
## text/template
```
{{if .Attended}}
It was a pleasure to see you at the wedding.
{{- else}}
It is a shame you couldn't make it to the wedding.
{{- end}}
{{ with .Gift -}}
Thank you for the lovely {{.}}.
{{end}}
```
- https://golang.org/pkg/text/template/#example_Template

Text and spaces  
为了控制空格的显示，例如，{{- else}}里面的"-"会在显示时删除紧靠{{- else}}左边的空格，换行符等会被去掉  
Actions  
如上例，with指Gift参数有值时，会显示“Thank you for the lovely.”,和if,with类似的还有range，template,block这些  


## go 连接数据库实践

- https://golang.google.cn/pkg/database/sql/
- http://go-database-sql.org

### 阅读go-database-sql.org笔记
反直觉的是，sql.Open()并没有建立连接到数据库，而是准备了一个数据库的抽象供后面使用

sql.DB 对象是被设计来做长链接的，不要频繁的使用Open() 和Close() 。代替方案是，为需要的数据库创建一个 sql.DB 对象，直到连接数据库的程序结束。
这个对象可以用来传递，或者作为一个全局变量，在Open的状态下。



## Go包管理
https://github.com/golang/go/wiki/PackageManagementTools  

### modules实例
Go 在最新 1.11 版本，正式启用了真官方开发的包管理工具 module，已经集成到 go 命令中，它以前的名字叫 vgo。  
  
使用  
建议在GOPATH外目录创建项目 （如果在要在GOPATH中创建，需设置GO111MODULE=on）  
```
mkdir -p /tmp/scratchpad/hello
cd /tmp/scratchpad/hello

  
go mod init github.com/kyronbao/hello  

Write your code:  
  

cat <<EOF > hello.go

package main  
  
import (  
    "fmt"  
    "rsc.io/quote"  
)  
  
func main() {  
    fmt.Println(quote.Hello())  
}  
EOF  

Build and run:  


go build
./hello

 
Hello, world.  
```  
注意：go mod init 后面必须要添加包名  
  
构建的依赖安装在$GOPATH/pkg/mod目录下  
  
GoLand设置  
勾选setting -> Go Modules -> Enable GoModules  
  
  
参考  
https://github.com/golang/go/wiki/Modules  
https://farer.org/2018/11/11/go-modules-notes/  
  
### modeles管理go依赖
查看依赖  
```
go list -m all  # 查看所有的
go list -m rsc.io/q...  # 查看rsc.io/q开头的
go list -m -u -json all # -u提示可升级的依赖
```
查看依赖的所有版本
```
go list -m -versions rsc.io/sampler

rsc.io/sampler v1.0.0 v1.2.0 v1.2.1 v1.3.0 v1.3.1 v1.99.9
```
更新依赖
```
在目录中执行
go get rsc.io/sampler  # 更新依赖到最新版本
go get rsc.io/sampler@v1.3.1  # 当依赖不兼容时，更新到确定的版本
```
删除不需要的依赖
```
go list -m all # 查看所有的
go mod tidy # 删除
go list -m all # 查看结果
```
示例代码
```
package hello

import (
        "rsc.io/quote"
        quoteV3 "rsc.io/quote/v3"
)


func Hello() string {
    return quote.Hello()
}

func Proverb() string {
    return quoteV3.Concurrency()
}
```
如例子中所示，可以重命名来同时依赖两个主版本
v3
### govendor
gin的默认依赖管理  
  
使用govendor必须把项目目录放在GOPATH中，不然govendor init提示  
  Error: Package "/home/kyron/cart" not a go package or not in GOPATH.  
本项目安装目录 vendor  
  
  
Goland不需要配置即可运行main()  
  
go run命令也可以直接执行  
  
  
  
### gopm
beego的默认的依赖管理  
依赖安装在.vendor/目录，生成了.gopmfile文件，本地缓存在 ~/.gopm目录  
  
可以在任意目录建立项目 使用 gopm build  
  
使用策略  
项目目录可以不放在在$GOPATH下  
  
Goland配置：配置setting->Go->GOPATH  
Project GOPATH设置为 项目目录/.vendor  
  
go原生命令运行可配置临时环境变量  
GOPATH=$GOPATH:~/demo/.vendor  
  
  
操作  
```
vim .gopmfile
```
  
[target]  
path = demo  
键 path 指示了您的项目名称。  
  
构建项目  
```
gopm build -v
```
  
现在执行以下指令：  
  
```
./demo
```
您应该看到类似下面的输出：  
  
beego version: 1.4.0  
  
跟多配置参考 https://github.com/gpmgo/docs/blob/master/zh-CN/Quickstart.md  
  
## go安装
### Ubuntu安装Go
原因  
安装go get github.com/Go-zh/tour/gotour时发现报错  
  
package context: unrecognized import path "context" (import path does not begin with hostname)  
  
  参考 https://github.com/prometheus/collectd_exporter/issues/37  
context包在1.7版本加入的，而我的Ubuntu16默认的go版本是1.6.2,查询官网目前最新稳定版已经为1.11.2，所以来安装一波这个版本  
  
卸载旧版本  
```
sudo apt-get remove golang-go
sudo apt-get remove --auto-remove golang-go
```
  参考 https://askubuntu.com/questions/742078/uninstalling-go-golang  
  
从官网下载最新版  
```
wget https://dl.google.com/go/go1.11.2.linux-amd64.tar.gz
```
  
解压  
```
tar zxvf go1.11.2.linux-amd64.tar.gz
```
  
```
mv go/usr/local
mv go/usr/local
```
  
```
vim .bash_aliase
export GOPATH=$HOME/work
export PATH=$PATH:/usr/local/go/bin:$GOPATH/bin
```
  
```
source .bashrc
```
  
go version  
  
安装一个go程序  
```
mkdir -p go/src/github.com/kyronbao/hello
vim go/src/github.com/kyronbao/hello/hello.go
```
  
package main  
import "fmt"  
func main() {  
    fmt.Printf("hello, world\n")  
}  
  
go install github.com/kyronbao/hello  
  
执行  
hello  
打印提示成功  
  
备注  
当install地址写错时提示  
go install github/kyronbao/hello  
can't load package: package github/kyronbao/hello: cannot find package "github/kyronbao/hello" in any of:  
	/usr/local/go/src/github/kyronbao/hello (from $GOROOT)  
	/home/kyronbao/go/src/github/kyronbao/hello (from $GOPATH)  
### arch 从国内镜像安装Go
https://studygolang.com/dl  
下载后参考 doc/install.html  
  
```
tar -C /usr/local -xzf go$VERSION.$OS-$ARCH.tar.gz
```
  
```
vim /etc/bash.mine
export PATH=$PATH:/usr/local/go/bin
```
  
