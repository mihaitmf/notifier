<?php

namespace Notifier\PushNotification;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use JsonException;
use Notifier\Common\ConfigParser;
use RuntimeException;

class PushNotificationService
{
    private ClientInterface $httpClient;
    private ConfigParser $config;

    public function __construct(ClientInterface $httpClient, ConfigParser $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    public function notify(string $message, string $linkUrl = ''): PushNotificationResponse
    {
        $request = $this->buildRequest($message, $linkUrl);

        try {
            $response = $this->httpClient->send($request);
        } catch (GuzzleException $exception) {
            return PushNotificationResponse::error(
                sprintf(
                    'An error occurred while sending the push notification: %s',
                    $exception->getMessage()
                )
            );
        }

        $responseBody = (string)$response->getBody();
        if (strpos($responseBody, 'Congratulations') === false) {
            return PushNotificationResponse::error(
                sprintf(
                    'Unsuccessful response for sending the push notification: %s',
                    $responseBody
                )
            );
        }

        return PushNotificationResponse::success();
    }

    private function buildRequest(string $message, string $linkUrl): Request
    {
        $headers = [
            'Content-Type' => 'application/json',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36',
        ];

        $requestData = [
            'value1' => $message,
        ];
        if ($linkUrl !== '') {
            $requestData['value2'] = $linkUrl;
        }

        try {
            $body = json_encode($requestData, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException(
                sprintf('Error encoding the request body to json: %s', $exception->getMessage())
            );
        }

        return new Request('POST', $this->getWebhookUrl(), $headers, $body);
    }

    private function getWebhookUrl(): string
    {
        $webhookUrl = (string)$this->config->push_notification->webhook_url;

        if (filter_var($webhookUrl, FILTER_VALIDATE_URL) === false) {
            throw new RuntimeException(
                sprintf('The webhook URL provided in the config ini file is not valid: %s', $webhookUrl)
            );
        }

        return $webhookUrl;
    }
}
