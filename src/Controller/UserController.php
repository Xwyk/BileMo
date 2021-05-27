<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/clients/{siren}/users/{userId}",
     *     name = "app_user_show_details",
     *     requirements = {
     *         "siren"="\d+",
     *         "userId"="\d+"
     *     },
     * )
     * @ParamConverter("client", options={"mapping": {"siren" : "siren"}})
     * @ParamConverter("user", options={"mapping": {"userId" : "id"}})
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"user_show_detail"},
     * )
     */
    public function showDetails(User $user, Client $client): User
    {
        if (!$client->getUsers()->contains($user)){
            return $this->view("Unknown user for this client", Response::HTTP_NOT_FOUND);
        }
        return $user;
    }
    /**
     * @Rest\Get(
     *     path = "/clients/{siren}/users",
     *     name = "app_client_show_users",
     *     requirements = {
     *         "siren"="\d+"
     *     },
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"users_show_client_list"},
     * )
     */
    public function showList(int $siren, ClientRepository $clientRepository): object
    {
        return $clientRepository->findOneBySiren($siren)->getUsers();
    }

    /**
     * @Rest\Post(
     *     path = "/clients/{siren}/users",
     *     name = "app_client_add_user",
     *     requirements = {
     *         "siren"="\d+",
     *     },
     * )
     * @Rest\View(
     *     statusCode=201,
     *     serializerGroups={"user_show_detail"},
     * )
     * @ParamConverter("client", options={"mapping": {"siren" : "siren"}})
     * @ParamConverter("user", class="App\Entity\User", converter="fos_rest.request_body")
     */
    public function create(User $user, Client $client, ConstraintViolationList $violations, EntityManagerInterface $manager)
    {
        if(count($violations))  {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }
        $client->addUser($user);
        $manager->persist($user);
        $manager->flush();

        return $user;
    }

    /**
     * @Rest\Delete(
     *     path = "/clients/{siren}/users/{userId}",
     *     name = "app_client_del_user",
     *     requirements = {
     *         "siren"="\d+",
     *         "userId"="\d+"
     *     },
     * )
     * @ParamConverter("client", options={"mapping": {"siren" : "siren"}})
     * @ParamConverter("user", options={"mapping": {"userId" : "id"}})
     */
    public function delete(User $user, Client $client, EntityManagerInterface $manager)
    {
        if (!$client->getUsers()->contains($user)){
            return $this->view("Unknown user for this client", Response::HTTP_NOT_FOUND);
        }
        $manager->remove($user);
        $manager->flush();
        return $this->view("", Response::HTTP_OK);
    }
}
