<?php

use Notifier\Common\Container;
use Notifier\PushNotification\Command\PushNotificationCommand;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

Container::get(PushNotificationCommand::class)->run($argv);
