<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
//use App\Http\Controllers\LoginController;
class CheckRequest
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
        $name=$request->name;
//        dd($id);
        $count_Request='count_Request:'.$name;
        $res=Redis::incr($count_Request);
        dump($res);
        if ($res>20){
            echo '访问次数超过20次！';die;
        }else {
            Redis::expire($count_Request,10);
            return $next($request);
        }
    }

}

