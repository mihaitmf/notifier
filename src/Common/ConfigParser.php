<?php

namespace Notifier\Common;

use RuntimeException;

class ConfigParser
{
    private array $configArray;

    private function __construct()
    {
    }

    public static function fromFile(string $configFilePath): ConfigParser
    {
        if (!is_file($configFilePath)) {
            throw new RuntimeException(sprintf('Invalid config file path! Not a file: %s', $configFilePath));
        }
        $parsedConfig = parse_ini_file($configFilePath, true);
        if ($parsedConfig === false) {
            throw new RuntimeException(sprintf('Could not parse config ini file from path: %s', $configFilePath));
        }

        $config = new ConfigParser();
        $config->configArray = $parsedConfig;

        return $config;
    }

    private static function fromArray(array $configArray): ConfigParser
    {
        $config = new ConfigParser();
        $config->configArray = $configArray;

        return $config;
    }

    /**
     * @param string $name
     *
     * @return ConfigParser|string
     */
    public function __get(string $name)
    {
        $value = $this->configArray[$name];
        if (is_array($value)) {
            return self::fromArray($value);
        }

        return (string)$value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->configArray[$name]);
    }

    public function __set(string $name, string $value): void
    {
        throw new RuntimeException('Not allowed to set a config ini value dynamically');
    }
}
