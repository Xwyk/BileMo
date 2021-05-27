<?php

namespace App\DataFixtures;

use App\Repository\ClientRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use JMS\Serializer\SerializerBuilder;

class UserFixtures extends Fixture
{
    private $jsonFile;
    public function __construct(string $json_file)
    {
        $this->jsonFile = $json_file;
    }

    public function load(ObjectManager $manager)
    {
        $serializer = SerializerBuilder::create()->build();
        $array = $serializer->deserialize(file_get_contents($this->jsonFile),'array<App\Entity\User>', 'json');
        foreach ($array as $user){
            $manager->persist($user);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            ClientRepository::class,
        ];
    }
}
