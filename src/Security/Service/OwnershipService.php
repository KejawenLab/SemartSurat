<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Security\Service;

use KejawenLab\Semart\Collection\Collection;
use KejawenLab\Semart\Surat\Application;
use KejawenLab\Semart\Surat\Contract\Service\ServiceInterface;
use KejawenLab\Semart\Surat\Security\Authorization\OwnershipChecker;
use ReflectionParameter;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class OwnershipService
{
    private $ownershipChecker;

    private $application;

    public function __construct(OwnershipChecker $ownershipChecker, Application $application)
    {
        $this->ownershipChecker = $ownershipChecker;
        $this->application = $application;
    }

    public function isOwner(Request $request, \ReflectionMethod $reflectionMethod): bool
    {
        /** @var string|null $id */
        $id = null;
        /** @var ServiceInterface $service */
        $service = null;

        Collection::collect($reflectionMethod->getParameters())
            ->each(function ($value) use (&$id, &$service, $request) {
                /** @var ReflectionParameter $value */
                if (!$argumentType = $value->getType()) {
                    return false;
                }

                $argumentType = $value->getType();
                $argumentName = $value->getName();
                if ('id' === $argumentName && 'string' === $argumentType->getName()) {
                    $id = $request->get($argumentName);
                }

                if ('service' === $argumentName) {
                    $reflectionClass = new \ReflectionClass($argumentType->getName());
                    if ($reflectionClass->implementsInterface(ServiceInterface::class)) {
                        $service = $this->application->getService($reflectionClass);
                    }
                }

                return true;
            })
        ;

        if ($id && $service) {
            return $this->ownershipChecker->isOwner($id, $service);
        }

        return true;
    }
}
