<?php


namespace App\Controller\Api;

use App\Response\CMDJsonResponse;
use App\Security\User\JwtUser;
use App\Service\Client\ClientService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 * @package App\Controller\Api
 * @Route(path="/clients")
 */
class ClientController extends BaseApiController
{
    /**
     * @Route(path="/userInfo",methods={"GET"})
     * @param Request $request
     * @param ClientService $clientService
     * @return CMDJsonResponse
     */
    public function getUserInfoAction(Request $request, ClientService $clientService)
    {
        $client = $this->user->getEntity();
        return $this->returnJson($this->normalize($client));
    }

    /**
     * @Route(path="/userInfo",methods={"POST"})
     * @param Request $request
     * @param ClientService $clientService
     * @return CMDJsonResponse
     */
    public function updateUserInfoAction(Request $request, ClientService $clientService)
    {
        $client = $clientService->updateUserInfo($this->user->getEntity(),$request->query);
        return $this->returnJson($this->normalize($client));
    }
}