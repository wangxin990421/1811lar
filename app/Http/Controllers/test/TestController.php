<?php

namespace App\Http\Controllers\test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
class TestController extends Controller
{
    /**
     * 周考 登录
     */
    public function login()
    {
//        echo 1111111;die;
        $data = request()->input();
//        dd($data);
        $name = $data['name'];
        $pwd = $data['pwd'];
        //获取公钥对象
        $pub=file_get_contents(public_path('pub.txt'));
        //加密的数据  公钥加密
        openssl_public_encrypt($name,$names,$pub);
        openssl_public_encrypt($pwd,$pwds,$pub);
        $usereInfo = \DB::table('user')->where(['username'=>$data['name']])->first();
        $id =$usereInfo->u_id;
        $name = $usereInfo->username;
        if($usereInfo){
            if(md5($data['pwd']) == $usereInfo->pwd){
                $token = $this->getToken($id,$name);
//                dd($token);
//                $redis_username_key= 'redis_username_key'.$name;
                cache(['redis_usernamr'.$name=>$token],3600);
                echo   "登录成功！";
//                echo   111111;
            }else{
                $ip = ($_SERVER['REMOTE_ADDR']);
                $error_request = 'count_Request:'.$ip;
                $res=Redis::incr($error_request);
//                $count_Request='count_Request:'.$id;
//                $res=Redis::incr($count_Request);
                echo "错误次数为：".$res;
                echo "<hr/>";
                echo "登录失败，密码错误！";
            }
        }
    }


    public function getToken($id,$name)
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


    public function loginOut()
    {
        echo   11111;die;
        $name = request()->name;
        $userInfo = cache(['redis_usernamr'.$name=>""],1);
        dd($userInfo);
    }
}
