<?php


namespace App\Service\WeChat;


use App\Entity\Trades;
use App\Service\Trade\TradeService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class WechatMpPayNotifyService
{
    private WeChatMpPayService $weChatMpPayService;

    private LoggerInterface $logger;

    private EntityManagerInterface $entityManager;

    private TradeService $tradeService;

    public function __construct(WeChatMpPayService $weChatMpPayService,
                                LoggerInterface $notifyLogger,
                                EntityManagerInterface $entityManager,
                                TradeService $tradeService)
    {
        $this->weChatMpPayService = $weChatMpPayService;
        $this->logger = $notifyLogger;
        $this->tradeService = $tradeService;
        $this->entityManager = $entityManager;
    }

    public function handleNotify()
    {
        return $this->weChatMpPayService->getApp()->handlePaidNotify(function ($message,$fail){
            $this->logger->info("微信支付回调：".json_encode($message));
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            /** @var Trades $trade */
            $trade = $this->tradeService->getOneByTid($message['out_trade_no']);

            if (!$trade || $trade->getPayAt()) { // 如果订单不存在 或者 订单已经支付过了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            $wxTrade = $this->weChatMpPayService->getApp()->order->queryByOutTradeNumber($message['out_trade_no']);

            $this->logger->info("微信支付流水订单：".json_encode($wxTrade));

            if ($wxTrade['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if ($wxTrade['result_code'] && $wxTrade['result_code'] === 'SUCCESS') {
                    $trade->setPayAt(new \DateTime()); // 更新支付时间为当前时间
                    $trade->setStatus(Trades::STATUS_PAID);
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }

            $this->entityManager->persist($trade);
            $this->entityManager->flush();

            return true; // 返回处理完成
        });
    }
}