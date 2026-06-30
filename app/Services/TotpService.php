<?php

namespace App\Services;

use InvalidArgumentException;

class TotpService
{
    public function generate(string $secret, ?int $timestamp = null): string
    {
        $timestamp ??= time();
        $key = $this->base32Decode($secret);
        $counter = intdiv($timestamp, 30);
        $binaryCounter = pack('N*', 0, $counter);
        $hash = hash_hmac('sha1', $binaryCounter, $key, true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $truncated = unpack('N', substr($hash, $offset, 4))[1] & 0x7FFFFFFF;

        return str_pad((string) ($truncated % 1000000), 6, '0', STR_PAD_LEFT);
    }

    public function secondsRemaining(?int $timestamp = null): int
    {
        $timestamp ??= time();

        return 30 - ($timestamp % 30);
    }

    private function base32Decode(string $secret): string
    {
        $secret = strtoupper(preg_replace('/[^A-Z2-7]/i', '', $secret));

        if ($secret === '') {
            throw new InvalidArgumentException('2FA secret khong hop le.');
        }

        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $bits = '';

        foreach (str_split($secret) as $character) {
            $value = strpos($alphabet, $character);

            if ($value === false) {
                throw new InvalidArgumentException('2FA secret khong hop le.');
            }

            $bits .= str_pad(decbin($value), 5, '0', STR_PAD_LEFT);
        }

        $decoded = '';

        foreach (str_split($bits, 8) as $byte) {
            if (strlen($byte) === 8) {
                $decoded .= chr(bindec($byte));
            }
        }

        return $decoded;
    }
}
