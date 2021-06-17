<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
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
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview")
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Page of the overview")
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"users_show_client_list", "Default"},
     * )
     * @IsGranted("USERS_LIST")
     */
    public function showList(ParamFetcherInterface $paramFetcher): object
    {
        // Values used for paginated collection

        // Actual page
        $page = $paramFetcher->get("page");
        // Elements by page
        $limit = $paramFetcher->get("limit");
        // Elements list
        $list = $this->getUser()->getUsers()->getValues();
        // List size
        $total = count($list);
        // Actual offset
        $offset = ($page - 1) * $limit;
//        dd($list->slice($offset, $page * $limit));
        // Number of pages
        $pages = (int)ceil($total / $limit);
        return new PaginatedRepresentation(
            new CollectionRepresentation(array_slice($list, $offset, $page * $limit)),
            'app_products_show_list', // route
            array(), // route parameters
            $page,
            $limit,
            $pages,
            'page', // Name of queryParam
            'limit', // Name of queryParam
            true,   // Absolute URLs
            $total
        );
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
