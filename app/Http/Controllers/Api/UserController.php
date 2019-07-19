<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;

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
            //return  json_encode($result);
        }
    }

    /**
     * 用户登录
     */

    public function login(Request $request)
    {
//        echo   11111;die;
        $data = request()->input();
//        dd($data);
        $username = $data['username'];
        $password = $data['pwd'];
//        $format = $request->input('format','json');
//        $model = new User();
//        if(!$model->checkFormat($format)){
//            $model->returnCode(1000,'不允许的数据类型返回!');
//        }
        if(empty($username) && empty($password)){
//            return $model->returnCode(417,'参数有误');
            $data =[
                'code'=>417,
                'msg'=>'参数有误',
                'data'=>[]
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $data = \DB::table('user')->where(["username"=>$username])->first();
        if(!$data){
            $data =[
                'code'=>417,
                'msg'=>'用户不存在',
                'data'=>[]
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        if($data->pwd != md5($password)){
            $data =[
                'code'=>417,
                'msg'=>'密码有误',
                'data'=>[]
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $user_id = $data->u_id;
        $token = $this->createToken($user_id,$username);
        $data =[
            'code'=>200,
            'msg'=>'success',
            'data'=>[
                'token'=>$token
            ]
        ];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    /**
     * 生成用户  token
     */
    public function createToken($id,$name)
    {
        $num = "dasdsadasdfdqwereqsad";
        $data = [
            'id' =>$id,
            'name' => $name,
            'create_time' => time(),
            'expire' => time()+7200,
            'num' => $num,
        ];
        $data = serialize($data);
        $res = base64_encode($data);
        return $res;
    }

}
