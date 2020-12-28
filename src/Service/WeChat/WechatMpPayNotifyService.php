<?php


namespace App\Service\WeChat;


use Psr\Log\LoggerInterface;

class WechatMpPayNotifyService
{
    private WeChatMpPayService $weChatMpPayService;

    private LoggerInterface $logger;

    public function __construct(WeChatMpPayService $weChatMpPayService,LoggerInterface $notifyLogger)
    {
        $this->weChatMpPayService = $weChatMpPayService;
        $this->logger = $notifyLogger;
    }

    public function handleNotify()
    {
        return $this->weChatMpPayService->getApp()->handlePaidNotify(function ($message,$fail){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $this->logger->info(json_encode($message));

        });
    }
}