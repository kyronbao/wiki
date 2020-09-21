环境 debian9/deepin15.11

下载的破解文件astah-pro.jar替换位置/usr/lib/astah_professional/

由于astah-pro 依赖java1.8, 当本地java改为其他版本时 报错，可以配置下启动脚本

vim /usr/bin/astah-pro

定义$JAVA_LOCAL="/usr/lib/jvm/java-8-openjdk-amd64/jre/bin/java"
把里面的java命令改成用$JAVAL_LOCAL表示

参考
 https://blog.csdn.net/zxllynu/article/details/82289171
