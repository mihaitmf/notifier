<?php

use Notifier\Common\Command\ConsoleEventListener;
use Notifier\Common\Container;
use Notifier\PushNotification\Command\PushNotificationCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new Application('Notifier');

$eventDispatcher = new EventDispatcher();
$consoleEventListener = Container::get(ConsoleEventListener::class);

/** @uses ConsoleEventListener::onCommandBegin() */
/** @uses ConsoleEventListener::onCommandFinish() */
/** @uses ConsoleEventListener::onCommandError() */
$eventDispatcher->addListener(ConsoleEvents::COMMAND, [$consoleEventListener, 'onCommandBegin']);
$eventDispatcher->addListener(ConsoleEvents::TERMINATE, [$consoleEventListener, 'onCommandFinish']);
$eventDispatcher->addListener(ConsoleEvents::ERROR, [$consoleEventListener, 'onCommandError']);

$app->setDispatcher($eventDispatcher);

$app->add(Container::get(PushNotificationCommand::class));

$app->run();
