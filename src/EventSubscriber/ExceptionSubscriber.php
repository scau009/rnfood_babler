<?php

namespace App\EventSubscriber;

use App\Response\CMDJsonResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');
        if (strpos($route,'app_api') === 0) {
            $throwable = $event->getThrowable();
            if (!$throwable instanceof \Exception) {
                $response = new CMDJsonResponse($throwable->getTrace(),500,$throwable->getMessage());
            }else{
                $response = new CMDJsonResponse($throwable->getTrace(),$throwable->getCode(),$throwable->getMessage());
            }
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
