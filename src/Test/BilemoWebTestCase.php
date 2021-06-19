<?php


namespace App\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class BilemoWebTestCase extends WebTestCase implements BilemoWebTestCaseInterface
{
    protected $token;
    protected $tests;

    public function entryPoint(string $type, string $url, int $expectedCode, array $parameters = [], array $files = [], array $server = [], string $content = "", bool $needReturnOnOK = false)
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

    /**
     * @dataProvider loadEntryPoints
     */
    public function testEntryPoints($test): void
    {
        if (!isset($this->token) && $test['authenticated']){
            $this->setToken();
        }
        $result = $this->entryPoint(
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

    public function setToken()
    {
        $this->token = $this->entryPoint(
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

    /**
     * Checks for each link in $expetedLinks if it exists in $object->_links.
     * @param object $object
     * @param array $expectedLinks
     */
    protected function checkLinks(object $object, array $expectedLinks)
    {
        foreach ($expectedLinks as $link){
            $this->assertTrue(isset($object->_links->$link), "Link ".$link." isn't present in object");
        }
    }

    /**
     * Recursively check that result contains all toCompare values
     * @param array $result
     * @param array $toCompare
     */
    protected function checkAttributes(array $result, array $toCompare){
        foreach ($toCompare as $attribute => $value){
            // If $value is an array, enter in the recursive world
            if (is_array($value)){
                $this->checkAttributes($result[$attribute], $value);
                // Once all array attributes are checked, continue with next parent's attribute
                continue;
            }
            $this->assertEquals($value, $result[$attribute], "Failed on attribute ".$attribute);
        }
    }
}