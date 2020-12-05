<?php


namespace App\Service\Trade;

use App\Entity\Trades;
use App\Repository\TradesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class TradeService
{
    private EntityManagerInterface $entityManager;

    private TradesRepository $tradeRepo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->tradeRepo = $entityManager->getRepository(Trades::class);
    }

    public function getList(ParameterBag $parameterBag, PaginatorInterface $paginator)
    {
        $page = $parameterBag->get('page',1);
        $pageSize = $parameterBag->get('pageSize',20);
        $query = $this->tradeRepo->findAll();
        return $paginator->paginate($query, $page, $pageSize);
    }

    public function editOne(Trades $trade, Request $request)
    {
        return $trade;
    }
}