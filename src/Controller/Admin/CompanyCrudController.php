<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Service\Company\CompanyService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CompanyCrudController
 * @package App\Controller\Admin
 * @Route(path="/company")
 */
class CompanyCrudController extends AbstractController
{
    /**
     * @Route(path="/index",name="company_list")
     * @Template(template="company/index.html.twig")
     * @param Request $request
     * @param CompanyService $companyService
     * @param PaginatorInterface $paginator
     */
    public function index(Request $request, CompanyService $companyService, PaginatorInterface $paginator)
    {
        $pagination = $companyService->getList($request->query, $paginator);
        return compact('pagination');
    }

    /**
     * @Route(path="/new",name="new_company",methods={"GET","POST"})
     * @param Request $request
     * @param CompanyService $companyService
     * @Template(template="company/new.html.twig")
     */
    public function new(Request $request,CompanyService $companyService)
    {
        if ($request->isMethod("GET")) {

        }else{
            $company = $companyService->createCompany($request);
            return $this->redirectToRoute('company_list');
        }
    }

    /**
     * @Route(path="/show/{id}",name="show_company",methods={"GET"})
     * @param Company $company
     * @Template(template="company/show.html.twig")
     */
    public function show(Company $company)
    {
        return compact('company');
    }

    /**
     * @Route(path="/edit/{id}",name="edit_company",methods={"GET","POST"})
     * @param Company $company
     * @param Request $request
     * @param CompanyService $companyService
     * @Template(template="company/edit.html.twig")
     */
    public function edit(Company $company,Request $request,CompanyService $companyService)
    {
        if ($request->isMethod("GET")) {
            return compact('company');
        }else{
            $companyService->editOne($company, $request);
            $this->addFlash("success","修改成功！");
            return $this->redirectToRoute('show_company',['id'=>$company->getId()]);
        }
    }

    /**
     * @Route(path="/delete/{id}",name="delete_company",methods={"POST"})
     * @param Company $company
     * @param CompanyService $companyService
     */
    public function delete(Company $company,CompanyService $companyService)
    {
        $companyService->deleteOne($company);
        $this->addFlash("success","删除成功！");
        return $this->redirectToRoute('company_list');
    }
}
