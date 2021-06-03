<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(
     *     path = "/products/{id}",
     *     name = "app_products_show_details",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"product_show_detail"},
     * )
     */
    public function showDetails(Product $product): Product
    {
        return $product;
    }


    /**
     * @Rest\Get(
     *     path = "/products",
     *     name = "app_products_show_list",
     * )
     *
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"products_show_list"},
     * )
     *
     */
    public function showList(): array
    {
        return $this->getDoctrine()->getRepository(Product::class)->findAll();
    }
}
