<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Service\User\UserService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserCrudController
 * @package App\Controller\Admin
 * @Route(path="/user")
 */
class UserCrudController extends AbstractController
{
    /**
     * @Route(path="/index",name="user_list")
     * @Template(template="user/index.html.twig")
     * @param Request $request
     * @param UserService $userService
     * @param PaginatorInterface $paginator
     */
    public function index(Request $request, UserService $userService, PaginatorInterface $paginator)
    {
        $pagination = $userService->getList($request->query, $paginator);
        return compact('pagination');
    }

    /**
     * @Route(path="/new",name="new_user",methods={"GET","POST"})
     * @param Request $request
     * @param UserService $userService
     * @Template(template="user/new.html.twig")
     */
    public function new(Request $request,UserService $userService)
    {
        if ($request->isMethod("GET")) {

        }else{
            $user = $userService->createUser($request);
            return $this->redirectToRoute('user_list');
        }
    }

    /**
     * @Route(path="/show/{id}",name="show_user",methods={"GET"})
     * @param User $user
     * @Template(template="user/show.html.twig")
     */
    public function show(User $user)
    {
        return compact('user');
    }

    /**
     * @Route(path="/edit/{id}",name="edit_user",methods={"GET","POST"})
     * @param User $user
     * @param Request $request
     * @param UserService $userService
     * @Template(template="user/edit.html.twig")
     */
    public function edit(User $user,Request $request,UserService $userService)
    {
        if ($request->isMethod("GET")) {
            return compact('user');
        }else{
            $userService->editOne($user, $request);
            $this->addFlash("success","修改成功！");
            return $this->redirectToRoute('show_user',['id'=>$user->getId()]);
        }
    }

    /**
     * @Route(path="/delete/{id}",name="delete_user",methods={"POST"})
     * @param User $user
     * @param UserService $userService
     */
    public function delete(User $user,UserService $userService)
    {
        $userService->deleteOne($user);
        $this->addFlash("success","删除成功！");
        return $this->redirectToRoute('user_list');
    }
}
