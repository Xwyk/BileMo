<?php

namespace App\Tests;

use App\Entity\Figure;
use App\Entity\User;
use App\Repository\FigureRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class Test extends WebTestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @dataProvider provideUserUrls
     * @param string $url
     * @param string $method
     * @param int $expectedStatusCode
     * @param bool $authenticatedUser
     */
    public function testPagesAreSuccessful(string $url, string $method, int $expectedStatusCode)
    {

        $client = self::createClient();

        $client->request($method, $url);

        $this->assertResponseStatusCodeSame($expectedStatusCode);
    }

    public function provideUserUrls()
    {
        //$exampleFigure = $this->getFirstFigure();
        return [
            'products_list' => ['/products','GET', 200],
        ];
    }
}