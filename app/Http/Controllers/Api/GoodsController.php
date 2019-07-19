<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /**
     * 商品列表页
     */
    public function goodslists()
    {
        $data = \DB::table('goods')->get();

        $data =[
            'code'=>200,
            'msg'=>'success',
            'data'=>$data
        ];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 商品详情页
     */
    public function goodsdetil()
    {
        $goods_id = request()->goods_id;
//        dd($goods_id);
        $goodsInfo = \DB::table('goods')->where(['goods_id'=>$goods_id])->first();
//        dd($goodsInfo);
        $data =[
            'code'=>200,
            'msg'=>'success',
            'data'=>$goodsInfo
        ];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}
