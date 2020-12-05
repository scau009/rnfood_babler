<?php


namespace App\Controller\Api;

use App\Service\Client\TradeService;
use App\Service\Jwt\JwtService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthController
 * @package App\Controller\Api
 * @Route(path="/api/auth")
 */
class AuthController extends BaseApiController
{
    /**
     * @Route(path="/login")
     * @param Request $request
     * @param TradeService $clientService
     * @param JwtService $jwtService
     */
    public function login(Request $request, TradeService $clientService, JwtService $jwtService)
    {
        $client = $clientService->registerByMobile($request->get('mobile'));
        $token = $jwtService->encode($client->getId());
        return $this->returnJson(['token' => $token]);
    }
}