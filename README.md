# Notifier project
[![Github Workflow Status](https://github.com/mihaitmf/notifier/workflows/PHP%20Composer%20Tests/badge.svg)](https://github.com/mihaitmf/notifier/actions?query=workflow%3A%22PHP+Composer+Tests%22)
[![Travis Build Status](https://travis-ci.org/mihaitmf/notifier.svg?branch=main)](https://travis-ci.org/mihaitmf/notifier)

Notifications sender. Send push notifications to phone via IFTTT webhook.

## Requirements
- [![Minimum PHP Version](https://img.shields.io/badge/php-%3E=7.4-8892BF.svg)](https://php.net/) <img src="https://www.php.net/images/logos/new-php-logo.svg" width="35">
- [![Composer](https://img.shields.io/badge/-composer-A16F22)](https://getcomposer.org) <img src="https://getcomposer.org/img/logo-composer-transparent.png" width="25">

## Push Notifications 
The application allows to send push notifications to phone using the
[IFTTT service](https://ifttt.com/).

You must have an [IFTTT](https://ifttt.com/) account and an applet with
a webhook created.

### Installation
1. Run `composer update`
2. Create the `config.ini` file as a copy of the template `config.ini.dist`
file, in the root of the project, with this structure:
```
[push_notification]
webhook_url = "https://maker.ifttt.com/trigger/<your_applet_name>/with/key/<your_webhook_key>"
```
Update `<your_applet_name>` and `<your_webhook_key>` with the relevant data
found your IFTTT account, [Webhook service documentation](https://ifttt.com/maker_webhooks).

### Usage as a CLI script
You can send a push notification to your IFTTT mobile app with a `message`
and a `link` (URL).

Example command:
* `php <script-name>.php notify:push "<message>" "<link (optional)>"`
* Linux: `php bin/run.php notify:push "hello my friend" "http://google.com"`
* Windows: `php bin\run.php notify:push "hello my friend" "http://google.com"`

### Imported as a library
If you want to use this project as a library, you can use directly the
`PushNotificationService` class.

You will need to create instances for its dependencies, which are:
* `ClientInterface`, from GuzzleHttp library
* `Config`, created with the `ConfigIniParser` that requires the path to
the `config ini` file

#### Usage example
```
$pushNotificationService = new Notifier\PushNotification\PushNotificationService(
    new GuzzleHttp\Client(),
    CommonUtils\Config\ConfigIniParser::fromFile(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini')
);
$pushNotificationService->notify('Hello my friend!', 'http://google.com');
```

If you are using a DI library, you can include these instantiations into
the DI definitions file.

Example for [php-di](https://php-di.org/doc/php-definitions.html) definitions
config file:
```
return [
    GuzzleHttp\ClientInterface::class => DI\autowire(GuzzleHttp\Client::class),
    CommonUtils\Config\Config::class => DI\factory(
        function () {
            return CommonUtils\Config\ConfigIniParser::fromFile(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini');
        }
    ),
];
``` 
### Enjoy!
