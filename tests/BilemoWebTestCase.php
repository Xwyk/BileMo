<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BilemoWebTestCase extends WebTestCase
{
    protected $token;
    protected function entryPoint(array $params)
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->request(
            $params['type'],
            $params['url'],
            $params['parameters'],
            $params['files'],
            array_merge(
                $params['server'],
                [
                    'CONTENT_TYPE' => 'application/json',
                    'ACTUAL_TEST'  => $params['name']
                ],
                ($params['authenticated'])?["HTTP_AUTHORIZATION" => "Bearer ".$this->token]:[]),
            $params['content']
        );
        $this->assertResponseStatusCodeSame($params['expectedCode']);
        return (($params['needReturnOnOK'])&&($client->getResponse()->getStatusCode()==$params['expectedCode']))?
            json_decode($client->getResponse()->getContent()):
            null;
    }
}