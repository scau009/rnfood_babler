<?php


namespace App\Service\Client;


use App\Entity\Clients;
use App\Entity\ProductTags;
use App\Repository\ClientsRepository;
use App\Service\WeChat\WeChatMiniProgramService;
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

    /**
     * @var WeChatMiniProgramService
     */
    private WeChatMiniProgramService $weChatMiniProgramService;

    public function __construct(EntityManagerInterface $entityManager,ImageHelper $imageHelper,
                                UploadHelper $uploadHelper,WeChatMiniProgramService $weChatMiniProgramService)
    {
        $this->entityManager = $entityManager;
        $this->imageHelper = $imageHelper;
        $this->uploadHelper = $uploadHelper;
        $this->clientRepo = $entityManager->getRepository(Clients::class);
        $this->weChatMiniProgramService = $weChatMiniProgramService;
    }

    public function registerOrLoginByMobile(string $mobile)
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

    public function registerOrLoginByWx(Request $request)
    {
        $userInfo = $request->get('userInfo');
        $iv = $request->get('iv');
        $encryptedData = $request->get('encryptedData');
        $signature = $request->get('signature');
        $code = $request->get('code');
        list($session_key,$openid) = $this->weChatMiniProgramService->login($code);
        //根据openId 找用户表
        $client = $this->clientRepo->findOneByOpenId($openid);
        if (!$client) {
            $client = new Clients();
            $client->setOpenId($openid);
            $client->setUsername($userInfo['nickName']);
            $client->setGender($userInfo['gender'] == 1 ? 'man' : 'woman');
            $client->setAvatar($userInfo['avatarUrl']);
            $client->setMobile('');
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