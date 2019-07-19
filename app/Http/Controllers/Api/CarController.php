<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    /*
     * 商品数据 加入购物车
     */
    public function caradd()
    {
        $data = request()->input();
//        dd($data);
        $token=$data['token'];
        $tokenInfo = base64_decode($token);
//        dd($token);
        $tokens = unserialize($tokenInfo);
//        dd($tokens);
        $u_id = $tokens['id'];
        $goods_id=$data['goods_id'];

        $goodsInfo = \DB::table('goods')->where(['goods_id'=>$goods_id])->first();
        $carInfo  = [
            'g_id'=>$goodsInfo->goods_id,
            'g_name'=>$goodsInfo->goods_name,
            'g_price'=>$goodsInfo->goods_price,
            'g_img'=>$goodsInfo->goods_img,
            'u_id'=>$u_id
        ];
        $res  =\DB::table('car')->insert($carInfo);
//        dd($res);
        if($res){
            $data =[
                'code'=>200,
                'msg'=>'添加购物车成功！',
                'data'=>[]
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 购物车页面   数据处理
     */
    public function carlist()
    {
        $data = request()->input();
        $token=$data['token'];
        $tokenInfo = base64_decode($token);
//        dd($token);
        $tokens = unserialize($tokenInfo);
//        dd($tokens);
        $u_id = $tokens['id'];
        $carInfo = \DB::table('car')->where(['u_id'=>$u_id])->get();
//        dd($carInfo);
        $count = 0;
        foreach($carInfo as $k=>$v){
            $count+=$v->g_price*$v->g_num;
        }
//        dd($count);
        $data = [
            'code'=>200,
            'msg'=>'success',
            'data'=>[
                'data'=>$carInfo,
                'totls'=>$count
            ]
        ];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 购物车 页面 更改购买数量
     */
    public function changenum()
    {
        $data = request()->input();
//        dd($data);
        $goods_num = \DB::table('goods')->where(['goods_id'=>$data['g_id']])->first();
//        dd($goods_num);
        if($data['g_num']>$goods_num->goods_num){
            $data =[
                'code'=>107,
                'msg'=>'购买数量大于库存了，亲！'
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);exit;
        }
        $g_num = [
            'g_num'=>$data['g_num']
        ];
        $res = \DB::table('car')->where(['g_id'=>$data['g_id']])->update($g_num);
//        dd($res);
        if($res){
            $data= [
                'code'=>200,
                'msg'=>'更改购买数量成功了呢！',
                'data'=>$data['g_num']
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);exit;
        }
    }
}
