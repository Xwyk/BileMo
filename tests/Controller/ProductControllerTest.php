<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCase
{
    public function testShowDetails(){
        $client = self::createClient();
        $client->request('GET', "/products/".$this->getFirstProduct()->getId());
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testShowList(){
        $client = self::createClient();
        $client->request('GET', "/products");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    private function getFirstProduct(): Product
    {
        return (static::$container->get(ProductRepository::class)->createQueryBuilder('c')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult())[0];
    }
}
