
## debian9/deepin15.11 安装pip3 you-get

sudo apt install python3-pip

pip3 --version

pip3 install you-get

安装后发现you-get命令无法执行，
原因是安装位置在 .local/bin 下面，没有加入path

vim .bashrc
export PATH=$HOME/.local/bin:$PATH 

source .bashrc
