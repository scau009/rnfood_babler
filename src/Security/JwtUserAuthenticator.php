<?php


namespace App\Security;

use App\Response\CMDJsonResponse;
use App\Service\Jwt\JwtService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JwtUserAuthenticator extends AbstractGuardAuthenticator
{
    private array $whiteList = [
        'app_api_auth_loginbymobile',
        'app_api_auth_loginbywx',
        'app_api_stores_getstorelist',
        'app_api_product_getproductlist',
        'app_api_company_getcompanylist',
        'app_api_product_getproduct',
        'notify',
    ];
    private JwtService $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function supports(Request $request)
    {
        return !in_array($request->attributes->get('_route'), $this->whiteList);
    }

    public function getCredentials(Request $request)
    {
        $route = $request->attributes->get('_route');
        $jwt = $request->headers->get('authorization');

        return [
            'jwt' => $jwt ? $this->jwtService->decode($jwt) : '',
            'route' => $route,
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $jwt = $credentials['jwt'];
        if (empty($jwt)||!isset($jwt->id)) {
            return null;
        }else{
            $clientId = $jwt->id;
            return $userProvider->loadUserByUsername($clientId);
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new CMDJsonResponse([], Response::HTTP_UNAUTHORIZED,'认证失败');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return null;
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new CMDJsonResponse([], Response::HTTP_UNAUTHORIZED,'认证失败');
    }
}