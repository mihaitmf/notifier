<?php

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Notifier\Common\ConfigParser;
use function DI\autowire;
use function DI\factory;

return [
    ClientInterface::class => autowire(Client::class)->constructorParameter(
        'config',
        [
            'verify' => false, // turn off SSL verification
        ]
    ),
    ConfigParser::class => factory(
        function () {
            return ConfigParser::fromFile(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini');
        }
    ),
];
