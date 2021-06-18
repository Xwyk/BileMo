<?php


namespace App\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class BilemoWebTestCase extends WebTestCase implements BilemoWebTestCaseInterface
{
    protected $token;
    protected $tests;

    public function entryPoint(string $name, string $type, string $url, int $expectedCode, array $parameters = [], array $files = [], array $server = [], string $content = "", bool $needReturnOnOK = false)
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->request(
            $type,
            $url,
            $parameters,
            $files,
            $server,
            $content
        );
        $this->assertResponseStatusCodeSame($expectedCode);
        return (($needReturnOnOK) && ($client->getResponse()->getStatusCode() == $expectedCode)) ?
            json_decode($client->getResponse()->getContent()) :
            null;
    }

    public function testEntryPoints(): void
    {
        if (!isset($this->tests)) {
            $this->loadEntryPoints();
        }
        foreach ($this->tests as $test) {
            if (!isset($this->token) && $test['authenticated']){
                $this->setToken();
            }
            $result = $this->entryPoint(
                $test['name'],
                $test['type'],
                $test['url'],
                $test['expectedCode'],
                $test['parameters'],
                $test['files'],
                array_merge(
                    $test['server'],
                    [
                        'CONTENT_TYPE' => 'application/json',
                    ],
                    ($test['authenticated']) ? ["HTTP_AUTHORIZATION" => "Bearer " . $this->token] : []),
                $test['content'],
                $test['needReturnOnOK']
            );
            if ($test['needReturnOnOK'] && isset($test['additionalCheck'])) {
                $method = $test['additionalCheck'];
                $this->$method($result);
            }
        }
    }

    public function setToken()
    {
        $this->token = $this->entryPoint(
            "login",
            "POST",
            "/api/login_check",
            Response::HTTP_OK,
            [],
            [],
            [],
            json_encode([
                "username" => "user1",
                "password" => "user1"
            ]),
            true
        )->token;
    }
}