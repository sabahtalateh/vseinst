<?php

namespace App\Service\Order;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Log\LoggerInterface;

class ConfirmationClient
{
    const BASE_URI = 'https://ya.ru';

    private $client;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->client = new Client(['base_uri' => self::BASE_URI]);
        $this->logger = $logger;
    }

    public function confirm(): bool
    {
        try {
            $this->logger->info('Request '.self::BASE_URI.'/');
            $this->client->get('/');
            $this->logger->info('Request '.self::BASE_URI.'/ SUCCESS');

            return true;
        } catch (ClientException $exception) {
            $this->logger->warning('Request '.self::BASE_URI."/ FAILED with {$exception->getCode()} code");
            $this->logger->warning($exception);

            return false;
        }
    }
}
