<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Rest\Get(
     *     path = "/products/{id}",
     *     name = "app_products_show_details",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
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
     * @Rest\View
     */
    public function showList(): array
    {
        return $this->getDoctrine()->getRepository('App\Entity\Product')->findAll();
    }
}
