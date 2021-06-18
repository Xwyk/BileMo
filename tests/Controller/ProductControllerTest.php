<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Test\BilemoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends BilemoWebTestCase
{
    public function loadEntryPoints(): void
    {
        $productId = 1;
        $this->tests = [
            [
                "name" => "testShowDetailsUnauthenticated",
                "type" => "GET",
                "url" => "/api/products/" . $productId,
                "parameters" => [],
                "files" => [],
                "server" => [],
                "authenticated" => false,
                "content" => "",
                "expectedCode" => Response::HTTP_UNAUTHORIZED,
                "needReturnOnOK" => false
            ],
            [
                "name" => "testShowDetailsAuthenticated",
                "type" => "GET",
                "url" => "/api/products/" . $productId,
                "parameters" => [],
                "files" => [],
                "server" => [],
                "authenticated" => true,
                "content" => "",
                "expectedCode" => Response::HTTP_OK,
                "needReturnOnOK" => false
            ],
            [
                "name" => "testShowListUnauthenticated",
                "type" => "GET",
                "url" => "/api/products",
                "parameters" => [],
                "files" => [],
                "server" => [],
                "authenticated" => false,
                "content" => "",
                "expectedCode" => Response::HTTP_UNAUTHORIZED,
                "needReturnOnOK" => false
            ],
            [
                "name" => "testShowListAuthenticated",
                "type" => "GET",
                "url" => "/api/products",
                "parameters" => [],
                "files" => [],
                "server" => [],
                "authenticated" => true,
                "content" => "",
                "expectedCode" => Response::HTTP_OK,
                "needReturnOnOK" => false
            ]
        ];
    }
}
