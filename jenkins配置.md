
https://www.jenkins.io/
http://www.idevops.site/jenkins/

启动后一直提示Please wait while Jenkins is getting ready to work...？

cd .jenkins/updates/ 到jenkins的工作目录下
vim default.json
把 "connectionCheckUrl":"http://www.google.com/" 改为  "connectionCheckUrl":"http://www.baidu.com/"

