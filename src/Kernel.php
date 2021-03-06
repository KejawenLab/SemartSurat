<?php

namespace KejawenLab\Semart\Surat;

use KejawenLab\Semart\Collection\Collection;
use KejawenLab\Semart\Surat\Generator\GeneratorFactory;
use KejawenLab\Semart\Surat\Letter\LetterService;
use KejawenLab\Semart\Surat\Letter\NumberFormat\NumberFormatFactory;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel implements CompilerPassInterface
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function getCacheDir()
    {
        return $this->getProjectDir().'/var/cache/'.$this->environment;
    }

    public function getLogDir()
    {
        return $this->getProjectDir().'/var/log';
    }

    public function registerBundles()
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->addResource(new FileResource($this->getProjectDir().'/config/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir().'/config';

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $confDir = $this->getProjectDir().'/config';

        $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');
    }

    public function process(ContainerBuilder $container)
    {
        $generators = Collection::collect($container->findTaggedServiceIds(sprintf('%s.generator', Application::APP_UNIQUE_NAME)))
            ->keys()
            ->map(function ($serviceId) {
                return new Reference($serviceId);
            })
            ->toArray()
        ;
        $definition = $container->getDefinition(GeneratorFactory::class);
        $definition->addArgument($generators);

        $numberFormatters = Collection::collect($container->findTaggedServiceIds(sprintf('%s.number_format', Application::APP_UNIQUE_NAME)))
            ->keys()
            ->map(function ($serviceId) {
                return new Reference($serviceId);
            })
            ->toArray()
        ;
        $definition = $container->getDefinition(NumberFormatFactory::class);
        $definition->addArgument($numberFormatters);

        $services = Collection::collect($container->findTaggedServiceIds(sprintf('%s.service', Application::APP_UNIQUE_NAME)))
            ->keys()
            ->map(function ($serviceId) {
                return new Reference($serviceId);
            })
            ->toArray()
        ;
        $definition = $container->getDefinition(Application::class);
        $definition->addMethodCall('setServices', [$services]);
    }
}
