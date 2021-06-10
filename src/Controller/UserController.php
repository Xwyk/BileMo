<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Post(
     *     path = "/api/users",
     *     name = "app_client_add_user"
     * )
     * @Rest\View(
     *     statusCode=201,
     *     serializerGroups={"user_show_detail"},
     * )
     * @ParamConverter(
     *     "user",
     *     converter = "fos_rest.request_body",
     *     options = {
     *         "validator" = {
     *             "groups" = "create"
     *         }
     *     })
     * @IsGranted("USER_ADD")
     */
    public function create(User $user, ConstraintViolationList $violations, EntityManagerInterface $manager)
    {
        if(count($violations))  {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }
        $this->getUser()->addUser($user);
        $manager->persist($user);
        $manager->flush();

        return $user;
    }
    /**
     * @Rest\Get(
     *     path = "/api/users/{userId}",
     *     name = "app_user_show_details",
     *     requirements = {
     *         "userId"="\d+"
     *     },
     * )
     * @ParamConverter("user", options={"mapping": {"userId" : "id"}})
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"user_show_detail"},
     * )
     * @IsGranted("USER_SHOW", subject="user")
     */
    public function showDetails(User $user): User
    {
        return $user;
    }

    /**
     * @Rest\Get(
     *     path = "/api/users",
     *     name = "app_client_show_users"
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"users_show_client_list"},
     * )
     *
     * @IsGranted("USERS_LIST")
     */
    public function showList(): object
    {
        return $this->getUser()->getUsers();
    }

    /**
     * @Rest\Delete(
     *     path = "/api/users/{userId}",
     *     name = "app_client_del_user",
     *     requirements = {
     *         "userId"="\d+"
     *     },
     * )
     * @ParamConverter(
     *     "user",
     *     options = {
     *         "mapping": {
     *             "userId" : "id"
     *         }
     *     })
     * @IsGranted("USER_DELETE", subject="user")
     */
    public function delete(User $user, EntityManagerInterface $manager): View
    {
        $manager->remove($user);
        $manager->flush();
        return $this->view("OK", Response::HTTP_OK);
    }
}
