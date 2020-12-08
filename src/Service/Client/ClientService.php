<?php


namespace App\Service\Client;


use App\Entity\Clients;
use App\Entity\ProductTags;
use App\Repository\ClientsRepository;
use App\Utils\ImageHelper;
use App\Utils\UploadHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ClientService
{
    private EntityManagerInterface $entityManager;

    private ClientsRepository $clientRepo;

    private UploadHelper $uploadHelper;

    protected ImageHelper $imageHelper;

    public function __construct(EntityManagerInterface $entityManager,ImageHelper $imageHelper,UploadHelper $uploadHelper)
    {
        $this->entityManager = $entityManager;
        $this->imageHelper = $imageHelper;
        $this->uploadHelper = $uploadHelper;
        $this->clientRepo = $entityManager->getRepository(Clients::class);
    }

    public function registerByMobile(string $mobile)
    {
        /** @var Clients $client */
        $client = $this->clientRepo->findOneByMobile($mobile);

        if (empty($client)) {
            $client = new Clients();
            $client->setMobile($mobile);
            $client->setUsername($mobile);
            $client->setGender('man');
            $client->setAvatar($this->imageHelper->getFull('/images/man.png'));
            $client->setOpenId('');
            $this->entityManager->persist($client);
            $this->entityManager->flush();
        }

        return $client;
    }

    public function updateUserInfo(Clients $clients,ParameterBag $parameterBag)
    {
        if ($avatar = $parameterBag->get('avatar')) {
            $clients->setAvatar($avatar);
        }
        if ($username = $parameterBag->get('username')) {
            $clients->setUsername($username);
        }
        if ($gender = $parameterBag->get('gender')) {
            $clients->setGender($gender);
        }
        $this->entityManager->persist($clients);
        $this->entityManager->flush();
        return $clients;
    }


    public function getList(ParameterBag $parameterBag, PaginatorInterface $paginator)
    {
        $page = $parameterBag->get('page',1);
        $pageSize = $parameterBag->get('pageSize',20);
        $query = $this->clientRepo->findAll();
        return $paginator->paginate($query, $page, $pageSize);
    }

    public function deleteOne(Clients $client)
    {
        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }

    public function editOne(Clients $client, Request $request)
    {
        $fileBag = $request->files;
        if ($fileBag->get('avatar_0')) {
            $avatar = $this->uploadHelper->save($fileBag->get('avatar_0'));
        }else{
            $avatar = $request->get('avatar_text_0');
        }
        $client->setAvatar($avatar);
        $client->setMobile($request->get('mobile'));
        $client->setGender($request->get('gender'));
        $client->setOpenId($request->get('openId'));
        $client->setUsername($request->get('username'));
        $client->setLastLoginAt(new \DateTime($request->get('last_login_at')));
        $this->entityManager->persist($client);
        $this->entityManager->flush();
        return $client;
    }
}