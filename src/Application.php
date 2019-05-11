<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat;

use KejawenLab\Semart\Collection\Collection;
use KejawenLab\Semart\Surat\Contract\Service\ServiceInterface;
use PHLAK\Twine\Str;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class Application
{
    public const APP_UNIQUE_NAME = 'semart';
    public const REQUEST_EVENT = 'app.request';
    public const PRE_VALIDATION_EVENT = 'app.pre_validation';
    public const PAGINATION_EVENT = 'app.pagination';
    public const PRE_COMMIT_EVENT = 'app.pre_commit';

    /** @var ServiceInterface[] */
    private $services;

    public function setServices(array $services)
    {
        Collection::collect($services)->each(function ($value) {
            $this->addService($value);
        });
    }

    public function getService(\ReflectionClass $class, string $field = 'id')
    {
        $key = $this->getServiceKey($field, $class);
        if (!\array_key_exists($key, $this->services)) {
            return null;
        }

        return $this->services[$key];
    }

    private function addService(ServiceInterface $service)
    {
        $class = explode('\\', \get_class($service));
        $key = Str::make((string) array_pop($class))->lowercase()->replace('service', '')->__toString();
        $this->services[$key] = $service;
    }

    private function getServiceKey(string $field, \ReflectionClass $class)
    {
        $key = Str::make($field)->lowercase()->__toString();
        if ('parent' === $key || 'id' === $key) {
            $class = explode('\\', $class->getName());

            return Str::make((string) array_pop($class))->lowercase()->replace('service', '')->__toString();
        }

        return $key;
    }
}
