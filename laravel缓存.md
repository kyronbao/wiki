  
## 文章详情页缓存简单实现
参考 [[http://laravelacademy.org/post/1688.html]]  
  
获取文章详情时首先查询缓存，没有命中时，在数据库中查找，具体实现见PostCachedController，  
片段如下：  
```
if(!$post){
    $post = Post::find($id);
    if(!$post)
        exit('指定文章不存在！');
    Cache::put('post_'.$id,$post,60*24*7);
}

if(!Cache::get('post_views_'.$id))
    Cache::forever('post_views_'.$id,0);
$views = Cache::increment('post_views_'.$id);
Cache::forever('post_views_'.$id,$views);
```
  
在保存文章和删除文章时对缓存更新，可以在AppServiceProvider的boot方法加入：  
```
//保存之后更新缓存数据
Post::saved(function($post){
    $cacheKey = 'post_'.$post->id;
    $cacheData = Cache::get($cacheKey);
    if(!$cacheData){
        Cache::add($cacheKey,$post,60*24*7);
    }else{
        Cache::put($cacheKey,$post,60*24*7);
    }
});

//删除之后清除缓存数据
Post::deleted(function($post){
    $cacheKey = 'post_'.$post->id;
    $cacheData = Cache::get($cacheKey);
    if($cacheData){
        Cache::forget($cacheKey);
    }
    if(Cache::get('post_views_'.$post->id))
        Cache::forget('post_views_'.$post->id);
});
```
  
## 其他资料
  
- https://github.com/spatie/laravel-responsecache Speed up a Laravel app by caching the entire response
- [Speed up a Laravel app by caching the entire response](https://murze.be/speed-up-a-laravel-app-by-caching-the-entire-response)
  
[Creating a Caching User Provider for Laravel](https://matthewdaly.co.uk/blog/2018/01/12/creating-a-caching-user-provider-for-laravel/)  
  
[laravel model caching](https://laravel-news.com/laravel-model-caching)  
  
[Caching in Laravel with Speed Comparisons](https://scotch.io/tutorials/caching-in-laravel-with-speed-comparisons#responses-without-cache)  
  
[Larave + Cache](https://medium.com/@ricardoruwer/laravel-cache-d9f4eae29ac1)  
  
