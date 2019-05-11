<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\EventSubscriber;

use KejawenLab\Semart\Surat\Application;
use KejawenLab\Semart\Surat\Entity\User;
use KejawenLab\Semart\Surat\Request\RequestEvent;
use KejawenLab\Semart\Surat\Security\Service\PasswordEncoderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class UserSubscriber implements EventSubscriberInterface
{
    private $passwordEncoder;

    public function __construct(PasswordEncoderService $encodePasswordService)
    {
        $this->passwordEncoder = $encodePasswordService;
    }

    public function setPassword(RequestEvent $event)
    {
        $user = $event->getObject();
        if (!$user instanceof User) {
            return;
        }

        $this->passwordEncoder->encode($user);
    }

    public static function getSubscribedEvents()
    {
        return [
            Application::PRE_VALIDATION_EVENT => [['setPassword']],
        ];
    }
}
