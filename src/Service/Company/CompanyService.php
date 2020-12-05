<?php


namespace App\Service\Company;


use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class CompanyService
{
    private EntityManagerInterface $entityManager;

    private CompanyRepository $companyRepo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->companyRepo = $entityManager->getRepository(Company::class);
    }

    public function getList(ParameterBag $parameterBag, PaginatorInterface $paginator)
    {
        $page = $parameterBag->get('page',1);
        $pageSize = $parameterBag->get('pageSize',20);
        $query = $this->companyRepo->findAll();
        return $paginator->paginate($query, $page, $pageSize);
    }

    public function createCompany(Request $request)
    {
        $company = new Company();
        $company->setTitle($request->get('title'));
        $company->setStatus($request->get('status'));
        $this->entityManager->persist($company);
        $this->entityManager->flush();
        return $company;
    }

    public function deleteOne(Company $company)
    {
        if ($company->getStores()->count() > 0) {
            throw new \Exception("当前公司名下有至少一家门店，不允许删除");
        }
        $this->entityManager->remove($company);
        $this->entityManager->flush();
    }

    public function editOne(Company $company, Request $request)
    {
        $company->setTitle($request->get('title'));
        $company->setStatus($request->get('status'));
        $this->entityManager->persist($company);
        $this->entityManager->flush();
        return $company;
    }
}