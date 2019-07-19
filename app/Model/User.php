<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table="user";

    //解析token
    public function checkToken($token)
    {
         $data = base64_decode($token);
//         dd($data);
        $arr = array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5');
        $res = mb_detect_encoding($data, $arr);
//        dd($res);
        if (empty($res) || $res != "ASCII") {
            $this->returnCode('101', "参数有误!");
        }
        $token = unserialize($data);
        if (time() > $token['expire']) {
            $this->returnCode(117, '登陆失效，请重新登陆!');
        }
        $unserInfo = User::where(['u_id' => $token['id']])->first();
        if (!empty($unserInfo) && $unserInfo->username == $token['name']) {
            $this->returnCode('200','success',$unserInfo);
        } else {
            $this->returnCode('102', "验证失败!");
        }
    }

    public function returnCode($code="200",$mgs="ok",$data=[])
    {
        $data = [
            'code' => $code,
            'msg'  => $mgs,
            'data' => $data
        ];
        exit  (json_encode($data,JSON_UNESCAPED_UNICODE));
    }
}
