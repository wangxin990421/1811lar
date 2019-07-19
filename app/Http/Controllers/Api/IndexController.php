<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
class IndexController extends Controller
{
    /**
     * 商品index 页面  用户名展示
     */
    public function index()
    {
         echo  111111;

    }

    /**
     * 首页商品数据   时间最新
     * @return false|string
     */
    public function goodslist()
    {
//        $token = request()->token;
//        dd($token);
        $data = \DB::table('goods')->orderBy('create_time','desc')->limit(6)->get();
//        echo $data;die;
        $data =[
            'code'=>200,
            'msg'=>'success',
            'data'=>$data
        ];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 商品数据 价格最贵
     * @return false|string
     */
    public function goodslistf()
    {
        $data = \DB::table('goods')->orderBy('goods_price','asc')->limit(6)->get();
//        dd($data);
        $data =[
            'code'=>200,
            'msg'=>'success',
            'data'=>$data
        ];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }






}
