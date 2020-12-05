<?php


namespace App\Service;


use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

interface EntityService
{
    public function getList(ParameterBag $parameterBag, PaginatorInterface $paginator);

    public function newOne();

    public function getOne();

    public function editOne();
}