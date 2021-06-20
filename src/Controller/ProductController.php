<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use OpenApi\Annotations\Schema;
use Nelmio\ApiDocBundle\Annotation as Doc;



/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractFOSRestController
{

    /**
     * @Rest\Get (
     *     path = "/api/products/{id}",
     *     name = "app_products_show_details",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"product_show_detail"},
     * )
     * @OA\Get (
     *     description="Return informations about phone that correspond to passed id.",
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns products details",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/User"),
     *             example={
     *                 "brand": "Huawei",
     *                 "commercial_name": "P20 Lite",
     *                 "model": "Ane-LX1",
     *                 "rom": 64,
     *                 "ram": 4,
     *                 "battery": 3000,
     *                 "launched_at": "2021-05-27",
     *                 "created_at": "2021-06-19T08:37:42+00:00",
     *                 "price": 199
     *             }
     *         )
     *     }
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="Product not found"
     * )
     * @OA\Response(
     *     response=401,
     *     description="Forbidden : JWT token is expired / not found",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="The response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="The response message"
     *                 ),
     *                 example={
     *                     "code": 401,
     *                     "message": "JWT Token not found",
     *                 }
     *             )
     *         )
     *     }
     * )
     * @IsGranted("PRODUCT_SHOW")
     */
    public function showDetails(Product $product): Product
    {
        return $product;
    }


    /**
     * @Rest\Get(
     *     path = "/api/products",
     *     name = "app_products_show_list",
     * )
     * @QueryParam(name="page", requirements="\d+", default="1", description="Actual page of search")
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Maximum elements on search page")
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"products_show_list", "Default"},
     * )
     * @OA\Get (
     *      description="Return paginated list of all phones stored in database"
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns paginated products list",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Product_List"),
     *         example={
     *             "page": 1,
     *             "limit": 10,
     *             "pages": 1,
     *             "total": 3,
     *             "_links": {
     *                 "self": {
     *                     "href": "http://127.0.0.1:8000/api/products?page=1&limit=10"
     *                 },
     *                 "first": {
     *                     "href": "http://127.0.0.1:8000/api/products?page=1&limit=10"
     *                 },
     *                 "last": {
     *                     "href": "http://127.0.0.1:8000/api/products?page=1&limit=10"
     *                 }
     *             },
     *             "_embedded": {
     *                 "items": {
     *                     {
     *                         "id": 1,
     *                         "brand": "Huawei",
     *                         "commercial_name": "b",
     *                         "model": "b",
     *                         "rom": 12,
     *                         "ram": 12,
     *                         "battery": 12,
     *                         "launched_at": "2021-05-27",
     *                         "price": 200,
     *                         "_links": {
     *                             "self": {
     *                                 "href": "http://127.0.0.1:8000/api/products/1"
     *                             }
     *                         }
     *                     },
     *                     {
     *                         "id": 2,
     *                         "brand": "Huawei",
     *                         "commercial_name": "c",
     *                         "model": "c",
     *                         "rom": 12,
     *                         "ram": 12,
     *                         "battery": 12,
     *                         "launched_at": "2021-05-27",
     *                         "price": 200,
     *                         "_links": {
     *                             "self": {
     *                                 "href": "http://127.0.0.1:8000/api/products/2"
     *                             }
     *                         }
     *                     }
     *                 }
     *             }
     *         }
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Product not found"
     * )
     * @OA\Response(
     *     response=401,
     *     description="Forbidden : JWT token is expired / not found",
     *     content={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="integer",
     *                     description="The response code"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="The response message"
     *                 ),
     *                 example={
     *                     "code": 401,
     *                     "message": "JWT Token not found",
     *                 }
     *             )
     *         )
     *     }
     *  )
     * @IsGranted("PRODUCTS_LIST")
     */
    public function showList(ParamFetcherInterface $paramFetcher): PaginatedRepresentation
    {
        // Values used for paginated collection

        // Actual page
        $page = $paramFetcher->get("page");
        // Elements by page
        $limit = $paramFetcher->get("limit");
        // Elements list
        $list = $this->getDoctrine()->getRepository(Product::class)->paginatedFindAll($limit, $page);
        // List size
        $total = count($list);
        // Number of pages
        $pages = (int)ceil($total / $limit);


        return new PaginatedRepresentation(
            new CollectionRepresentation($list),
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
}
