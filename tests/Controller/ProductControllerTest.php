<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Tests\BilemoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends BilemoWebTestCase
{
    public function testEntryPoints(): void
    {
        // Get token for this test
        $GLOBALS['token'] = $this->entryPoint([
            "name"           => "login",
            "type"           => "POST",
            "url"            => "/api/login_check",
            "parameters"     => [],
            "files"          => [],
            "server"         => [],
            "authenticated"  => false,
            "content"        => json_encode([
                "username" => "user1",
                "password" => "user1"
            ]),
            "expectedCode"   => Response::HTTP_OK,
            "needReturnOnOK" => true
        ])->token;

        $productId = 1;
        $tests = [
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
        foreach ($tests as $test) {
            $this->entryPoint($test);
        }
    }
}
