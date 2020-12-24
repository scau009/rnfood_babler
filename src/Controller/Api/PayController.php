<?php


namespace App\Controller\Api;

use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PayController
 * @package App\Controller\Api
 * @Route(path="/pay")
 */
class PayController extends BaseApiController
{
    /**
     * @Route(path="/notify",name="notify")
     */
    public function tradePayNotify(Request $request, LoggerInterface $logger)
    {
        $logger->info("微信支付回调");
        $logger->info(json_encode($request->request->all()));
        return View::create("sdsd");
    }
}