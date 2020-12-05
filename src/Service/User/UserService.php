<?php


namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class UserService
{
    private EntityManagerInterface $entityManager;

    private UserRepository $userRepo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepo = $entityManager->getRepository(User::class);
    }

    public function getList(ParameterBag $parameterBag, PaginatorInterface $paginator)
    {
        $page = $parameterBag->get('page',1);
        $pageSize = $parameterBag->get('pageSize',20);
        $query = $this->userRepo->findAll();
        return $paginator->paginate($query, $page, $pageSize);
    }

    public function createUser(Request $request)
    {
        $user = new User();
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $user->setRoles($request->get('roles'));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    public function deleteOne(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function editOne(User $user, Request $request)
    {
        $user->setRoles($request->get('roles'));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }
}