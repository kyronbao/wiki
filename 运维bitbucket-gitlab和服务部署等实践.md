## ubuntu安装完gitlab,bitbucket后变慢解决
安装完bitbucket后能感觉到打开程序，浏览器等操作变慢  
  
```
top
```
查到有gitlab运行(暂不删，后期研究要不要使用)  
```
systemd-analyze blame
```
发现postgresql，sendmail占用时间较多，删除这两个服务  
  
```
sudo systemctl disable gitlab-runsvdir.service
```
  
https://www.cnx-software.com/2016/08/09/how-to-resolve-slow-boot-times-in-ubuntu-16-04/  
## bitbucket等破解
  
Version:4.12.1  
  
查看 [Supported platforms](https://confluence.atlassian.com/bitbucketserver0412/supported-platforms-869179082.html) 硬件要求如下  
| CPU Evaluation: | 1 core   |  
| Production:     | 2+ cores |  
| Memory          | 3GB+     |  
  
```
wget https://downloads.atlassian.com/software/stash/downloads/atlassian-bitbucket-4.9.1-x64.bin
```
  
```
chmod +x atlassian-bitbucket-4.12.1-x64.bin
./atlassian-bitbucket-4.12.1-x64.bin
```
按提示安装，总结信息如下  
Installation Directory: /opt/atlassian/bitbucket/4.9.1  
Home Directory: /var/atlassian/application-data/bitbucket  
HTTP Port: 7990  
Control Port: 8006  
Install as a service: Yes  
  
```
systemctl start atlbitbucket
```
  
Installation Directory: /opt/atlassian/bitbucket/4.9.1  
Home Directory: /var/atlassian/application-data/bitbucket  
HTTP Port: 7990  
Control Port: 8006  
  
https://wiki.shileizcc.com/display/atlassian/Bitbucket  
http://blog.51cto.com/newthink/1870235 Bitbucket4.10.1版，有中文版安装介绍，貌似没破解成功  
http://www.cnblogs.com/lzs0420/p/6015795.html 主要参考，bitbucket-4.9.1 包括tomcat的版本  
https://www.jianshu.com/p/20dbcf85f962 介绍了破解的原理  
http://www.yalasao.com/168/crowd-jira-confluence-install  
http://pkufranky.blogspot.co.id/2010/05/atlassian.html 1.15版本破解  
  
## GitHub vs. Bitbucket 不只是功能不同
http://blog.jobbole.com/89418/  
  
  
## ubuntu16.04 安装 Bitbucket Server
安装依赖（可选）  
```
sudo apt install software-properties-common
```
安装Java：  
```
sudo apt install default-jdk default-jre
```
  
本次安装的是Atlassian Bitbucket v5.6.2版，安装完后台可迁移数据库到外部数据库，所以如下安装数据库的步骤应该可以取消  
```
sudo apt-get install postgresql postgresql-client
ps -ef | grep postgre  # 查看是不是安装好了
```
  
```
passwd postgres  # 设置密码
sudo su - postgres # 切换到postgres用户
createuser --interactive  # 用来创建新的用户xxxxxx
createdb xxxxxx  # 用来创建数据库， 貌似是一定跟用户重名
sudo su - xxxxxx  # 一般会提示没有密码
```
  
```
sudo -u postgres psql
\password xxxxxx 这样就需要创建密码给新建的用户了
```
  
其中xxxxxx要跟用户名postgres重名  
最后以postgres身份安装  
```
cd /usr/local/src
sudo bash ./atlassian-bitbucket-5.6.2-x64.bin
```
  
安装完后浏览器访问 http://localhost:7990  
  
关掉安装的错误版本  
```
ps aux | grep bitbucket
kill -9 pid
```
  
postgre语法 =\= 开头，退出使用命令 ==\q  
  
管理  
```
service atlbitbucket status
service atlbitbucket stop
service atlbitbucket start
```
  
总结  
安装完后电脑巨卡，建议安装早期的版本  
  
参考  
https://dkyu.com/she-zhi-bitbucket-server/  
https://stackoverflow.com/questions/18664074/getting-error-peer-authentication-failed-for-user-postgres-when-trying-to-ge  
https://stackoverflow.com/questions/16973018/createuser-could-not-connect-to-database-postgres-fatal-role-tom-does-not-e  
https://stackoverflow.com/questions/9463318/how-to-exit-from-postgresql-command-line-utility-psql  
  
## ubuntu16.04 卸载 Bitbucket Server
  
```
cd /opt/atlassian/bitbucket/5.6.2/bin/
./install_linux_service.sh -u remove_service atlbitbucket
rm -rf /var/atlassian
rm -rf /opt/atlassian/
```
  
  
https://confluence.atlassian.com/bitbucketserverkb/how-to-uninstall-bitbucket-server-828789036.html  
https://community.atlassian.com/t5/Bitbucket-questions/how-to-uninstall-bitbucket-on-centos-7-from-bash/qaq-p/164424  
  
  
## Gitlab部署
  
```
sudo apt install curl openssh-server ca-certificates sendmail
curl -sS https://packages.gitlab.com/install/repositories/gitlab/gitlab-ce/script.deb.sh | sudo bash
sudo apt-get install gitlab-ce
sudo gitlab-ctl reconfigure
```
  
如果开启防火墙  
```
sudo ufw allow http
sudo ufw allow OpenSSH
```
使用浏览器访问GitLab：http://your_domain_or_IP  
  
因为本地已经占用80端口，所以修改端口  
```
sudo vim /etc/gitlab/gitlab.rb
```
修改 =external_url=  
```
external_url 'http://gitlab.c:90'
```
重新配置gitlab  
```
sudo gitlab-ctl reconfigure
```
以上命令执行后，文件 =sudo vim /var/opt/gitlab/nginx/conf/gitlab-http.conf= 对应的端口也会改为相应的90  
访问 http://gitlab.c:90 测试  
  
管理gitlab  
```
sudo gitlab-ctl start
sudo gitlab-ctl stop
sudo gitlab-ctl restart
```
  
https://about.gitlab.com/installation/#ubuntu 官方安装文档  
http://blog.topspeedsnail.com/archives/5490 Ubuntu 16.04 安装 GitLab + Let’s Encrypt  
https://xuanwo.org/2016/04/13/gitlab-install-intro/ Gitlab部署和汉化以及简单运维  
http://www.thecfguy.com/blog/how-to-change-default-port-for-gitlab/ 修改端口  
  
## 研究Atlassian全家桶
  
| server software | 10users price | 25users price |  
|-----------------+---------------+---------------|  
| bitbucket       | $10           | $2000         |  
| jira            | $10           | $2000         |  
| confluence      | $10           | $1500         |  
  
10人以内挺划算，但超过人数后价格感人  
  
网上有破解教程，可以折腾折腾，比较麻烦  
  
[大话项目管理工具之Confluence篇](http://blog.csdn.net/happylee6688/article/details/38926473)  
```
Confluence为团队提供一个协作环境。在这里，团队成员齐心协力，各擅其能，协同地编写文档和管理项目。从此打破不同团队、不同部门以及个人之间信息孤岛的僵局，Confluence真正实现了组织资源共享
```
## 项目管理工具介绍
网上搜了挺多的资料，主要在知乎上，花了大概两三小时的时间，然后也是感觉没有很好的收获，简单记录一下  
  
重量级项目管理管理如P6(Oracle出品)，适合工程管理大项目，软件功能全，复杂，成本高(几千到2万多)  
  
总结了一下个人选择项目管理软件的主要考虑的点  
- 数据安全，除了信任项目服务方，可以搭建自己的服务器托管
- 页面美观，因为每天使用，丑陋的页面会影响心情
- 功能需要，目前市面上的项目管理软件风格各异，提供的主要功能有时相差不大，但各会有所偏重或擅长的，比如任务计划管理、协同办公...
- 收费，人数限制方面
  
说一下调查市面上产品的心得，不要相信什么10款最佳的、最好的20个之类的，真心用过并良心推荐的未必能凑够这种整数的，大多是为了做广告；做广告的写的太多，没什么重点  
  
```
链接：https://www.zhihu.com/question/21518108/answer/230472963

项目管理软件没有最好的，只有最适合的。找到适合团队定位和使用习惯的产品，才能打通任督二脉。用过市面上的很多款协同产品，大概分为几个大类：

1. 轻协同产品：
Basecamp，Asana，Trello，Notion，Teambition, Worktile...特点：开放面向C端用户，交互做的比较好缺点：主要是协同功能，很少或没有针对单一垂类客户的功能支持评价：适合简单的项目/非研发团队做任务管理和协同，不适合人数达一定规模的研发团队进行研发项目管理。
2. 软件研发项目管理软件产品：
JIRA/Confluence，ONES Project/ONES Wiki，禅道特点：有针对研发团队的功能特性，支持软件研发流程，可以进行需求管理、bug 管理。缺点：JIRA 比较重度，配置复杂，没有中文界面，且服务器在国外访问速度慢；禅道交互不友好，界面老旧，自定义程度低，不支持任务自动流转。评价：基本上研发团队只能从上面选。不想付费的、能忍受其交互可以选禅道开源版；对统计报表有需求，希望有自定义工作流，追求更流畅的体验的可以选 ONES Project；不介意英文界面和访问速度的也可以看看 JIRA。需要注意的是，JIRA 是国外的公司，在国内没有服务，有问题也很难响应。
3. 甘特图产品：
Microsoft Project，Omni Plan特点：任务列表和甘特图相结合，对任务时间维度的把控较好。缺点：重操作，PM 除了需要管理任务还要管理时间条、资源池；对协同的支持差。

评价：Project 只有 PC 端，Omni Plan 只有 Mac 端，所以按照办公电脑类型选就可以。两款软件文件格式高度兼容，界面上都是左任务列表、右甘特图的布局，并且支持日历和资源池，可以生成可视化优秀的报表，可以说是不分伯仲。需要提及的是，Project 只有 PC 端，没有手机端 App，而OmniPlan 有。但是为了支持在更多场景使用，微软发布了 Web 简化版 Project Online，同时支持多人协作编辑。

除了上面这些软件之外，还有很多服务单一垂类的项目管理软件，比如工程类项目信息系统，等等。

我上一家公司在选型时走了很多弯路，换了好几款产品，PM和团队成员都被换平台折磨得相当痛苦。一开始立项的时候，我们选用了看板鼻祖 Trello。然而随着开发时间延长，任务变得非常多，看板很长反而难以管理，于是我们转向了列表式的 Asana。Asana 的体验真心不错，但是用了一阵却发现，由于产品比较轻度，所以每个产品组一个团队账号，几个产品组是分开使用的。这对于管理者来说很不方便，要切换多个账号才能查看几个产品的进度，于是换成了 Jira ——却由于系统过于复杂没有在团队推进成功。

用过ONES Project-敏捷开发最佳实践 | ONES后，真心觉得对于软件研发团队来说，这款软件比上述的几款都更适合，从需求管理到 bug 管理都能实现，甚至运营、市场的同事也都能在上面工作，能够及时看到产品发布的计划和进度，市场和用户反馈也能及时到达产品和研发组，实事求是地说，市面上再也找不到第二款能够达到上述效果的研发项目管理软件了。
```
  
了解了一款 [风车](https://fengche.co/tour) ,界面简洁  
  
## 一些bitbucket安装介绍
[设置BitBucket Server](https://dkyu.com/she-zhi-bitbucket-server/) 命令行安装的介绍  
[[http://blog.topspeedsnail.com/archives/8865][Ubuntu 16.04 GitBucket安装]] [Ubuntu 16.04 安装 GitLab](http://blog.topspeedsnail.com/archives/5490)  
http://blog.csdn.net/feinifi/article/details/74330765 提供了一个破解版的bitbucket安装  
  
## 项目管理Jira,bitbucket,jenkins的应用
[初创公司应该如何做好持续集成和部署？](https://juejin.im/entry/56fcb1a339b0570054e19557) 介绍的比较全面  
[JIRA&Bibucket 部署策略](http://zuyunfei.com/2016/12/05/JIRA-Bibucket-Deployment-Strategy/) 作者详细介绍了自己公司的搭建思路  
[jenkins代码自动部署](http://www.cnblogs.com/shansongxian/p/6605623.html) 一个介绍jenkins的中文文章  
[分享下各位公司的代码管理和发布机制](http://www.maben.com.cn/archives/863.html)  
  
## bitbucket添加webhook url
参考 [POST service webhook for Bitbucket Server](https://confluence.atlassian.com/bitbucketserver/post-service-webhook-for-bitbucket-server-776640367.html) 官网介绍的流程，每个钩子最多可添加5条url监控地址，当bitbucket收到提交等时间时发出POST请求，The content type header of the POST has an application/json type. The content is a JSON payload that represents the repository push.头格式为 =application/json=  
## 搭建nodejs的服务器监控
项目托管到 github  
  
```
touch server.js
```
```
var http = require('http'),
    exec = require('child_process').exec

const PORT = 9991,
      PATH = '/var/www/html/scheduled'

var deployServer = http.createServer(function(request, response) {
  if (request.url.search(/deploy\/?$/i) > 0) {

    var commands = [
      'cd ' + PATH,
      'git pull'
    ].join(' && ')

    exec(commands, function(err, out, code) {
      if (err instanceof Error) {
        response.writeHead(500)
        response.end('Server Internal Error')
        throw err
      }
      response.writeHead(200)
      response.end('Deploy Done')
    })

  } else {

	if (request.url.search(/status\/?$/i) > 0) {
		response.writeHead(200)
		response.end('Normal Status')
	}

    response.writeHead(404)
    response.end('Not Found')
  }

})

deployServer.listen(PORT)
```
命令行可以写 =touch bbbb= 临时测试，运行 =node server.js= 后，报错  
```
Cannot find module 'exec'
```
执行 =cnpm install exec= 后重启服务，访问 http://localhost:9991 提示  
```
DeprecationWarning: exec: use child_process.execFile instead
```
执行 =cnpm install child_process= 详情参考[Child Process模块](http://javascript.ruanyifeng.com/nodejs/child-process.html)  
  
参考  
http://jerryzou.com/posts/webhook-practice/  
https://www.jianshu.com/p/e4cacd775e5b  
其他资料  
https://aotu.io/notes/2016/01/07/auto-deploy-website-by-webhooks-of-github/index.html  
https://haofly.net/github-set-webhook/ 用PHP搭建的监控服务器，介绍了一些踩过的坑  
http://note.chenqiwei.com/blog/2016/07/21/ji-cheng-jenkins/ 集成Jenkins  
[Continuous Integration with Bitbucket Server and Jenkins](https://bjurr.com/continuous-integration-with-bitbucket-server-and-jenkins/) 详细介绍了Bitbucket Server和Jenkins搭建  
  
[Publishing a Website on Bitbucket Cloud](https://confluence.atlassian.com/bitbucket/publishing-a-website-on-bitbucket-cloud-221449776.html) bitbucket官网发布站点教程，包括如何绑定到  https://accountname.bitbucket.io site.  
[Bitbucket免费代码托管空间:可绑域名 私有Repos 个人空间](https://www.jianshu.com/p/6ba38e8b9977)  
[[https://lxiange.com/posts/choices-for-static-sites.html][静态站点托管的选择]] 文章的上一页和下一页也写的很好，分别是个人博客的类型选择、[加速个人博客访问](https://lxiange.com/posts/optimize-site-access.html)  
[在VPS上搭建静态博客站点](http://blog.soliloquize.org/2015/07/06/%E5%9C%A8VPS%E4%B8%8A%E6%90%AD%E5%BB%BA%E9%9D%99%E6%80%81%E5%8D%9A%E5%AE%A2%E7%AB%99%E7%82%B9/) 介绍了在vps上搭建博客的流程和思路  
  
*在线上部署*  
```
cd /var/www/
sudo mkdir deploy & cd deploy
sudo chown user:group ./
```
试执行 =node= 提示  
```
The program 'node' is currently not installed. To run 'node' please ask your administrator to install the package 'nodejs-legacy'
```
  
```
sudo apt install nodejs-legacy
node -v   # v4.2.6
vim node scheduled.js  # nodejs server script
nohup node scheduled.js > scheduled.log 2>&1 &
```
  
## 迁移代码到远程服务器的方法
## 使用scp直接复制
```
cd /var/www/html
sudo scp -r ./scheduled/ root@ip:/var/www/html/
```
由于远程目录/var/www/html/需要有root权限，所以使用root登录，否则报错  
## 从bitbucket clone代码到本地
  
## 从bitbucket clone代码到本地
*配置ssh key*  
```
cd /home/arpher
ssh-keygen  # 生成 *当前* 的用户的密钥对
```
参考 https://www.ssh.com/ssh/keygen/  
复制公钥到bitbucket账户  
```
sudo chown user:group /var/www/html -R  # 确保user拥有/var/www/权限(否则在目录使用git命令下载无权限)
```
*下载*  
```
cd /var/www/html
git clone git@bitbucket.org:bearpher/scheduled.git
```
## 將域名解析到ip后，ssh登录apher@arpher.com提示报错
```
WARNING: POSSIBLE DNS SPOOFING DETECTED!
```
出现这问题的原因一般是同一主机使用了不同的用户名登陆，按提示执行  
```
ssh-keygen -f "/home/arpher/.ssh/known_hosts" -R arpher.com
```
