<?php

namespace Notifier\Common;

use DI\Container as DIContainer;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;

class Container
{
    private const DI_CONFIG_PHP = 'di-config.php';

    private static ?DIContainer $container = null;

    private function __construct()
    {
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws DependencyException
     * @throws NotFoundException
     */
    public static function get(string $name)
    {
        return self::getContainer()->get($name);
    }

    /**
     * @param string $name
     * @param array $parameters Map<string, string> = <parameterName => className>
     *
     * @return object
     * @throws DependencyException
     * @throws NotFoundException
     */
    public static function make(string $name, array $parameters = []): object
    {
        return self::getContainer()->make($name, $parameters);
    }

    private static function getContainer(): DIContainer
    {
        if (self::$container === null) {
            self::$container = self::buildContainer();
        }

        return self::$container;
    }

    private static function buildContainer(): DIContainer
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAnnotations(true);
        $containerBuilder->addDefinitions(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . self::DI_CONFIG_PHP);

        return $containerBuilder->build();
    }
}
