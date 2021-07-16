<?php

namespace App\Http\Controllers\Index;
use App\Common\Auth\JwtAuth;
use App\Common\Err\ApiErrorDesc;
use App\Http\Response\ResponseJson;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    use ResponseJson;
    public function index(){

        $userId = 126;
        $jwtAuth = JwtAuth::getInstance();
//        //生成token
//        $token = $jwtAuth->setUid($userId)->encodeToken();
//        var_dump($token);exit;
//        echo $token['access_token'].PHP_EOL;
        $token1 = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJrYXNnZmtqYXNoZmxhc2ZoIiwiaXNzIjoiaGFpQ2hlbmciLCJhdWQiOiJodHRwOlwvXC9leGFtcGxlLmNvbSIsImlhdCI6MTYyNjQxOTg2MSwianRpIjoibnVtMTIzNDUiLCJkYXRhIjp7InVpZCI6MTI2fSwic2NvcGVzIjoicm9sZV9hY2Nlc3MiLCJleHAiOjE2MjY0MTk4OTF9.S4qgkK2ju7KsoaJn4Gq7ZIn7U9mPkJOlxvMMSgOD-vc';
        $token2 = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJrYXNnZmtqYXNoZmxhc2ZoIiwiaXNzIjoiaGFpQ2hlbmciLCJhdWQiOiJodHRwOlwvXC9leGFtcGxlLmNvbSIsImlhdCI6MTYyNjQxOTg2MSwianRpIjoibnVtMTIzNDUiLCJkYXRhIjp7InVpZCI6MTI2fSwic2NvcGVzIjoicm9sZV9yZWZyZXNoIiwiZXhwIjoxNjI2NDIwMTYxfQ.WjHtT2_OUHfDgO1hPk5FyHLYAxxgERNuPcJShxyzv0w';

        //解密
        $decodeData1 = $jwtAuth->decodeToken($token1);

        //dd($decodeData1);
        if($decodeData1['code']!=0){
            $decodeData2 = $jwtAuth->decodeToken($token2);
            if($decodeData2['code']!=0){
                //重新登陆
                return $this->jsonData(ApiErrorDesc::TOKEN_EXPIRED[0],ApiErrorDesc::TOKEN_EXPIRED[1]);
            }
        }
        $token = $jwtAuth->setUid($userId)->encodeTokenSingle();
        $token['refresh_token'] = $token2;
        return $this->jsonSuccessData(ApiErrorDesc::SUCCESS[1]);




        //dd($jwtAuth->decodeToken($token['access_token']));
        //return $this->jsonSuccessData($token);
    }


}
