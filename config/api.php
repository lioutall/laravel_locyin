<?php

return [
    /*
     * 接口频率限制
     */
    'rate_limits' => [
        // 访问频率限制，次数/分钟
        'access' =>  env('RATE_LIMITS', '200,1'),
        // 登录相关，次数/分钟
        'sign' =>  env('SIGN_RATE_LIMITS', '10,1'),
    ],
    'pagination'=> [
        // 游记分页
        'dynamic' =>  env('DYNAMIC_PER_PAGE', '10'),
        // 短视频分页
        'vlog' =>  env('VLOG_PER_PAGE', '10'),
    ],
];
