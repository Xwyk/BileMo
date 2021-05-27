<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use JMS\Serializer\SerializerBuilder;

class ProductFixtures extends Fixture
{
    private $jsonFile;
    public function __construct(string $json_file)
    {
        $this->jsonFile = $json_file;
    }

    public function load(ObjectManager $manager)
    {
        $serializer = SerializerBuilder::create()->build();
        $array = $serializer->deserialize(file_get_contents($this->jsonFile),'array<App\Entity\Product>', 'json');
        foreach ($array as $product){
            $manager->persist($product);
        }

        $manager->flush();
    }
}
