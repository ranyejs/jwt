<?php


namespace App\Http\Response;


trait ResponseJson
{
    public function jsonData($code,$msg='',$data=[]){
        return $this->jsonResponse($code,$msg,$data);
    }
    public function jsonSuccessData($data=[]){
        return $this->jsonResponse(0,'success',$data);
    }

    private function jsonResponse($code,$msg,$data){
        $content = [
            'code' => $code,
            'msg'=>$msg,
            'data'=>$data,
        ];
        return json_encode($content);//JSON_UNESCAPED_UNICODE
    }
}
