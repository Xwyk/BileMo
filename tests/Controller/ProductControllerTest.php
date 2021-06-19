<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Test\BilemoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends BilemoWebTestCase
{
    protected $firstProductId = 1;
    protected $firstProduct = [
        "brand"           => "Huawei",
        "commercial_name" => "b",
        "model"           => "b",
        "rom"             => 12,
        "ram"             => 12,
        "battery"         => 12,
        "launched_at"     => "2021-05-27",
        "price"          => 200
    ];
    public function loadEntryPoints(): array
    {
        return [
            "testShowDetailsUnauthenticated" => [
                [
                    "type" => "GET",
                    "url" => "/api/products/" . $this->firstProductId,
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
                    "url" => "/api/products/" . $this->firstProductId,
                    "parameters" => [],
                    "files" => [],
                    "server" => [],
                    "authenticated" => true,
                    "content" => "",
                    "expectedCode" => Response::HTTP_OK,
                    "needReturnOnOK" => true,
                    "additionalCheck" => "checkShowDetailsAuthenticated"
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
                    "needReturnOnOK" => true,
                    "additionalCheck" => "checkShowListAuthenticated"
                ]
            ]
        ];
    }

    /**
     * Checks first user in list correspond to firs user data defined in class and check _links on each user displayed
     * @param $result
     */
    protected function checkShowListAuthenticated($result){

        $productsList = $result->_embedded->items;

        $this->checkAttributes(
            (json_decode(json_encode($productsList[0]), true)),
            (json_decode(json_encode($this->firstProduct), true))
        );

        foreach ($productsList as $resultProduct){
            $this->checkLinks($resultProduct, ['self']);
        }

        $this->checkLinks($result, ['first', 'last', 'self']);
    }

    /**
     * Checks if returned user (id defined in class) correspond to data (defined in class) and check _links content
     * @param $result
     */
    protected function checkShowDetailsAuthenticated($result){
        $this->checkAttributes(
            (json_decode(json_encode($result), true)),
            (json_decode(json_encode($this->firstProduct), true))
        );
    }
}
