<?php


namespace App\Controller\Api;

use App\Service\Trade\TradeService;
use App\Service\WeChat\WeChatMpPayService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StoresController
 * @package App\Controller\Api
 * @Route(path="/trades")
 */
class TradeController extends BaseApiController
{
    /**
     * @Route(path="/create",methods={"POST"})
     * @param Request $request
     * @param TradeService $tradeService
     * @param WeChatMpPayService $payService
     * @Rest\View(serializerGroups={"api"})
     * @throws \Exception
     */
    public function createTradeAction(Request $request,TradeService $tradeService, WeChatMpPayService $payService)
    {
        $client = $this->user;
        $trade = $tradeService->createOne($request,$client);
        //微信支付
        $wxOrder = $payService->createOrder($client->getEntity(),$trade);
        return View::create(compact('trade','wxOrder'));
    }

    /**
     * @Route(path="/get",methods={"GET"})
     * @param Request $request
     * @param TradeService $tradeService
     * @Rest\View(serializerGroups={"api"})
     */
    public function getTradeAction(Request $request,TradeService $tradeService)
    {
        $trade = $tradeService->getOneByTid($request->get('tid'));
        return View::create($trade);
    }


    /**
     * @Rest\Route(path="/list",methods={"GET"})
     * @param Request $request
     * @param TradeService $tradeService
     * @param PaginatorInterface $paginator
     * @Rest\View(serializerGroups={"api"})
     */
    public function getTradeListAction(Request $request, TradeService $tradeService,PaginatorInterface $paginator)
    {
        $trade = $tradeService->getListByClient($this->user,$request->query,$paginator);
        return View::create($trade);
    }
}