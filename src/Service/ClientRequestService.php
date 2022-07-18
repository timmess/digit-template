<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientRequestService
{
    private ResponseInterface $response;
    private HttpClientInterface $client;

    public function __construct(
        HttpClientInterface $client
    )
    {
        $this->client = $client;
    }

    /**
     * @param string $text
     * @param array $methods
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function request(string $text, array $methods)
    {
        $response = $this->client->request(
            'POST',
            'https://digit.lab-sense.io/api/media',
            [
                'body' => [
                    'text' => $text,
                    'method' => $methods,
                ],
            ]
        );

        $content = $response->getContent();
        $content = $response->toArray();

        return $content;
    }


    public function httpClientChunks($data)
    {
        foreach ($data as $chunk) {
            return yield $chunk->getContent();
        }
    }
}
