<?php

namespace App\Http\Controllers\work;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *  学生展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stuInfo = \DB::table('student')->get();
//        dd($stuInfo);
       return view('posts.index',['data'=>$stuInfo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *学生添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
//        dd($data);
        $stuInfo =\DB::table('student')->where(['username'=>$data['username']])->first();
//        dd($stuInfo);
        if(!empty($stuInfo)){
            $result=[
                'code'=>40000,
                'msg'=>"该学生信息已经存在了！",
                'data'=>$stuInfo
            ];
            echo json_encode($result,JSON_UNESCAPED_UNICODE);exit;
        }
        $res = \DB::table('student')->insert($data);
//        dd($res);
        if($res){
            $result=[
                'code'=>1,
                'msg'=>"success",
                'data'=>$data
            ];
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Display the specified resource.
     *学生详细信息查询
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        dd($id);
        $stuInfo = \DB::table('student')->where(['id'=>$id])->first();
//        dd($stuInfo);
        return view('posts.show',['data'=>$stuInfo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *  学生数据更新执行方法
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($id);
//        $data=file_get_contents('php://input');
//        file_put_contents("1.txt",$data);
        $data = request()->input();
//        dd($data);
        $stuInfo =[
            'username'=>$data['username'],
            'pwd'=>$data['pwd'],
            'sex'=>$data['sex'],
            'grade'=>$data['grade']
        ];
        $res=\DB::table('student')->where(['id'=>$id])->update($stuInfo);
//        dd($res);
        if($res){
            $result=[
                'code'=>1,
                'msg'=>"success",
                'data'=>$data
            ];
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Remove the specified resource from storage.
     *  学生删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        dd($id);
        $res = \DB::table('student')->where(['id'=>$id])->delete();
        if($res){
            $result=[
                'code'=>1,
                'msg'=>"success",
                'data'=>[]
            ];
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }
}
