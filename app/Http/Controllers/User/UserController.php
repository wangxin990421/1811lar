<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 用户注册
     */
    public function reg()
    {
        return view('User/week');
    }

    /**
     * 网站数据拔取
     */
    public  function grasp()
    {
        $url = "http://www.zongheng.com//rank/details.html?rt=4&d=1";
        $str = file_get_contents($url);
        $patten = '#<div class="rank_d_list borderB_c_dsh clearfix" bookName = ".*" bookId=".*">.*<div class="rank_d_book_img fl" title=".*"><a .*><img src="(.*)" alt=".*"></a></div>.*<div class="rank_d_book_intro fl">.*<div class="rank_d_b_name" title=".*"><a .*>(.*)</a></div>.*<div class="rank_d_b_cate" title=".*"><a .*>(.*)</a>.*<a  target="_blank">(.*)</a>.*<a target="_blank">(.*)</a></div>.*<div class="rank_d_b_info">(.*)</div>.*<div class="rank_d_b_last" title=".*"><a .*><span class="rank_d_lastchapter">(.*)</span>(.*)</a><span class="rank_d_b_time" >(.*)</span></div>.*</div>.*<div class="rank_d_book_manage fr"><div class="rank_d_b_rank"><div .*>(.*)</div><div .*>(.*)<span>(.*)</span></div></div><a .*>(.*)</span></a><button .*>(.*)</button></div>.*</div>#isU';
        preg_match_all($patten,$str,$res);
        //var_dump($res);die;

        unset($res[0]);
        $data = [];
        for($i=0;$i<count($res[1]);$i++){
            for($j=1;$j<=count($res);$j++){
                $data[] = $res[$j][$i];
            }
        }
        $info = array_chunk($data,count($res));
        print_r($info);
    }

    /**
     * 文件上传 流形式
     */
    public function upload()
    {
        $url = '/wwwroot/tu/1.jpg';
        $content = file_get_contents($url);
        $content = base64_encode($content);
//echo $content;die;

//初始化
        $curl = curl_init();
//设置抓取的url
        curl_setopt($curl, CURLOPT_URL, 'http://wangxin.1811lar.com/upload/uploadDo');
// https请求 不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
//设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
//设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
//执行命令
        $data = curl_exec($curl);
//关闭URL请求
        curl_close($curl);
//显示获得的数据
        var_dump($data);
    }

    /**
     * 文件流上传 执行
     */
    public function uploadDo()
    {
     $content = file_get_contents('php://input');
     $content = base64_decode($content);
     file_put_contents('6.bmp',$content);
//echo $content;die;
     $content = base64_encode($content);
     echo "<img src='data:image/jpeg;base64,".$content."'>";
    }

    /**
     * 非对称数据 加密
     */
    public function add()
    {
        //生成私钥对象
        $private = openssl_pkey_new();
        //从私钥里获取私钥
        openssl_pkey_export($private,$privateKey);
        //保存私钥看，
        file_put_contents('pri.txt',$privateKey);
        $pub = openssl_pkey_get_details($private);
        file_put_contents('pub.txt',$pub['key']);


    }


    public function set()
    {

        //定义的数据
        $name='wangxin';
        $pwd='123456';

        //获取公钥对象
        $pub=file_get_contents(public_path('pub.txt'));
        //加密的数据  公钥加密
        openssl_public_encrypt($name,$names,$pub);
        openssl_public_encrypt($pwd,$pwds,$pub);

        $names=urlencode(base64_encode($names));
        $pwds=urlencode(base64_encode($pwds));
        echo '加密的用户名：'.$names;
        echo '<br>';
        echo '加密的密码：'.$pwds;
        echo "<a href='/get?name=".$names."&pwd=".$pwds."'>点击</a>";
    }

    public function get()
    {
        $name=$_GET['name'];
        $pwd=$_GET['pwd'];
        $names = base64_decode($name);
        $pwds = base64_decode($pwd);
        //使用私钥解密
        $pri=file_get_contents(public_path('pri.txt'));
//        $prikey = openssl_pkey_get_details($pri);
        openssl_private_decrypt($names,$name,$pri);
        openssl_private_decrypt($pwds,$pwd,$pri);
        echo '用户名为：'.$name;
        echo '<br>';
        echo '密码为：'.$pwd;
    }
}
