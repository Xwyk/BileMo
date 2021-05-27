<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\ClientRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
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
            throw new BadRequestHttpException('Unknown user for this client');
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
}
