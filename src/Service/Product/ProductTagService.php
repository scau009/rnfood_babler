<?php


namespace App\Service\Product;

use App\Entity\ProductTags;
use App\Repository\ProductTagsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class ProductTagService
{
    private EntityManagerInterface $entityManager;

    private ProductTagsRepository $productTagsRepo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->productTagsRepo = $entityManager->getRepository(ProductTags::class);
    }

    public function getList(ParameterBag $parameterBag, PaginatorInterface $paginator)
    {
        $page = $parameterBag->get('page',1);
        $pageSize = $parameterBag->get('pageSize',20);
        $query = $this->productTagsRepo->findAll();
        return $paginator->paginate($query, $page, $pageSize);
    }

    public function createProductTag(Request $request)
    {
        $productTag = new ProductTags();
        $productTag->setLabel($request->get('label'));
        $this->entityManager->persist($productTag);
        $this->entityManager->flush();
        return $productTag;
    }

    public function deleteOne(ProductTags $productTags)
    {
        if ($productTags->getProducts()->count() > 0) {
            throw new \Exception("当前标签与商品绑定中，不允许删除");
        }
        $this->entityManager->remove($productTags);
        $this->entityManager->flush();
    }

    public function editOne(ProductTags $productTags, Request $request)
    {
        $productTags->setLabel($request->get('label'));
        $this->entityManager->persist($productTags);
        $this->entityManager->flush();
        return $productTags;
    }
}