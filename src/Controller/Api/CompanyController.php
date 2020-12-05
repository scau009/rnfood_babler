<?php


namespace App\Controller\Api;

use App\Response\CMDJsonResponse;
use App\Service\Company\CompanyService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CompanyController
 * @package App\Controller\Api
 * @Route(path="/api/company")
 */
class CompanyController extends BaseApiController
{
    /**
     * @Route(path="/list",methods={"GET"})
     * @param Request $request
     * @param CompanyService $companyService
     * @return CMDJsonResponse
     */
    public function getCompanyListAction(Request $request,CompanyService $companyService)
    {
        $page = $request->get('page',1);
        $pageSize = $request->get('pageSize',20);

        $companies = $companyService->getList($page,$pageSize);
        return $this->returnJson($this->normalizeList($page,$pageSize,$companies));
    }
}