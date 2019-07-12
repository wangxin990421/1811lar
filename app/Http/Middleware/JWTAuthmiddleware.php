<?php

namespace App\Http\Middleware;

use App\Tools\JWTAuth\JWTAuth;
use Closure;

class JWTAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->token;
        $data = [
            'code' =>200,
            'message'=>"OK",
            'data'=>[]
        ];
        if($token){
            $jwt = JWTAuth::getInstance();
            $jwt->setToken($token);
            if($jwt->verify() && $jwt->vailData()){
                return $next($request);
            }else{
                $data['code'] = 40002;
                $data['message'] ="登陆失败！请重新登陆!";
                $data['data'] =[];
                echo json_encode($data,JSON_UNESCAPED_UNICODE);exit;
            }
        }else{
            $data['code'] = 40001;
            $data['message'] ="参数有误!";
            $data['data'] =[];
            echo json_encode($data,JSON_UNESCAPED_UNICODE); exit;
        }
    }
}