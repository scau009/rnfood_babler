<?php


namespace App\Controller\Api;

use App\Response\CMDJsonResponse;
use App\Security\User\JwtUser;
use App\Service\Client\TradeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 * @package App\Controller\Api
 * @Route(path="/api/clients")
 */
class ClientController extends BaseApiController
{
    /**
     * @Route(path="/userInfo",methods={"GET"})
     * @param Request $request
     * @param TradeService $clientService
     * @return CMDJsonResponse
     */
    public function getUserInfoAction(Request $request, TradeService $clientService)
    {
        $client = $this->user->getEntity();
        return $this->returnJson($this->normalize($client));
    }

    /**
     * @Route(path="/userInfo",methods={"POST"})
     * @param Request $request
     * @param TradeService $clientService
     * @return CMDJsonResponse
     */
    public function updateUserInfoAction(Request $request, TradeService $clientService)
    {
        $client = $clientService->updateUserInfo($this->user->getEntity(),$request->query);
        return $this->returnJson($this->normalize($client));
    }
}