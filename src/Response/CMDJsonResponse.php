<?php


namespace App\Response;


use Symfony\Component\HttpFoundation\JsonResponse;

class CMDJsonResponse extends JsonResponse
{
    public function __construct($data = null,int $code = 200,string $message = '', array $headers = [], bool $json = false)
    {
        $data = [
            'code' => $code,
            'data' => $data,
            'message' => $message,
        ];
        parent::__construct($data, 200, $headers, $json);
    }
}