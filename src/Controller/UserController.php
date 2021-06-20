<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

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
     *     }
     * )
     * @OA\Post  (
     *     description="Create new user for current connected client",
     *     tags={"User", "Create", "POST"}
     * )
     * @OA\Response(
     *     response=201,
     *     description="User successfully created",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/User"),
     *             example={
     *                 "created_at": "2021-06-19",
     *                 "address": {
     *                     "number": 1,
     *                     "adverb": null,
     *                     "street": "Rue des users",
     *                     "postal": "44000",
     *                     "city": "Nantes",
     *                     "country": "France"
     *                 },
     *                 "first_name": "User 1",
     *                 "last_name": "of Client 1",
     *                 "mail_address": "user1.1@gmail.com",
     *                 "phone": "0601010101",
     *                 "_links": {
     *                     "delete": {
     *                         "href": "http://127.0.0.1:8000/api/users/1"
     *                     },
     *                     "create": {
     *                         "href": "http://127.0.0.1:8000/api/users"
     *                     }
     *                 }
     *             }
     *         )
     *     }
     * )
     * @OA\RequestBody(
     *     required=false,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/User_Create")
     *     )
     * )
     * @OA\Response(
     *     response=401,
     *     description="Unauthorized : JWT token is expired / not found. Token isn't passed in header, or is exired",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="Error response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Error response message"
     *                 ),
     *                 example={
     *                     "code": 401,
     *                     "message": "JWT Token not found",
     *                 }
     *             )
     *         )
     *     }
     * )
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
     *     path = "/api/users/{id}",
     *     name = "app_user_show_details",
     *     requirements = {
     *         "id"="\d+"
     *     },
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"user_show_detail"},
     *
     * )
     *
     * @OA\Get  (
     *     description="Get informations about user that correspond to passed id, if user belong to connected client",
     *     tags={"User", "Show", "GET"},
     *     @OA\Parameter (
     *         in="path",
     *         name="id",
     *         @OA\Schema (type="integer"),
     *         required=true,
     *         description="User id which to get details about",
     *         example=1
     *     ),
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Get user details",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/User"),
     *             example={
     *                 "created_at": "2021-06-19",
     *                 "address": {
     *                     "number": 1,
     *                     "adverb": null,
     *                     "street": "Rue des users",
     *                     "postal": "44000",
     *                     "city": "Nantes",
     *                     "country": "France"
     *                 },
     *                 "first_name": "User 1",
     *                 "last_name": "of Client 1",
     *                 "mail_address": "user1.1@gmail.com",
     *                 "phone": "0601010101",
     *                 "_links": {
     *                     "delete": {
     *                         "href": "http://127.0.0.1:8000/api/users/1"
     *                     },
     *                     "create": {
     *                         "href": "http://127.0.0.1:8000/api/users"
     *                     }
     *                 }
     *             }
     *         )
     *     }
     * )
     *
     * @OA\Response(
     *     response=401,
     *     description="Unauthorized : JWT token is expired / not found. Token isn't passed in header, or is exired",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="Error response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Error response message"
     *                 ),
     *                 example={
     *                     "code": 401,
     *                     "message": "JWT Token not found",
     *                 }
     *             )
     *         )
     *     }
     * )
     *
     * @OA\Response(
     *     response=403,
     *     description="Forbidden access to ressource. Connected user isn't allowed to acces to this ressource.",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="Error response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Error response message"
     *                 ),
     *                 example={
     *                     "code": 403,
     *                     "message": "Forbidden",
     *                 }
     *             )
     *         )
     *     }
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="User not found. No user correspond to passed id is stored in database",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="Error response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Error response message"
     *                 ),
     *                 example={
     *                     "code": 404,
     *                     "message": "Not found",
     *                 }
     *             )
     *         )
     *     }
     * )
     *
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
     *
     * @OA\Get (
     *     description="Get paginated list of all users stored for connected user",
     *     tags={"User", "List", "GET"}
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns paginated users list",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/User_List"),
     *         example={
     *             "page": 1,
     *             "limit": 10,
     *             "pages": 1,
     *             "total": 8,
     *             "_links": {
     *                 "self": {
     *                     "href": "http://127.0.0.1:8000/api/users?page=1&limit=10"
     *                 },
     *                 "first": {
     *                     "href": "http://127.0.0.1:8000/api/users?page=1&limit=10"
     *                 },
     *                 "last": {
     *                     "href": "http://127.0.0.1:8000/api/users?page=1&limit=10"
     *                 }
     *             },
     *             "_embedded": {
     *                 "items": {
     *                     {
     *                         "id": 1,
     *                         "created_at": "2021-06-19",
     *                         "first_name": "User 1",
     *                         "last_name": "of Client 1",
     *                         "mail_address": "user1.1@gmail.com",
     *                         "_links": {
     *                             "self": {
     *                                 "href": "http://127.0.0.1:8000/api/users/1"
     *                             },
     *                             "delete": {
     *                                 "href": "http://127.0.0.1:8000/api/users/1"
     *                             },
     *                             "create": {
     *                                 "href": "http://127.0.0.1:8000/api/users"
     *                             }
     *                         }
     *                     },
     *                     {
     *                         "id": 2,
     *                         "created_at": "2021-06-19",
     *                         "first_name": "User 2",
     *                         "last_name": "of Client 1",
     *                         "mail_address": "user2.1@gmail.com",
     *                         "_links": {
     *                             "self": {
     *                                 "href": "http://127.0.0.1:8000/api/users/2"
     *                             },
     *                             "delete": {
     *                                 "href": "http://127.0.0.1:8000/api/users/2"
     *                             },
     *                             "create": {
     *                                 "href": "http://127.0.0.1:8000/api/users"
     *                             }
     *                         }
     *                      }
     *                  }
     *              }
     *          }
     *      )
     * )
     *
     * @OA\Response(
     *     response=401,
     *     description="Unauthorized : JWT token is expired / not found. Token isn't passed in header, or is exired",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="Error response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Error response message"
     *                 ),
     *                 example={
     *                     "code": 401,
     *                     "message": "JWT Token not found",
     *                 }
     *             )
     *         )
     *     }
     *  )
     *
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
        $list = $this->getUser()->getUsers();
