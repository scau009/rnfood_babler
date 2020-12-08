<?php


namespace App\Controller\Api;

use App\Response\CMDJsonResponse;
use App\Service\Company\CompanyService;
use App\Service\Store\StoreService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StoresController
 * @package App\Controller\Api
 * @Route(path="/stores")
 */
class StoresController extends BaseApiController
{
    /**
     * @Route(path="/list",methods={"GET"})
     * @param Request $request
     * @param StoreService $storeService
     * @param PaginatorInterface $paginator
     * @return CMDJsonResponse
     */
    public function getStoreListAction(Request $request,StoreService $storeService,PaginatorInterface $paginator)
    {
        $page = $request->get('page', 1);
        $pageSize = $request->get('pageSize', 20);
        $companies = $storeService->getList($request->request,$paginator);
        return $this->returnJson($this->normalizeList($page,$pageSize,$companies));
    }
}