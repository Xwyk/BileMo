<?php


namespace App;


use Symfony\Component\HttpKernel\HttpCache\HttpCache;

class CacheKernel extends HttpCache
{
    protected function getOptions(): array
    {
        return [
            'default_ttl' => 0
        ];
    }
}