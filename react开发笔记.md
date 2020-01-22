## 渲染两次，无法显示数据
使用ant design pro在开发用户角色管理时，进入页面，会发现第一次显示不了默认的用户角色。如果第二次进入角色管理页面，则可以显示成功角色的默认值。  
在render()中打印this.props，发现渲染了4次，这里我在effect中请求了两次数据，每次都要先渲染页面，然后加载数据，所以渲染了4次。  
参考ant design pro的loading机制，在connect加入loading参数，render()中打印发现loading的值依次为  
undefined  
ture  
ture  
false  
所以解决方案如下  
  
render()函数中 return（）包裹以下内容  
return (  
      <div>  
        {  
          loading ? <div>loading</div> : (  
            <Card title="员工角色管理" bordered={false}>  
  
            </Card>  
          )  
        }  
      </div>  
);  
  
  
参考  
  - [why-is-my-react-component-is-rendering-twice](https://stackoverflow.com/questions/48846289/why-is-my-react-component-is-rendering-twice) 通过添加一个isFetching参数解决
  - [React twice mount component, but on second time doesn't receive props](https://stackoverflow.com/questions/43384033/react-twice-mount-component-but-on-second-time-doesnt-receive-props) 介绍了方案，可以在子组件中渲染数据
  
  
  
 在List组件获取不到props（this.props.cityName），在render()中执行了两次，  
    - 第一次undefind, 第二次能获取到值
    - 这里介绍了一种通过render()内部在renderSubPage()的方法
    - 解决思路
    - 将Home的ComponentDidMount()注销，中打印alert()变为只出现一次，由此可以判断
      - Home组件因为这个函数在这里渲染了两次，
      - 参考ComponentDisMount(),setState(),reat-router V4的思想，在Home外层再封装了一层App组件（包含路由），解决
  
  
## [What is the best way to redirect a page using React Router?](https://stackoverflow.com/questions/45089386/what-is-the-best-way-to-redirect-a-page-using-react-router)
## [How to push to History in React Router v4?](https://stackoverflow.com/questions/42701129/how-to-push-to-history-in-react-router-v4)
 -  [怎么获取路由参数](https://stackoverflow.com/questions/35352638/how-to-get-parameter-value-from-query-string)
 - Link怎么添加参数 https://knowbody.github.io/react-router-docs/api/Link.html
 - history
  - history在react-router-dom中的默认已经包含，所以不用在<Router>传history属性了，
  - 如果需要定制历史记录,可以安装npm install history
## 怎么多次请求
 https://redux-saga-in-chinese.js.org/docs/advanced/RunningTasksInParallel.html  
  
## [...effects] has been deprecated in favor of all([...effects]),
