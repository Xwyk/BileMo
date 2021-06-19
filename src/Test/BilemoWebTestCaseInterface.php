<?php


namespace App\Test;

interface BilemoWebTestCaseInterface
{
    public function loadEntryPoints():array;
    public function testEntryPoints(array $test);
    public function entryPoint(
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