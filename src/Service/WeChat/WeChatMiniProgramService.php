<?php


namespace App\Service\WeChat;


use EasyWeChat\Factory;
use EasyWeChat\MiniProgram\Application;

class WeChatMiniProgramService
{
    private Application $app;

    public function __construct(string $appId, string $appSecret, string $logLevel = 'debug', string $logFile = '')
    {
        $config = [
            'app_id' => $appId,
            'secret' => $appSecret,

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => $logLevel,
                'file' => $logFile ? $logFile : __DIR__.'/../../../var/log/weChatMiniProgram.log',
            ],
        ];

        $this->app = Factory::miniProgram($config);
    }


    public function login(string $code)
    {
        $response = $this->app->auth->session($code);
        return [$response['session_key'], $response['openid']];
    }

    public function decryptData($session, $iv, $encryptedData)
    {
        return $this->app->encryptor->decryptData($session, $iv, $encryptedData);
    }


}