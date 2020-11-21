<?php

use CommonUtils\Config\Config;
use CommonUtils\Config\ConfigIniParser;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use function DI\autowire;
use function DI\factory;

return [
    ClientInterface::class => autowire(Client::class),
    Config::class => factory(
        function () {
            return ConfigIniParser::fromFile(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini');
        }
    ),
    OutputInterface::class => autowire(ConsoleOutput::class),
];
