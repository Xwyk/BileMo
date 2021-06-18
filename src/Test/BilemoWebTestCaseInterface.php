<?php


namespace App\Test;

use Symfony\Component\HttpFoundation\Response;

interface BilemoWebTestCaseInterface
{
    public function loadEntryPoints():void;
    public function testEntryPoints();
    public function entryPoint(string $name, string $type, string $url, int $expectedCode, array $parameters = [], array $files = [], array $server = [], string $content = "", bool $needReturnOnOK = false);
}