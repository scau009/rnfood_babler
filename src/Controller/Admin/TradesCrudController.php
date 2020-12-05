<?php

namespace App\Controller\Admin;

use App\Entity\Trades;
use App\Service\Trade\TradeService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TradesCrudController
 * @package App\Controller\Admin
 * @Route(path="/trade")
 */
class TradesCrudController extends AbstractController
{
    /**
     * @Route(path="/index",name="trade_list")
     * @Template(template="trade/index.html.twig")
     * @param Request $request
     * @param TradeService $clientService
     * @param PaginatorInterface $paginator
     */
    public function index(Request $request, TradeService $clientService, PaginatorInterface $paginator)
    {
        $pagination = $clientService->getList($request->query, $paginator);
        return compact('pagination');
    }

    /**
     * @Route(path="/show/{id}",name="show_trade",methods={"GET"})
     * @param Trades $trade
     * @Template(template="trade/show.html.twig")
     */
    public function show(Trades $trade)
    {
        return compact('trade');
    }

    /**
     * @Route(path="/edit/{id}",name="edit_trade",methods={"GET","POST"})
     * @param Trades $trade
     * @param Request $request
     * @param TradeService $clientService
     * @Template(template="trade/edit.html.twig")
     */
    public function edit(Trades $trade, Request $request, TradeService $clientService)
    {
        if ($request->isMethod("GET")) {
            return compact('client');
        }else{
            $clientService->editOne($trade, $request);
            $this->addFlash("success","修改成功！");
            return $this->redirectToRoute('show_client',['id'=>$trade->getId()]);
        }
    }
}
