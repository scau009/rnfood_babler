<?php


namespace App\Service\Coupon;

use App\Entity\Clients;
use App\Entity\Coupons;
use App\Entity\Products;
use App\Entity\Trades;
use App\Repository\CouponsRepository;
use App\Service\QrCode\QrCodeGenerator;
use App\Utils\CouponNoGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\QrCode;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class CouponService
{
    private EntityManagerInterface $entityManager;

    private CouponsRepository $couponRepo;

    private QrCodeGenerator $qrCodeGenerator;

    public function __construct(EntityManagerInterface $entityManager,QrCodeGenerator $qrCodeGenerator)
    {
        $this->entityManager = $entityManager;
        $this->qrCodeGenerator = $qrCodeGenerator;
        $this->couponRepo = $entityManager->getRepository(Coupons::class);
    }

    public function getList(ParameterBag $parameterBag, PaginatorInterface $paginator)
    {
        $page = $parameterBag->get('page',1);
        $pageSize = $parameterBag->get('pageSize',20);
        $query = $this->couponRepo->findAll();
        return $paginator->paginate($query, $page, $pageSize);
    }

    public function createCoupon(ParameterBag $request)
    {
        $clientId = $request->get('clientId');
        /** @var Clients $client */
        $client = $this->entityManager->getRepository(Clients::class)->find($clientId);
        $productId = $request->get('productId');
        /** @var Products $product */
        $product = $this->entityManager->getRepository(Products::class)->find($productId);
        $coupon = new Coupons();
        $coupon->setCouponNo(CouponNoGenerator::getNo());
        $embedProduct = new \App\Entity\Embed\Products();
        $embedProduct->setTitle($product->getTitle());
        $embedProduct->setPriceWas($product->getPriceWas());
        $embedProduct->setPrice($product->getPrice());
        $embedProduct->setDescription($product->getDescription());
        $embedProduct->setId($product->getId());
        $coupon->setProduct($embedProduct);
        $coupon->setType($request->get('type'));
        foreach ($product->getStores() as $store) {
            $coupon->addStore($store);
        }
        $coupon->setClient($client);
        $coupon->setProductId($productId);
        $coupon->setBeginAt(new \DateTime($request->get('begin_at')));
        $coupon->setExpireAt(new \DateTime($request->get('expire_at')));
        $coupon->setStatus(Coupons::STATUS_WAIT_USE);
        $coupon->setQrCode($this->qrCodeGenerator->generateCouponQrCode($coupon));
        $this->entityManager->persist($coupon);
        $this->entityManager->flush();
        return $coupon;
    }

    public function createCouponByTrade(Trades $trade)
    {
        $coupons = [];
        /** @var Clients $client */
        $client = $this->entityManager->getRepository(Clients::class)->find($trade->getBuyer()->getId());
        foreach ($trade->getOrders() as $order) {
            /** @var Products $product */
            $product = $order->getProduct();
            $coupon = new Coupons();
            $coupon->setCouponNo(CouponNoGenerator::getNo());
            $embedProduct = new \App\Entity\Embed\Products();
            $embedProduct->setTitle($product->getTitle());
            $embedProduct->setPriceWas($product->getPriceWas());
            $embedProduct->setPrice($product->getPrice());
            $embedProduct->setDescription($product->getDescription());
            $embedProduct->setId($product->getId());
            $coupon->setProduct($embedProduct);
            $coupon->setType('buy');
            foreach ($product->getStores() as $store) {
                $coupon->addStore($store);
            }
            $coupon->setClient($client);
            $coupon->setProductId($product->getId());
            $coupon->setBeginAt(new \DateTime());
            $coupon->setExpireAt((new \DateTime())->add(new \DateInterval("P1Y")));
            $coupon->setStatus(Coupons::STATUS_WAIT_USE);
            $coupon->setOrders($order);
            $coupon->setQrCode($this->qrCodeGenerator->generateCouponQrCode($coupon));
            $this->entityManager->persist($coupon);
            $coupons[] = $coupon;
        }
        $this->entityManager->flush();
        return $coupons;
    }

    public function deleteOne(Coupons $coupons)
    {
        $this->entityManager->remove($coupons);
        $this->entityManager->flush();
    }

    public function editOne(Coupons $coupon, Request $request)
    {
        $clientId = $request->get('clientId');
        /** @var Clients $client */
        $client = $this->entityManager->getRepository(Clients::class)->find($clientId);
        $coupon->setClient($client);
        $coupon->setBeginAt(new \DateTime($request->get('begin_at')));
        $coupon->setExpireAt(new \DateTime($request->get('expire_at')));
        $coupon->setStatus($request->get('status'));
        $this->entityManager->persist($coupon);
        $this->entityManager->flush();
        return $coupon;
    }
}