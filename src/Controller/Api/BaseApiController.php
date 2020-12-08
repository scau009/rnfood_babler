<?php


namespace App\Controller\Api;

use App\Response\CMDJsonResponse;
use App\Security\User\JwtUser;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class BaseApiController extends AbstractFOSRestController
{
    protected SerializerInterface $serializer;

    protected ?JwtUser $user;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    protected function normalize($data,string $group = 'api')
    {
        return $this->serializer->normalize($data,'json',['groups'=>$group]);
    }

    protected function normalizeList(int $page,int $pageSize,PaginationInterface $paginator)
    {
        return [
            'paginator' => [
                'page' => $page,
                'pageSize' => $pageSize,
                'total' => $total = $paginator->getTotalItemCount(),
                'hasNext' => $total > $pageSize * $pageSize,
            ],
            'list' => array_map(function ($item){
                return $this->normalize($item);
            },iterator_to_array($paginator))
        ];
    }

    public function initUser()
    {
        $this->user = $this->getUser();
    }

    protected function returnJson($data = [],int $httpStatusCode = Response::HTTP_OK,string $message = '',array $headers = [])
    {
        return new CMDJsonResponse($data,$httpStatusCode,$message,$headers);
    }
}