<?php

namespace App\Controller\Admin;

use App\Entity\ProductTags;
use App\Service\Product\ProductTagService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductTagsCrudController
 * @package App\Controller\Admin
 * @Route(path="/productTag")
 */
class ProductTagsCrudController extends AbstractController
{
    /**
     * @Route(path="/index",name="product_tag_list")
     * @Template(template="product_tag/index.html.twig")
     * @param Request $request
     * @param ProductTagService $ProductTagService
     * @param PaginatorInterface $paginator
     */
    public function index(Request $request, ProductTagService $ProductTagService, PaginatorInterface $paginator)
    {
        $pagination = $ProductTagService->getList($request->query, $paginator);
        return compact('pagination');
    }

    /**
     * @Route(path="/new",name="new_product_tag",methods={"GET","POST"})
     * @param Request $request
     * @param ProductTagService $ProductTagService
     * @Template(template="product_tag/new.html.twig")
     */
    public function new(Request $request,ProductTagService $ProductTagService)
    {
        if ($request->isMethod("GET")) {

        }else{
            $product = $ProductTagService->createProductTag($request);
            return $this->redirectToRoute('product_tag_list');
        }
    }

    /**
     * @Route(path="/show/{id}",name="show_product_tag",methods={"GET"})
     * @param ProductTags $productTag
     * @Template(template="product_tag/show.html.twig")
     */
    public function show(ProductTags $productTag)
    {
        return compact('productTag');
    }

    /**
     * @Route(path="/edit/{id}",name="edit_product_tag",methods={"GET","POST"})
     * @param ProductTags $productTag
     * @param Request $request
     * @param ProductTagService $ProductTagService
     * @Template(template="product_tag/edit.html.twig")
     */
    public function edit(ProductTags $productTag,Request $request,ProductTagService $ProductTagService)
    {
        if ($request->isMethod("GET")) {
            return compact('productTag');
        }else{
            $ProductTagService->editOne($productTag, $request);
            $this->addFlash("success","修改成功！");
            return $this->redirectToRoute('show_product_tag',['id'=>$productTag->getId()]);
        }
    }

    /**
     * @Route(path="/delete/{id}",name="delete_product_tag",methods={"POST"})
     * @param ProductTags $ProductTagS
     * @param ProductTagService $ProductTagService
     */
    public function delete(ProductTags $ProductTagS,ProductTagService $ProductTagService)
    {
        try {
            $ProductTagService->deleteOne($ProductTagS);
            $this->addFlash("success","删除成功！");
            return $this->redirectToRoute('product_tag_list');
        } catch (\Exception $exception) {
            $this->addFlash("error", $exception->getMessage());
            return $this->redirectToRoute('product_tag_list');
        }
    }
}
