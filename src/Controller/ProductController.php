<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;

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
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"products_show_list"},
     * )
     */
    public function showList(): array
    {
        return $this->getDoctrine()->getRepository(Product::class)->findAll();
    }

    /**
     * @Rest\Post(
     *     path = "/products",
     *     name = "app_products_add",
     * )
     * @Rest\View(
     *     statusCode=201,
     *     serializerGroups={"product_show_detail"},
     * )
     * @ParamConverter("product", class="App\Entity\Product", converter="fos_rest.request_body")
     */
    public function create(Product $product, ConstraintViolationList $violations, EntityManagerInterface $manager)
    {
        if(count($violations))  {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }
        dump($product); die;
        $manager->persist($product);
        $manager->flush();

        return $product;
    }
}
