<?php


namespace App\Common\Err;


class ApiErrorDesc {

    /**
     * 通用错误码0-100
     */
    const SUCCESS = [0,'success'];
    const UNKNOWN_ERR = [1,'未知错误'];
    const ERR_URL = [2,'接口不存在'];

    /**
     * 通用错误码100-120
     */
    const ERR_PARAMS = [100,'参数错误'];

    /**
     * 通用错误码1000-1100
     */
    const TOKEN_EXPIRED = [1000,'TOKEN已过期'];


}
