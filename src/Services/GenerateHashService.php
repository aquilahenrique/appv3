<?php

declare(strict_types=1);

namespace App\Services;

class GenerateHashService
{
    public function generate(string $word): array
    {
        $tries = 0;

        do {
            $key = $this->generateKey();

            $hash = md5($word . $key);

            $prefix = substr($hash, 0, 4);

            $tries++;
        } while($prefix !== '0000');

        return [
            'hash' => $hash,
            'key' => $key,
            'tries' => $tries,
        ];
    }
    private function generateKey(int $len = 8): string
    {
        $strings = '0123456789abcdefghijklmnopqrstuvxwyzABCDEFGHIJKLMNOPQRSTUVXYZW';
        $key = '';

        for ($i = 1; $i <= $len; $i++) {
            $randomInt = rand(0, strlen($strings) - 1);
            $randomChar = $strings[$randomInt];
            $key .= $randomChar;
        }

        return $key;
    }
}