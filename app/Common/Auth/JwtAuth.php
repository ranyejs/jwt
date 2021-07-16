<?php


namespace App\Common\Auth;
use Firebase\JWT\JWT;

/**
 * 单例 一次请求中所出现使用jwt的地方都是一个用户
 *
 * Class JwtAuth
 * @package App\Common\Auth
 */
class JwtAuth {
    private $key = "yixueqiankun";
    private $sub = "kasgfkjashflasfh";//jwt所面向的用户
    private $iss = "haiCheng";// jwt签发者
    private $aud = "http://example.com";//受众
    private $jti = "num12345";//声明为 JWT 提供唯一标识符

    private $token;
    private $uid;
    private static $instance;
    private function __construct() {

    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone() {
        // TODO: Implement __clone() method.
    }

    public function destory($token){
        JWT::$leeway = 3600*24*300;

    }

    /**
     * 解码
     * @return string
     */
    public function decodeToken($token){
        $res = [];
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($token, $this->key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            $res['code'] = 0;
            $res['msg'] = 'success';
            $res['data'] = $arr;

        } catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            $res['code'] = 1;
            $res['msg'] = $e->getMessage();
            $res['data'] = [];
            //echo $e->getMessage();
        }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            $res['code'] = 2;
            $res['msg'] = $e->getMessage();
            $res['data'] = [];
        }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
            $res['code'] = 3;
            $res['msg'] = $e->getMessage();
            $res['data'] = [];
        }catch(Exception $e) {  //其他错误
            $res['code'] = 4;
            $res['msg'] = $e->getMessage();
            $res['data'] = [];
        }
        return $res;
    }

    /**
     * uid
     * @param $uid
     * @return $this
     */
    public function setUid($uid){
        $this->uid = $uid;
        return $this;
    }

    /**
     * JWT编码,生成token
     * @return $this
     */
    public function encodeToken(){
        $time = time();
        $token = [
            "sub" => $this->sub,//jwt所面向的用户
            "iss" => $this->iss,//发行人 jwt签发者
            "aud" => $this->aud,//受众
            //"exp" => $time+3600,//到期时间
            "iat" => $time,//JWT的时间
            //"nbf" => $time,//给定时间之前不能处理
            "jti" => $this->jti,//声明为 JWT 提供唯一标识符
            "data"=>["uid"=>$this->uid]
        ];
        $access_token = $token;
        $access_token['scopes'] = 'role_access'; //token标识，请求接口的token
        $access_token['exp'] = $time+30; //access_token过期时间,这里设置2个小时
        $refresh_token = $token;
        $refresh_token['scopes'] = 'role_refresh'; //token标识，刷新access_token
        $refresh_token['exp'] = $time+300;//(86400 * 30) //access_token过期时间,这里设置30天
        $data = [
            'access_token'=>JWT::encode($access_token,$this->key),
            'refresh_token'=>JWT::encode($refresh_token,$this->key),
            'token_type'=>'bearer' //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
        ];
        return $data;
    }

    public function encodeTokenSingle(){
        $time = time();
        $token = [
            "sub" => $this->sub,//jwt所面向的用户
            "iss" => $this->iss,//发行人 jwt签发者
            "aud" => $this->aud,//受众
            //"exp" => $time+3600,//到期时间
            "iat" => $time,//JWT的时间
            //"nbf" => $time,//给定时间之前不能处理
            "jti" => $this->jti,//声明为 JWT 提供唯一标识符
            "data"=>["uid"=>$this->uid]
        ];
        $access_token = $token;
        $access_token['scopes'] = 'role_access'; //token标识，请求接口的token
        $access_token['exp'] = $time+30; //access_token过期时间,这里设置2个小时
        $data = [
            'access_token'=>JWT::encode($access_token,$this->key),
            'token_type'=>'bearer' //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
        ];
        return $data;
    }
}
