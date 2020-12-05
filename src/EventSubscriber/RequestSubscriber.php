<?php

namespace App\EventSubscriber;

use App\Controller\Api\BaseApiController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class RequestSubscriber implements EventSubscriberInterface
{
    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        if (is_array($controller)) {
            $controller = $controller[0];
        }
        if ($controller instanceof BaseApiController) {
            $controller->initUser();
            $content = $event->getRequest()->getContent();
            $request = $event->getRequest();
            if ($content) {
                $content = json_decode($content, true);
                foreach ($content as $key => $value) {
                    $request->query->set($key, $value);
                }
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
