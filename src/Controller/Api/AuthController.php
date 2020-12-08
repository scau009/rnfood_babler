<?php


namespace App\Controller\Api;

use App\Service\Client\ClientService;
use App\Service\Jwt\JwtService;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthController
 * @package App\Controller\Api
 * @Route(path="/auth")
 */
class AuthController extends BaseApiController
{
    /**
     * @Route(path="/login")
     * @param Request $request
     * @param ClientService $clientService
     * @param JwtService $jwtService
     */
    public function login(Request $request, ClientService $clientService, JwtService $jwtService)
    {
        if (!$request->get('mobile')) {
            throw new BadRequestHttpException("参数错误，mobile is required");
        }
        $client = $clientService->registerByMobile($request->get('mobile'));
        $token = $jwtService->encode($client->getId());
        return View::create(compact('token'));
    }
}