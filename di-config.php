<?php

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Notifier\Common\Config\Config;
use Notifier\Common\Config\ConfigIniParser;
use function DI\autowire;
use function DI\factory;

return [
    ClientInterface::class => autowire(Client::class),
    Config::class => factory(
        function () {
            return ConfigIniParser::fromFile(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini');
        }
    ),
];
