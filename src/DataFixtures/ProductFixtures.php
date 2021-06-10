<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\File\File;

class ProductFixtures extends Fixture implements FixtureGroupInterface
{
    private $jsonFile;
    public function __construct(string $json_file)
    {
        $this->jsonFile = $json_file;
    }

    public function load(ObjectManager $manager)
    {
        $serializer = SerializerBuilder::create()->build();
        $products = $serializer->deserialize((new File($this->jsonFile))->getContent(),'array<App\Entity\Product>', 'json');
        foreach ($products as $product){
            $manager->persist($product);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['all_fixtures', 'products_fixtures'];
    }
}
