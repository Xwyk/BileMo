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
     *      description="Return informations about phone that correspond to passed id."
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Product id to get information about",
     *     @OA\Schema(type="int"),
     *     required=true
     *
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns products details",
     *     @OA\JsonContent(ref=@Model(type=Product::class, groups={"product_show_detail"}))
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="Product not found"
     * )
     * @OA\Response(
     *     response=401,
     *     description="Unauthorized : user isn't connected"
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
     *         @OA\Items(
     *             ref=@Model(
     *                 type=Product::class,
     *                 groups={"products_show_list", "Default"},
     *             )
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Product not found"
     * )
     * @OA\Response(
     *     response=401,
     *     description="Unauthorized : user isn't connected"
     * )
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