//        $list = $this->getUser()->getUsers()->getValues();
        // List size
        $total = count($list);
        // Actual offset
        $offset = ($page - 1) * $limit;
        // Number of pages
        $pages = (int)ceil($total / $limit);
        return new PaginatedRepresentation(
            new CollectionRepresentation($list->slice($offset, $page * $limit)),
            'app_client_show_users', // route
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
     *     path = "/api/users/{id}",
     *     name = "app_client_del_user",
     *     requirements = {
     *         "id"="\d+"
     *     },
     * )
     *
     * @OA\Delete  (
     *     description="Delete user passed by id if belongs to connected client",
     *     tags={"User", "Delete", "DELETE"},
     *     @OA\Parameter (
     *         in="path",
     *         name="id",
     *         @OA\Schema (type="integer"),
     *         required=true,
     *         description="User id which to delete",
     *         example=1
     *     ),
     * )
     * @OA\Response(
     *     response=200,
     *     description="User successfully deleted from client's users list.",
     *     content={
     *         @OA\MediaType(
     *             mediaType="text/plain",
     *             @OA\Schema(
     *                 type="string",
     *                 example="OK"
     *             )
     *         )
     *     }
     * )
     * @OA\Response(
     *     response=401,
     *     description="Unauthorized : JWT token is expired / not found. Token isn't passed in header, or is exired",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="Error response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Error response message"
     *                 ),
     *                 example={
     *                     "code": 401,
     *                     "message": "JWT Token not found",
     *                 }
     *             )
     *         )
     *     }
     * )
     *
     * @OA\Response(
     *     response=403,
     *     description="Forbidden access to ressource. Connected user isn't allowed to acces to this ressource.",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="Error response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Error response message"
     *                 ),
     *                 example={
     *                     "code": 403,
     *                     "message": "Forbidden",
     *                 }
     *             )
     *         )
     *     }
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="User not found. No user correspond to passed id is stored in database",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="Error response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Error response message"
     *                 ),
     *                 example={
     *                     "code": 404,
     *                     "message": "Not found",
     *                 }
     *             )
     *         )
     *     }
     * )
     * @IsGranted("USER_DELETE", subject="user")
     */
    public function delete(User $user, EntityManagerInterface $manager): View
    {
        $manager->remove($user);
        $manager->flush();
        return $this->view("OK", Response::HTTP_OK);
    }
}
