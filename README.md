# Notifier project
Notifications sender. Send push notifications to phone via IFTTT webhook.

[![Build Status](https://travis-ci.com/mihaitmf/notifier.svg?branch=master)](https://travis-ci.com/mihaitmf/notifier)

## Requirements
- [![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-blue)](https://php.net/)
- composer

## Send push notifications to phone via IFTTT webhook.

You must have an IFTTT (https://ifttt.com/) account and an applet with a webhook created.

### Stand-alone CLI script
First, you need to define a `config.ini` file in place of the `config.ini.dist` file,
in the root of the project, with this structure:

```
[push_notification]
webhook_url = "https://maker.ifttt.com/trigger/<your_applet_name>/with/key/<your_webhook_key>"
```
Update <your_applet_name> and <your_webhook_key> with the relevant data from your 
IFTTT account.

You can send a push notification to your IFTTT mobile app with a `message` and a `link` (URL).

Example command:
* `php <script-name>.php notify:push "<message>" "<link (optional)>"`
* Linux: `php bin/run.php notify:push "hello my friend" "http://google.com"`
* Windows: `php bin\run.php notify:push "hello my friend" "http://google.com"`

### Imported as a library
If you want to use this project as a library, you can use directly the `PushNotificationService` class.

In order to instantiate it, you need concrete objects for its dependencies:
* `ClientInterface` from Guzzle
* `ConfigParser` internal class that requires the path to the config ini file

Example of usage:
```
$pushNotificationService = new PushNotificationService(
    new GuzzleHttp\Client(),
    ConfigParser::fromFile(__DIR__ . DIRECTORY_SEPARATOR . 'config.ini')
);
$pushNotificationService->notify('Hello my friend!', 'http://google.com');
```
If you are using a DI library, you can include these instantiations into the DI definitions file. 
