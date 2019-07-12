<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 用户注册
     */
    public function reg()
    {
        header('Access-Control-Allow-Origin:*');
        $data = request()->input();
//        dd($data);
        $userinfo = \DB::table('user')->where(['username'=>$data['name']])->first();

        if($userinfo){
            $result  =[
                'code'=>401,
                'msg'=>'该用户已经注册！',
                'data'=>[]
            ];
            return  json_encode($result);
        }
        $pwd= md5($data['pwd']);
        $info = [
            'username'=>$data['name'],
            'email'=>$data['email'],
            'pwd'=>$pwd
        ];
        $res = \DB::table('user')->insert($info);
//        dd($res);
        if($res){
            $result  =[
                'code'=>200,
                'msg'=>'ok',
                'data'=>[]
            ];
            return  json_encode($result);
        }else{
            $result  =[
                'code'=>402,
                'msg'=>'注册失败，请注意参数填写！',
                'data'=>[]
            ];
            return  json_encode($result);
        }
    }

    /**
     * 用户登录
     */

    public function login()
    {
        header('Access-Control-Allow-Origin:*');
        $data = request()->input();
//        dd($data);
        $userInfo = \DB::table('user')->where(['username'=>$data['username']])->first();
//        dd($userInfo);
        if($userInfo){
            if(md5($data['pwd'])==$userInfo->pwd){
                $result  =[
                    'code'=>200,
                    'msg'=>'ok',
                    'data'=>[]
                ];
                return  json_encode($result);
            }else{
                $result  =[
                    'code'=>403,
                    'msg'=>'密码错误！',
                    'data'=>[]
                ];
                return  json_encode($result);
            }
        }else{
            $result  =[
                'code'=>404,
                'msg'=>'该用户还未进行注册！',
                'data'=>[]
            ];
            return  json_encode($result);
        }
    }
}
