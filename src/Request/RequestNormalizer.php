<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Request;

use KejawenLab\Semart\Collection\Collection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class RequestNormalizer implements EventSubscriberInterface
{
    public function normalize(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        Collection::collect($request->request->all())
            ->each(function ($value, $key) use ($request) {
                if ('false' === $value) {
                    $request->request->set($key, false);
                }

                if ('true' === $value) {
                    $request->request->set($key, true);
                }
            })
        ;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['normalize', 255]],
        ];
    }
}
