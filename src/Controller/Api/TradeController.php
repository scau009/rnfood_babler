<?php


namespace App\Controller\Api;

use App\Entity\Trades;
use App\Service\Coupon\CouponService;
use App\Service\Store\StoreService;
use App\Service\Trade\TradeService;
use App\Service\WeChat\WeChatMpPayService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
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
     * @param CouponService $couponService
     * @Rest\View(serializerGroups={"api"})
     * @throws \Exception
     */
    public function createTradeAction(Request $request,TradeService $tradeService,
                                      WeChatMpPayService $payService,CouponService $couponService)
    {
        $client = $this->user;
        $trade = $tradeService->createOne($request,$client);
        //微信支付
        $wxOrder = $payService->createOrder($client->getEntity(),$trade);
        return View::create(compact('trade','wxOrder'));
    }

    /**
     * @Route(path="/detail",methods={"GET"})
     * @param Request $request
     * @param TradeService $tradeService
     * @param StoreService $storeService
     * @Rest\View(serializerGroups={"api"})
     */
    public function getTradeAction(Request $request,TradeService $tradeService,StoreService $storeService)
    {
        /** @var Trades $trade */
        $trade = $tradeService->getOneByTid($request->get('tid'));
        if ($trade) {
            foreach ($trade->getOrders() as $order) {
                $product = $order->getProduct();
                $stores = $storeService->getByIds($product->getStoreIds());
                $product->setStores($stores);
            }
        }
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
        $tradePagination = $tradeService->getListByClient($this->user,$request->query,$paginator);
        $list = $tradePagination->getItems();
        $paginate = [
            'total' => $tradePagination->getTotalItemCount(),
            'page' => $tradePagination->getCurrentPageNumber(),
            'pageSize' => $tradePagination->getItemNumberPerPage(),
            'hasNext' => $tradePagination->getCurrentPageNumber() * $tradePagination->getItemNumberPerPage() < $tradePagination->getTotalItemCount()
        ];
        return View::create(compact('list','paginate'));
    }
}