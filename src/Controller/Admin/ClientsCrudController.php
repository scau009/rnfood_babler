<?php

namespace App\Controller\Admin;

use App\Entity\Clients;
use App\Service\Client\ClientService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientsCrudController
 * @package App\Controller\Admin
 * @Route(path="/client")
 */
class ClientsCrudController extends AbstractController
{
    /**
     * @Route(path="/index",name="client_list")
     * @Template(template="client/index.html.twig")
     * @param Request $request
     * @param ClientService $clientService
     * @param PaginatorInterface $paginator
     */
    public function index(Request $request, ClientService $clientService, PaginatorInterface $paginator)
    {
        $pagination = $clientService->getList($request->query, $paginator);
        return compact('pagination');
    }


    /**
     * @Route(path="/show/{id}",name="show_client",methods={"GET"})
     * @param Clients $client
     * @Template(template="client/show.html.twig")
     */
    public function show(Clients $client)
    {
        return compact('client');
    }

    /**
     * @Route(path="/edit/{id}",name="edit_client",methods={"GET","POST"})
     * @param Clients $client
     * @param Request $request
     * @param ClientService $clientService
     * @Template(template="client/edit.html.twig")
     */
    public function edit(Clients $client, Request $request, ClientService $clientService)
    {
        if ($request->isMethod("GET")) {
            return compact('client');
        }else{
            $clientService->editOne($client, $request);
            $this->addFlash("success","修改成功！");
            return $this->redirectToRoute('show_client',['id'=>$client->getId()]);
        }
    }

    /**
     * @Route(path="/delete/{id}",name="delete_client",methods={"POST"})
     * @param Clients $client
     * @param ClientService $clientService
     */
    public function delete(Clients $client, ClientService $clientService)
    {
        $clientService->deleteOne($client);
        $this->addFlash("success","删除成功！");
        return $this->redirectToRoute('client_list');
    }
}
