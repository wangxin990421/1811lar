<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//7.4作业  简单 restful 风格api
//Route::resources([
//    'photos' => 'work\PostController',
//    'posts' => 'work\PostController'
//]);
Route::resource('posts', 'work\PostController');   //所有学生数据查询
//Route::resource('POST/students', 'work\PostController');   //学生数据添加
//Route::resource('GET/students', 'work\PostController');   //学生详细数据展示
//Route::resource('PATCH/students', 'work\PostController');   //学生数据修改
//Route::resource('GET/students', 'work\PostController');   //学生删除

//phpexecl  路由
Route::get('work/phpexecl','Phpexcel\PhpexcelController@test_export');

Route::get('week/week','User\UserController@reg');   //周考数组遍历
Route::get('grasp/grasp','User\UserController@grasp');   //周考数组遍历

Route::get('den','User\UserController@add');   //非对称数据加密
Route::get('get','User\UserController@get');
Route::get('set','User\UserController@set');
Route::get('upload/upload','User\UserController@upload');   //文件流上传
Route::post('upload/uploadDo','User\UserController@uploadDo');   //文件流上传

//jwt  数据加密
Route::get('work/login','Phpexcel\PhpexcelController@getToken');
route::group(['prefix'=>'work','middleware'=>'jwt'],function(){
    Route::get('check','Phpexcel\PhpexcelController@check');
});



//项目路由
Route::post('user/reg','Api\UserController@reg');   // 用户注册
Route::post('user/login','Api\UserController@login');   // 用户登录
Route::post('index/goodslist','Api\IndexController@goodslist');   // 商品首页数据展示
Route::post('index/goodslistf','Api\IndexController@goodslistf');   // 商品首页数据展示

Route::post('car/caradd','Api\CarController@caradd');   // 购物车数据添加
Route::post('car/carlist','Api\CarController@carlist');   // 购物车列表数据
Route::post('car/changenum','Api\CarController@changenum');   // 购物车列表数据

Route::post('goods/goodslists','Api\GoodsController@goodslists');   // 商品数据展示
Route::post('goods/goodsdetil','Api\GoodsController@goodsdetil');   // 商品数据展示
route::group(['prefix'=>'index','middleware'=>'checktoken'],function(){
    Route::post('index','Api\IndexController@index');   // 首页
});



//周考   路由
route::group(['prefix'=>'zhou','middleware'=>'checkrequest'],function(){
    Route::post('login','test\TestController@login');
});


Route::get('zhou/loginOut','test\TestController@loginOut');


