## awesome
文档  
- https://reactjs.org/
- 路由 https://reacttraining.com/react-router/web/example/basic
  
资源集  
- [学习React之前你需要知道的的JavaScript基础知识](https://www.zcfy.cc/article/javascript-fundamentals-before-learning-react)
- [从1.8万篇文章中脱颖而出45个最棒的 React.js 学习指南（2018版）](https://hijiangtao.github.io/2018/01/23/learn-react-js-from-top-45-tutorials-for-the-past-year-v-2018/)
- [最新收录的React开发开源项目](https://www.ctolib.com/react/newarticle.html)
- https://github.com/Pines-Cheng/awesome-react-cn
- https://github.com/enaqx/awesome-react
- https://react.docschina.org/
admin相关  
- https://ant.design/docs/react/getting-started-cn
- https://github.com/umijs/umi 快速生成有路由的页面的脚手架
- [umi + dva，完成用户管理的 CURD 应用](https://github.com/sorrycc/blog/issues/62)
项目demo  
- [AccountSystem 一个小型库存管理系统](https://github.com/yvanwangl/AccountSystem)
- [React + Redux - User Registration and Login Tutorial & Example](http://jasonwatmore.com/post/2017/09/16/react-redux-user-registration-and-login-tutorial-example)
- [Build a realtime PWA with React](https://medium.com/front-end-hacking/build-a-realtime-pwa-with-react-99e7b0fd3270)
- https://dev.to/drminnaar/11-react-examples-2e6d
- [大众点评demo](https://www.imooc.com/article/16082)
  
文章  
- [umi + dva，完成用户管理的 CURD 应用](https://github.com/sorrycc/blog/issues/62)
- [处理异步利器 -- Redux-saga](https://www.zcfy.cc/article/async-operations-using-redux-saga-freecodecamp-2377.html)
- [React Router v4 版本 完全指北](https://www.zcfy.cc/article/react-router-v4-the-complete-guide-mdash-sitepoint-4448.html)
- [译 关于 React Router 4 的一切](https://juejin.im/post/5995a2506fb9a0249975a1a4)
  
- [之前react做的一个应用，最近把首页改成了服务端渲染的形式](https://github.com/xiyuyizhi/movies)
- [揭秘 React 服务端渲染](https://juejin.im/post/5af443856fb9a07abc29f1eb) [译]
- http://www.ruanyifeng.com/blog/2015/03/react.html
 React Native  
- https://github.com/reactnativecn/react-native-guide
- [是时候了解React Native了](https://www.jianshu.com/p/ee78dca62677)
  
优化  
- [React 16 加载性能优化指南](https://mp.weixin.qq.com/s/KxJttCVuCoIrm9RAjRBrdg) 腾讯的前端分享
- https://www.jianshu.com/p/333f390f2e84
  
  
  
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
  
  
## What is the best way to redirect a page using React Router?

https://stackoverflow.com/questions/45089386/what-is-the-best-way-to-redirect-a-page-using-react-router
## How to push to History in React Router v4?
https://stackoverflow.com/questions/42701129/how-to-push-to-history-in-react-router-v4
## 怎么获取路由参数
 https://stackoverflow.com/questions/35352638/how-to-get-parameter-value-from-query-string
 - Link怎么添加参数 https://knowbody.github.io/react-router-docs/api/Link.html
 - history
  - history在react-router-dom中的默认已经包含，所以不用在<Router>传history属性了，
  - 如果需要定制历史记录,可以安装npm install history
## 怎么多次请求
 https://redux-saga-in-chinese.js.org/docs/advanced/RunningTasksInParallel.html  
  

