<?php

namespace App\Tests\Controller;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\ClientRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    public function testShowDetails(): void
    {

        $client = self::createClient();
        $firstClient = $this->getFirstClient();
        $firstClientSiren = $firstClient->getSiren();
        $firstUserId = $firstClient->getUsers()[0]->getId();
        $client->request(
            'GET',
            "/clients/".$firstClientSiren."/users/".$firstUserId
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testShowList(): void
    {
        $client = self::createClient();
        $firstClient = $this->getFirstClient();
        $firstClientSiren = $firstClient->getSiren();
        $client->request(
            'GET',
            "/clients/".$firstClientSiren."/users"
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreate(): void
    {
        $data = array
        (
            "address"  => [
                "number" => 4,
                "street" => "Rue des Vignerons",
                "postal" => "44860",
                "city"   => "Pont-Saint-Martin",
                "country"=> "France"
            ],
            "first_name"  => "Florian",
            "last_name" => "LEBOUL",
            "mail_address"  => "phpunit@test.com",
            "phone"  => "0605410616",
        );
        $client = self::createClient();
        $firstClient = $this->getFirstClient();
        $firstClientSiren = $firstClient->getSiren();
        $client->request(
            'POST',
            "/clients/".$firstClientSiren."/users",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            "{
                        'address': {
                          'number': 4,
                          'street': 'Rue des vignerons',
                          'postal': 44860,
                          'city': 'Pont-Saint-Martin',
                          'country': 'France'
                        },
                        'first_name': 'Florian',
                        'last_name': 'LEBOUL',
                        'mail_address': 'phpunit@test.com',
                        'phone': '0605410616'
                      }"
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertEquals('Florian', $this->getCreatedUser()->getFirstName());
    }

    public function testDelete(): void
    {

    }

    private function getFirstClient(): Client
    {
        return (static::$container->get(ClientRepository::class)->createQueryBuilder('c')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult())[0];
    }

    private function getCreatedUser(): User
    {
        return (static::$container->get(ClientRepository::class)->createQueryBuilder('c')
            ->andWhere('c.mail_address = :val')
            ->setParameter('val', 'phpunit@test.com')
            ->getQuery()
            ->getOneOrNullResult());
    }
}
