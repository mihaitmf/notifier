<?php

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Notifier\Common\ConfigParser;

return [
    ClientInterface::class => static function () {
        return new Client(
            [
                'verify' => false, // turn off SSL verification
            ]
        );
    },
    ConfigParser::class => static function () {
        return ConfigParser::fromFile(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini');
    }
];
