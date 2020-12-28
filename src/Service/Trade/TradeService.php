<?php


namespace App\Service\Trade;

use App\Entity\Embed\Buyer;
use App\Entity\Embed\OrderPayment;
use App\Entity\Embed\TradePayment;
use App\Entity\Orders;
use App\Entity\Products;
use App\Entity\Trades;
use App\Repository\TradesRepository;
use App\Security\User\JwtUser;
use App\Service\Product\ProductService;
use App\Service\WeChat\WeChatMpPayService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class TradeService
{
    private EntityManagerInterface $entityManager;

    private TradesRepository $tradeRepo;

    private ProductService $productService;

    public function __construct(EntityManagerInterface $entityManager,ProductService $productService)
    {
        $this->entityManager = $entityManager;
        $this->tradeRepo = $entityManager->getRepository(Trades::class);
        $this->productService = $productService;
    }

    public function getList(ParameterBag $parameterBag, PaginatorInterface $paginator)
    {
        $page = $parameterBag->get('page',1);
        $pageSize = $parameterBag->get('pageSize',20);
        $query = $this->tradeRepo->findAllBySort(['createAt'=>'Desc']);
        return $paginator->paginate($query, $page, $pageSize);
    }

    public function getListByClient(JwtUser $user, ParameterBag $parameterBag, PaginatorInterface $paginator)
    {
        $page = $parameterBag->get('page',1);
        $pageSize = $parameterBag->get('pageSize',20);
        $status = $parameterBag->get('status','');
        $query = $this->tradeRepo->findAllByClientId($user->getEntity()->getId(),$status);
        return $paginator->paginate($query, $page, $pageSize);
    }

    public function editOne(Trades $trade, Request $request)
    {
        return $trade;
    }

    /**
     * @param string $tid
     * @return int|mixed|string|null
     */
    public function getOneByTid(string $tid)
    {
        return $this->tradeRepo->findOneByTid($tid);
    }

    public function getOneById(string $id)
    {
        return $this->tradeRepo->findOneById($id);
    }

    public function createOne(Request $request,JwtUser $user)
    {
        $productId = $request->get('productId');
        $name = $request->get('name');
        $mobile = $request->get('mobile');
        $number = $request->get('number');

        /** @var Products $product */
        $product = $this->productService->getOne($productId);

        if (!$product || $product->getStatus() != 'onsale') {
            throw new \Exception("找不到商品");
        }else{
            $trade = new Trades();
            $trade->setStatus(Trades::STATUS_WAIT_PAY);
            $buyer = new Buyer();
            $buyer->setId($user->getEntity()->getId());
            $buyer->setAvatar($user->getEntity()->getAvatar());
            $buyer->setMobile($user->getEntity()->getMobile());
            $buyer->setName($user->getEntity()->getUsername());
            $trade->setBuyer($buyer);
            $trade->setTid($tradeId = $this->generateTradeId());

            $order = new Orders();
            $order->setNum($number);
            $embedProduct = new \App\Entity\Embed\Products();
            $embedProduct->setId($product->getId());
            $embedProduct->setTitle($product->getTitle());
            $embedProduct->setPrice($product->getPrice());
            $embedProduct->setHeadImage($product->getHeadImage());
            $embedProduct->setDescription($product->getDescription());
            $embedProduct->setPriceWas($product->getPriceWas());
            $stores = $product->getStores()->toArray();
            $storeIds = array_map( function ($item) {
                return $item->getId();
            },$stores);
            $embedProduct->setStoreIds($storeIds);
            $order->setProduct($embedProduct);
            $order->setOid($tradeId.'-0');
            $order->setTrades($trade);
            $orderPayment = new OrderPayment();
            $orderPayment->setPrice($embedProduct->getPrice());
            $order->setPayment($orderPayment);
            $trade->addOrder($order);
            $tradePayment = new TradePayment();
            $tradePayment->setPrice($embedProduct->getPrice());
            $trade->setPayment($tradePayment);
            $this->entityManager->persist($trade);
            $this->entityManager->persist($order);
            $this->entityManager->flush();

            return $trade;
        }
    }

    private function generateTradeId()
    {
        $timestamp = (string)time();
        $random = rand(1, 9999);
        $random = str_pad($random, 4, '0', STR_PAD_LEFT);
        return $timestamp . $random;
    }
}