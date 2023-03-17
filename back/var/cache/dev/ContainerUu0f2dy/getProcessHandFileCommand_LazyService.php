<?php

namespace ContainerUu0f2dy;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getProcessHandFileCommand_LazyService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.App\Command\ProcessHandFileCommand.lazy' shared service.
     *
     * @return \Symfony\Component\Console\Command\LazyCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/LazyCommand.php';

        return $container->privates['.App\\Command\\ProcessHandFileCommand.lazy'] = new \Symfony\Component\Console\Command\LazyCommand('process-hands', [], 'process all hands of a txt file', false, #[\Closure(name: 'App\\Command\\ProcessHandFileCommand')] function () use ($container): \App\Command\ProcessHandFileCommand {
            return ($container->privates['App\\Command\\ProcessHandFileCommand'] ?? $container->load('getProcessHandFileCommandService'));
        });
    }
}
