<?php

namespace App\Controller\Admin;

use App\Entity\Stores;
use App\Service\Store\StoreService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StoresCrudController
 * @package App\Controller\Admin
 * @Route(path="/store")
 */
class StoresCrudController extends AbstractController
{
    /**
     * @Route(path="/index",name="store_list")
     * @Template(template="store/index.html.twig")
     * @param Request $request
     * @param StoreService $storeService
     * @param PaginatorInterface $paginator
     */
    public function index(Request $request, StoreService $storeService, PaginatorInterface $paginator)
    {
        $pagination = $storeService->getList($request->query, $paginator);
        return compact('pagination');
    }

    /**
     * @Route(path="/new",name="new_store",methods={"GET","POST"})
     * @param Request $request
     * @param StoreService $storeService
     * @Template(template="store/new.html.twig")
     */
    public function new(Request $request,StoreService $storeService)
    {
        if ($request->isMethod("GET")) {

        }else{
            $product = $storeService->createStore($request);
            return $this->redirectToRoute('store_list');
        }
    }

    /**
     * @Route(path="/show/{id}",name="show_store",methods={"GET"})
     * @param Stores $store
     * @Template(template="store/show.html.twig")
     */
    public function show(Stores $store)
    {
        return compact('store');
    }

    /**
     * @Route(path="/edit/{id}",name="edit_store",methods={"GET","POST"})
     * @param Stores $store
     * @param Request $request
     * @param StoreService $storeService
     * @Template(template="store/edit.html.twig")
     */
    public function edit(Stores $store,Request $request,StoreService $storeService)
    {
        if ($request->isMethod("GET")) {
            return compact('store');
        }else{
            $storeService->editOne($store, $request);
            $this->addFlash("success","修改成功！");
            return $this->redirectToRoute('show_store',['id'=>$store->getId()]);
        }
    }

    /**
     * @Route(path="/delete/{id}",name="delete_store",methods={"POST"})
     * @param Stores $store
     * @param StoreService $storeService
     */
    public function delete(Stores $store,StoreService $storeService)
    {
        $storeService->deleteOne($store);
        $this->addFlash("success","删除成功！");
        return $this->redirectToRoute('store_list');
    }
}
