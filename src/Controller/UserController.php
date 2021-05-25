<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Product;
use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Rest\Get(
     *     path = "/clients/{clientId}/users/{userId}",
     *     name = "app_user_show_details",
     *     requirements = {"clientId"="\d+"},
     *     requirements = {"userId"="\d+"},
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"details"},
     * )
     */
    public function showDetails(User $user): User
    {
        return $user;
    }
    /**
     * @Rest\Get(
     *     path = "/clients/{id}/users",
     *     name = "app_users_show_list",
     * )
     * @Rest\View
     */
    public function showList(): array
    {
        return $this->getDoctrine()->getRepository('App\Entity\User')->findAll();
    }
}
