## 前言
这篇文章打算列出Laravel生命周期的尽可能详细的各个步骤，待后面进一步分析。

## 容器实例的启动
容器启动时注册绑定了各种实例，如下：

```
    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }
        $this->registerBaseBindings();
        $this->registerBaseServiceProviders();
        $this->registerCoreContainerAliases();
    }
```
## 容器解析出kernel实例

## kernel处理request请求，生成response实例

## response发送输出

## kernel结束实例
