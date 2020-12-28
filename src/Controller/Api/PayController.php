<?php


namespace App\Controller\Api;

use App\Service\WeChat\WechatMpPayNotifyService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Rest\Route(path="/notify",name="notify")
     * @Rest\View(serializerGroups={"api"})
     * @param Request $request
     * @param LoggerInterface $notifyLogger
     */
    public function tradePayNotify(Request $request, WechatMpPayNotifyService $wechatMpPayNotifyService)
    {
        $wechatMpPayNotifyService->handleNotify();
        return new JsonResponse(compact('query','request'));
    }
}