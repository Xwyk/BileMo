<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Product;
use App\Repository\ClientRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
//    /**
//     * @Rest\Get(
//     *     path = "/clients/{id}",
//     *     name = "app_clients_show_details",
//     *     requirements = {"id"="\d+"}
//     * )
//     * @Rest\View
//     */
//    public function showDetails(Client $client): Client
//    {
//        return $client;
//    }
//    /**
//     * @Rest\Get(
//     *     path = "/clients",
//     *     name = "app_clients_show_list",
//     * )
//     * @Rest\View
//     */
//    public function showList(ClientRepository $repo): array
//    {
//        return $repo->findAll();
//    }
}
