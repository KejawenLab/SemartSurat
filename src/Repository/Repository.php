<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use KejawenLab\Semart\Surat\Application;
use KejawenLab\Semart\Surat\Contract\Repository\CacheableRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Cache\Simple\ArrayCache;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
abstract class Repository extends ServiceEntityRepository implements CacheableRepositoryInterface
{
    private $cache;

    private $cacheable;

    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);

        $this->cache = new ArrayCache();
        $this->cacheable = false;
    }

    public function find($id, $lockMode = null, $lockVersion = null): ?object
    {
        if (!Uuid::isValid($id)) {
            return null;
        }

        if (!$this->isCacheable()) {
            return parent::find($id);
        }

        $entity = $this->getItem($id);
        if (!$entity) {
            $entity = parent::find($id);

            $this->cache($id, $entity);
        }

        return $entity;
    }

    public function findUniqueBy(array $criteria): array
    {
        $this->_em->getFilters()->disable(sprintf('%s_softdeletable', Application::APP_UNIQUE_NAME));

        return $this->findBy(array_merge($criteria));
    }

    public function isCacheable(): bool
    {
        return $this->cacheable;
    }

    public function setCacheable(bool $cacheable): void
    {
        $this->cacheable = $cacheable;
    }

    protected function cache(string $key, $item): void
    {
        if (!$this->cache->has($key)) {
            $this->cache->set($key, $item, 1);
        }
    }

    protected function getItem(string $key)
    {
        return $this->cache->get($key, null);
    }
}
