<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\EventSubscriber;

use KejawenLab\Semart\Surat\Application;
use KejawenLab\Semart\Surat\Entity\EntityEvent;
use KejawenLab\Semart\Surat\Entity\Group;
use KejawenLab\Semart\Surat\Entity\Menu;
use KejawenLab\Semart\Surat\Security\Service\RoleService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class RoleInitiationSubscriber implements EventSubscriberInterface
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function initiate(EntityEvent $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof Group && !$entity->getId()) {
            $this->roleService->assignToGroup($entity);
        }

        if ($entity instanceof Menu && !$entity->getId()) {
            $this->roleService->assignToMenu($entity);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            Application::PRE_COMMIT_EVENT => [['initiate']],
        ];
    }
}
