<?php

declare(strict_types=1);

namespace App\Services;


use App\Repository\HashesRepository;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StoreHashService
{

    private const RETRY_AFTER_DEFAULT = 60;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly HashesRepository $hashesRepository
    ) {
    }

    public function store(string $word, int $times): void
    {
        $hashes = $this->requestHash($word, $times);

        $this->hashesRepository->storeBatch($hashes);
    }

    private function requestHash(string $word, int $times): array
    {
        $hashes = [];

        $batch = new \DateTime('now');

        for ($i = 1; $i <= $times; $i++) {
            try {
                $url = "http://webserver/generate-hash/{$word}";
                $response = $this->client->request('GET', $url);

                $content = $response->toArray();
                $hashes[] = [
                    ...[
                        'batch' => $batch,
                        'word' => $word,
                        'block_number' => $i
                    ],
                    ...$content
                ];
                $word = $content['hash'];

            } catch (ClientException $e) {
                if ($e->getCode() != 429) {
                    throw $e;
                }

                $headers = $e->getResponse()->getHeaders(false);

                $retryAfter = $headers['x-ratelimit-retry-after'][0] ?? self::RETRY_AFTER_DEFAULT;

                sleep((int) $retryAfter);
                $i--;
                continue;
            }
        }

        return $hashes;
    }
}