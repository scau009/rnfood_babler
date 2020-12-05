<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Service\Product\ProductService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductsCrudController
 * @package App\Controller\Admin
 * @Route(path="/product")
 */
class ProductsCrudController extends AbstractController
{
    /**
     * @Route(path="/index",name="product_list")
     * @Template(template="product/index.html.twig")
     * @param Request $request
     * @param ProductService $productService
     * @param PaginatorInterface $paginator
     */
    public function index(Request $request, ProductService $productService, PaginatorInterface $paginator)
    {
        $pagination = $productService->getList($request->query, $paginator);
        return compact('pagination');
    }

    /**
     * @Route(path="/new",name="new_product",methods={"GET","POST"})
     * @param Request $request
     * @param ProductService $productService
     * @Template(template="product/new.html.twig")
     */
    public function new(Request $request,ProductService $productService)
    {
        if ($request->isMethod("GET")) {

        }else{
            $product = $productService->createProduct($request);
            return $this->redirectToRoute('product_list');
        }
    }

    /**
     * @Route(path="/show/{id}",name="show_product",methods={"GET"})
     * @param Products $product
     * @Template(template="product/show.html.twig")
     */
    public function show(Products $product)
    {
        return compact('product');
    }

    /**
     * @Route(path="/edit/{id}",name="edit_product",methods={"GET","POST"})
     * @param Products $product
     * @param Request $request
     * @param ProductService $productService
     * @Template(template="product/edit.html.twig")
     */
    public function edit(Products $product,Request $request,ProductService $productService)
    {
        if ($request->isMethod("GET")) {
            return compact('product');
        }else{
            $productService->editOne($product, $request);
            $this->addFlash("success","修改成功！");
            return $this->redirectToRoute('show_product',['id'=>$product->getId()]);
        }
    }

    /**
     * @Route(path="/delete/{id}",name="delete_product",methods={"POST"})
     * @param Products $products
     * @param ProductService $productService
     */
    public function delete(Products $products,ProductService $productService)
    {
        $productService->deleteOne($products);
        $this->addFlash("success","删除成功！");
        return $this->redirectToRoute('product_list');
    }
}
