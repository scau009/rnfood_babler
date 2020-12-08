<?php


namespace App\Controller\Api;

use App\Response\CMDJsonResponse;
use App\Service\Product\ProductService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StoresController
 * @package App\Controller\Api
 * @Route(path="/product")
 */
class ProductController extends BaseApiController
{
    /**
     * @Rest\Get(path="/list",methods={"GET"})
     * @param Request $request
     * @param ProductService $productService
     * @param PaginatorInterface $paginator
     * @Rest\View(serializerGroups={"api"})
     */
    public function getProductListAction(Request $request,ProductService $productService,PaginatorInterface $paginator)
    {
        $page = $request->get('page', 1);
        $pageSize = $request->get('pageSize', 20);
        $products = $productService->getList($request->request,$paginator);
        return View::create($products);
//        return $this->returnJson($this->normalizeList($page,$pageSize,$companies));
    }

    /**
     * @Rest\Get(path="/detail")
     * @param Request $request
     * @param ProductService $productService
     * @Rest\View(serializerGroups={"api"})
     */
    public function getProductAction(Request $request,ProductService $productService)
    {
        $id = $request->get('id');
        if (empty($id)) {
            throw new \Exception("参数错误");
        }

        $product = $productService->getOne($request->get('id'));
        return View::create($product);
    }
}