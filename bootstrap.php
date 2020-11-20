<?php

use CommonUtils\DI\Container;

require_once __DIR__ . '/vendor/autoload.php';

Container::setDefinitionsFilePath(__DIR__ . DIRECTORY_SEPARATOR . 'di-config.php');
