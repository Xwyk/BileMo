<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\HateoasBuilder;
use Hateoas\Representation\OffsetRepresentation;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(
     *     path = "/api/products/{id}",
     *     name = "app_products_show_details",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"product_show_detail"},
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
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview")
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Page of the overview")
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"products_show_list", "Default"},
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
