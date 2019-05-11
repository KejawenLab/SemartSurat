<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Security\Service;

use KejawenLab\Semart\Surat\Contract\Service\ServiceInterface;
use KejawenLab\Semart\Surat\Entity\Group;
use KejawenLab\Semart\Surat\Entity\User;
use KejawenLab\Semart\Surat\Repository\GroupRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class GroupService implements ServiceInterface
{
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $groupRepository->setCacheable(true);
        $this->groupRepository = $groupRepository;
    }

    public function getSuperAdmin(): Group
    {
        return $this->groupRepository->findOneBy(['code' => Group::SUPER_ADMINISTRATOR_CODE]);
    }

    public function isSuperAdmin(User $user): bool
    {
        $group = $user->getGroup();

        if (!$group) {
            return false;
        }

        return Group::SUPER_ADMINISTRATOR_CODE === $group->getCode();
    }

    /**
     * @return Group[]
     */
    public function getActiveGroups(): array
    {
        return $this->groupRepository->findAll();
    }

    /**
     * @param string $id
     *
     * @return Group|null
     */
    public function get(string $id): ?object
    {
        return $this->groupRepository->find($id);
    }
}
