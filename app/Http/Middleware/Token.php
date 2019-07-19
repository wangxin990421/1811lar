<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;

class Token
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
        $model = new User();
        if(!$token){
            $model->returnCode(101,'缺少必要的参数!');
        }
        $data = $model->checkToken($token);
//        dd($data);
        if($data->code){
            $model->returnCode($data->code,$data->msg);
        }
        return $next($request);
    }


}
