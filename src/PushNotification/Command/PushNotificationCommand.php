<?php

namespace Notifier\PushNotification\Command;

use Notifier\PushNotification\PushNotificationService;

class PushNotificationCommand
{
    private PushNotificationService $pushNotificationService;

    public function __construct(PushNotificationService $pushNotificationService)
    {
        $this->pushNotificationService = $pushNotificationService;
    }

    public function run(array $argv): void
    {
        if (count($argv) < 2) {
            $this->printMessage(
                'Insufficient arguments for the script. Example command: php <script-name>.php "<message>" "<link (optional)>"'
            );
            return;
        }

        $message = $argv[1];
        $linkUrl = $argv[2] ?? '';

        $response = $this->pushNotificationService->notify($message, $linkUrl);

        if ($response->isSuccessful()) {
            $this->printMessage('SUCCESS! Push notification sent!');
        } else {
            $this->printMessage(sprintf('ERROR! %s', $response->getError()));
        }
    }

    private function printMessage(string $message): void
    {
        print("\n$message");
    }
}
