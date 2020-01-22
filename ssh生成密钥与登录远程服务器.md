* ssh-keygen本地生成密钥对  
  
```
ssh-keygen -C 'kyronbao@gmail.com'
```
-C 指注释的用户名，以后也可以用-c来修改
提示设置密码，这里的密码可以加密私钥，防止别人拿到你的私钥干坏事  
  
复制公钥到服务器  
```
ssh-copy-id user@host
```
  
重启服务器sshd  
```
sudo systemctl restart sshd
```
  
添加本地私钥到ssh代理  
```
ssh-add
```
  
坑坑坑调试  
复制公钥到服务器后，发现仍然无法登录  
提示  
```
Ubuntu 16.04 ssh: sign_and_send_pubkey: signing failed: agent refused operation
```
解决  
ssh-add  
  
参考  
- https://wiki.archlinux.org/index.php/SSH_keys_(%E7%AE%80%E4%BD%93%E4%B8%AD%E6%96%87)
- https://askubuntu.com/questions/762541/ubuntu-16-04-ssh-sign-and-send-pubkey-signing-failed-agent-refused-operation
  
* 在远程服务器上设置git用户可ssh登录  
```
sudo adduser git
su git
cd
mkdir .ssh && chmod 700 .ssh
touch .ssh/authorized_keys && chmod 600 .ssh/authorized_keys
# 通过root权限添加其他用户的公钥到authorized_keys
su root
vim /home/git/.ssh/authorized_keys # 新建一行，粘贴即可
# or
scp /home/username/.ssh/id_rsa.pub root@hostname:/tmp/
cat /tmp/id_rsa.pub >> /home/git/.ssh/authorized_keys

# 现在可以用过ssh登录git@host了
ssh git@host
```
  
  
