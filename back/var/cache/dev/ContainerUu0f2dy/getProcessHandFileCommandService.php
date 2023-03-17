<?php

namespace ContainerUu0f2dy;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getProcessHandFileCommandService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Command\ProcessHandFileCommand' shared autowired service.
     *
     * @return \App\Command\ProcessHandFileCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/src/Command/ProcessHandFileCommand.php';
        include_once \dirname(__DIR__, 4).'/src/Infrastructure/FileManager.php';

        $container->privates['App\\Command\\ProcessHandFileCommand'] = $instance = new \App\Command\ProcessHandFileCommand(new \App\Infrastructure\FileManager());

        $instance->setName('process-hands');
        $instance->setDescription('process all hands of a txt file');

        return $instance;
    }
}
