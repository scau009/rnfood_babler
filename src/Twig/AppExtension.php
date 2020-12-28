<?php

namespace App\Twig;

use App\Entity\Company;
use App\Entity\Products;
use App\Entity\ProductTags;
use App\Entity\Stores;
use App\Entity\Trades;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
//            new TwigFilter('filter_name', [$this, 'doSomething']),
            new TwigFilter('getOrderTableBg', [$this, 'getOrderTableBg']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('store_list', [$this, 'getStoreList']),
            new TwigFunction('tag_list', [$this, 'getTagList']),
            new TwigFunction('company_list', [$this, 'getCompanyList']),
            new TwigFunction('product_list', [$this, 'getProductList']),
            new TwigFunction('role_list', [$this, 'getRoleList']),
        ];
    }

    public function getProductList()
    {
        return $this->entityManager->getRepository(Products::class)->findAll();
    }

    public function getCompanyList()
    {
        return $this->entityManager->getRepository(Company::class)->findAll();
    }

    public function getStoreList()
    {
        return $this->entityManager->getRepository(Stores::class)->findAll();
    }

    public function getTagList()
    {
        return $this->entityManager->getRepository(ProductTags::class)->findAll();
    }

    public function getRoleList()
    {
        return [
            ['id'=>"ROLE_USER" ,'label'=> "普通账号"],
            ['id'=>"ROLE_ADMIN" ,'label'=>"管理员账号"],
        ];
    }

    public function getOrderTableBg(string $status)
    {
        $mapping = [
            Trades::STATUS_PAID => 'bg-azure-lt',
            Trades::STATUS_WAIT_PAY => '',
            Trades::STATUS_FINISHED => 'bg-green-lt',
            Trades::STATUS_CANCELED => '',
        ];

        return isset($mapping[$status]) ? $mapping[$status] : '';
    }
}
