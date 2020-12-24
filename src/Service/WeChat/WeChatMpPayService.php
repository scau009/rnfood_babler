<?php


namespace App\Service\WeChat;


use App\Entity\Clients;
use App\Entity\Trades;
use EasyWeChat\Factory;
use EasyWeChat\Payment\Application;

class WeChatMpPayService
{
    private Application $app;

    public function __construct(string $appId, string $merchId, string $key , string $certPath, string $keyPath, string $notifyUrl)
    {
        $config = [
            // 必要配置
            'app_id'             => $appId,
            'mch_id'             => $merchId,
            'key'                => $key,   // API 密钥

            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            'cert_path'          => $certPath, // XXX: 绝对路径！！！！
            'key_path'           => $keyPath,      // XXX: 绝对路径！！！！

            'notify_url'         => $notifyUrl,     // 你也可以在下单时单独设置来想覆盖它
//            'sandbox'            => true, // 设置为 false 或注释则关闭沙箱模式
        ];
        $this->app = Factory::payment($config);
    }

    public function getOpenId()
    {
//        $this->app->authCodeToOpenid($authCode);
    }
    public function createOrder(Clients $client,Trades $trade)
    {
        $d = 'sdsd';
        $result = $this->app->order->unify([
            'body' => 'rnfoodTest',
            'out_trade_no' => $trade->getTid(),
            'total_fee' => $trade->getPayment()->getPrice() * 100,
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => $client->getOpenId(),
        ]);

        if ($result['return_code'] && $result['return_code'] == "FAIL") {
            throw new \Exception("调用微信统一下单接口失败，".$result['return_msg']);
        }
        $config = $this->app->jssdk->bridgeConfig($result['prepay_id']);
        return json_decode($config, true);
    }
}