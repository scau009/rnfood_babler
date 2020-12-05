<?php

namespace App\Controller\Admin;

use App\Entity\Coupons;
use App\Service\Coupon\CouponService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CouponsCrudController
 * @package App\Controller\Admin
 * @Route(path="/coupon")
 */
class CouponsCrudController extends AbstractController
{
    /**
     * @Route(path="/index",name="coupon_list")
     * @Template(template="coupon/index.html.twig")
     * @param Request $request
     * @param CouponService $couponService
     * @param PaginatorInterface $paginator
     */
    public function index(Request $request, CouponService $couponService, PaginatorInterface $paginator)
    {
        $pagination = $couponService->getList($request->query, $paginator);
        return compact('pagination');
    }

    /**
     * @Route(path="/new",name="new_coupon",methods={"GET","POST"})
     * @param Request $request
     * @param CouponService $couponService
     * @Template(template="coupon/new.html.twig")
     */
    public function new(Request $request,CouponService $couponService)
    {
        if ($request->isMethod("GET")) {

        }else{
            $coupon = $couponService->createCoupon($request);
            return $this->redirectToRoute('coupon_list');
        }
    }

    /**
     * @Route(path="/show/{id}",name="show_coupon",methods={"GET"})
     * @param Coupons $coupon
     * @Template(template="coupon/show.html.twig")
     */
    public function show(Coupons $coupon)
    {
        return compact('coupon');
    }

    /**
     * @Route(path="/edit/{id}",name="edit_coupon",methods={"GET","POST"})
     * @param Coupons $coupon
     * @param Request $request
     * @param CouponService $couponService
     * @Template(template="coupon/edit.html.twig")
     */
    public function edit(Coupons $coupon,Request $request,CouponService $couponService)
    {
        if ($request->isMethod("GET")) {
            return compact('coupon');
        }else{
            $couponService->editOne($coupon, $request);
            $this->addFlash("success","修改成功！");
            return $this->redirectToRoute('show_coupon',['id'=>$coupon->getId()]);
        }
    }

    /**
     * @Route(path="/delete/{id}",name="delete_coupon",methods={"POST"})
     * @param Coupons $coupon
     * @param CouponService $couponService
     */
    public function delete(Coupons $coupon,CouponService $couponService)
    {
        $couponService->deleteOne($coupon);
        $this->addFlash("success","删除成功！");
        return $this->redirectToRoute('coupon_list');
    }
}
