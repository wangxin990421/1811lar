<?php

namespace App\Tools\JWTAuth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Key;

class JWTAuth
{
    /**
     * 单类模式使用场景
     *          连接数据库时    做用户验证时
     */
    /**
     * 创建单类模式的句柄
     * @var
     */
    private static $instance;
    private $iss = "http://www.a.com";
    private $for = "http://www.b.com";
    private $id;
    private $sign = "qwertyasdfghjklzxcvbnmsdfghjklwertyui";
    private $token;
    private $decodeToken;

    /**
     *
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * //私有的构造方法
     * JWTAuth constructor.
     */
    private function __construct()
    {

    }

    /**
     * 私有的克隆方法
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public function setUid($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        $token = (string)$this->token;

        return $token;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function encode()
    {
        $time = time();
        $token = (new Builder())->setIssuer($this->iss)//服务签发者  服务端
                 ->setAudience($this->for)//签发给谁  客户端
                 ->setHeader("Authorization", "123456")
                 ->set("uid", $this->id)//设置用户id
                 ->setIssuedAt($time)//设置创建时间
                 ->setExpiration($time + 3600)//设置过期时间
                 ->sign(new Sha256(), $this->sign)//设置盐值
                 ->getToken();
        $this->token = $token;

        return $this;
    }

    public function decode()
    {
        if (!$this->decodeToken) {
            $this->decodeToken = (new Parser())->parse((string)$this->token);
        }
        return $this->decodeToken;
    }

    public function vailData()
    {
        $data = new ValidationData();
        $data->setIssuer($this->iss);
        $data->setAudience($this->for);
        $data->setId($this->id);

        return $this->decode()->validate($data);
    }

    public function verify()
    {
        $verify = $this->decode()->verify(new Sha256(), $this->sign);
        return $verify;
    }
}