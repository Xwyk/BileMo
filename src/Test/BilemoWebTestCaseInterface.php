<?php


namespace App\Test;

interface BilemoWebTestCaseInterface
{
    public function loadEntryPoints():void;
    public function testEntryPoints();
    public function entryPoint(
        string $name,
        string $type,
        string $url,
        int $expectedCode,
        array $parameters = [],
        array $files = [],
        array $server = [],
        string $content = "",
        bool $needReturnOnOK = false
    );
}