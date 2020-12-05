<?php


namespace App\Security\User;


use App\Entity\Clients;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JwtUserProvider implements UserProviderInterface
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function loadUserByUsername(string $username)
    {
        /** @var Clients $client */
        $client = $this->em->getRepository(Clients::class)->find($username);
        if (empty($client)) {
            throw new NotFoundHttpException('找不到指定用户');
        }
        $jwtUser = new JwtUser();
        $jwtUser->setId($client->getId());
        $jwtUser->setOpenId($client->getOpenId());
        $jwtUser->setEntity($client);
        return $jwtUser;
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass(string $class)
    {
        return JwtUser::class === $class;
    }
}