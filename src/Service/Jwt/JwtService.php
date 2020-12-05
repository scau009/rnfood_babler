<?php


namespace App\Service\Jwt;


use Firebase\JWT\JWT;

class JwtService
{
    private string $jwtKey = 'api_key';

    public function encode(string $userIdentify)
    {
        $payload = [
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "id" => $userIdentify,
        ];

        return JWT::encode($payload, $this->jwtKey);
    }

    public function decode(string $jwt)
    {
        $jwt = str_replace('Bearer ', '', $jwt);
        return JWT::decode($jwt, $this->jwtKey,array('HS256'));
    }
}