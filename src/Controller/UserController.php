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
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Rest\Get(
     *     path = "/clients/{clientId}/users/{userId}",
     *     name = "app_user_show_details",
     *     requirements = {
     *         "clientId"="\d+",
     *         "userId"="\d+"
     *     },
     * )
     * @ParamConverter("user", options={"mapping": {"userId" : "id"}})
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"user_show_detail"},
     * )
     */
    public function showDetails(User $user): User
    {
        return $user;
    }
    /**
     * @Rest\Get(
     *     path = "/clients/{id}/users",
     *     name = "app_client_show_users",
     *     requirements = {
     *         "id"="\d+"
     *     },
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"users_show_client_list"},
     * )
     */
    public function showList(int $id, ClientRepository $clientRepository): object
    {
        return $clientRepository->findOneById($id)->getUsers();
    }
}
