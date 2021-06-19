<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Test\BilemoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends BilemoWebTestCase
{
    public function loadEntryPoints(): array
    {
        $productId = 1;
        return [
            "testShowDetailsUnauthenticated" => [
                [
                    "type" => "GET",
                    "url" => "/api/products/" . $productId,
                    "parameters" => [],
                    "files" => [],
                    "server" => [],
                    "authenticated" => false,
                    "content" => "",
                    "expectedCode" => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false
                ]
            ],
            "testShowDetailsAuthenticated" => [
                [
                    "type" => "GET",
                    "url" => "/api/products/" . $productId,
                    "parameters" => [],
                    "files" => [],
                    "server" => [],
                    "authenticated" => true,
                    "content" => "",
                    "expectedCode" => Response::HTTP_OK,
                    "needReturnOnOK" => false
                ]
            ],
            "testShowListUnauthenticated" => [
                [
                    "type" => "GET",
                    "url" => "/api/products",
                    "parameters" => [],
                    "files" => [],
                    "server" => [],
                    "authenticated" => false,
                    "content" => "",
                    "expectedCode" => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false
                ]
            ],
            "testShowListAuthenticated" => [
                [
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
            ]
        ];
    }
}
