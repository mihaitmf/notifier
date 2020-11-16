<?php

namespace Notifier\PushNotification;

class PushNotificationResponse
{
    private bool $isSuccessful;
    private string $error;

    private function __construct()
    {
    }

    public static function success(): PushNotificationResponse
    {
        $response = new PushNotificationResponse();
        $response->isSuccessful = true;

        return $response;
    }

    public static function error(string $errorString): PushNotificationResponse
    {
        $response = new PushNotificationResponse();
        $response->isSuccessful = false;
        $response->error = $errorString;

        return $response;
    }

    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
