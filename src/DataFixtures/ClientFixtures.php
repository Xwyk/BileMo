<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\File\File;

class ClientFixtures extends Fixture implements FixtureGroupInterface
{
    private $jsonFile;
    public function __construct(string $json_file)
    {
        $this->jsonFile = $json_file;
    }

    public function load(ObjectManager $manager)
    {
        $serializer = SerializerBuilder::create()->build();
        $users = $serializer->deserialize((new File($this->jsonFile))->getContent(),'array<App\Entity\Client>', 'json');
        foreach ($users as $client){
            foreach ($client->getUsers() as $user){
                $user->setClient($client);
            }
            $manager->persist($client);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['all_fixtures', 'clients_fixtures'];
    }
}
