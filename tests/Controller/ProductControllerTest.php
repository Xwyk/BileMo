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
        "commercial_name" => "P20 Lite",
        "model"           => "Ane-LX1",
        "rom"             => 64,
        "ram"             => 4,
        "battery"         => 3000,
        "launched_at"     => "2021-05-27",
        "price"           => 199
    ];
    public function loadEntryPoints(): array
    {
        return [
            "testShowDetailsTokenOkIdOk" => [
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
                    "additionalCheck" => "checkShowDetailsTokenOkIdOk"
                ]
            ],
            "testShowDetailsTokenOkIdKo" => [
                [
                    "type" => "GET",
                    "url" => "/api/products/1000",
                    "parameters" => [],
                    "files" => [],
                    "server" => [],
                    "authenticated" => true,
                    "content" => "",
                    "expectedCode" => Response::HTTP_NOT_FOUND,
                    "needReturnOnOK" => false,
                ]
            ],
            "testShowDetailsTokenKoIdOk" => [
                [
                    "type" => "GET",
                    "url" => "/api/products/" . $this->firstProductId,
                    "parameters" => [],
                    "files" => [],
                    "server" => ["HTTP_AUTHORIZATION" => $this->expiredToken],
                    "authenticated" => false,
                    "content" => "",
                    "expectedCode" => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testShowDetailsTokenKoIdKo" => [
                [
                    "type" => "GET",
                    "url" => "/api/products/1000",
                    "parameters" => [],
                    "files" => [],
                    "server" => ["HTTP_AUTHORIZATION" => $this->expiredToken],
                    "authenticated" => false,
                    "content" => "",
                    "expectedCode" => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testShowDetailsNoTokenIdOk" => [
                [
                    "type" => "GET",
                    "url" => "/api/products/" . $this->firstProductId,
                    "parameters" => [],
                    "files" => [],
                    "server" => [],
                    "authenticated" => false,
                    "content" => "",
                    "expectedCode" => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testShowDetailsNoTokenIdKo" => [
                [
                    "type" => "GET",
                    "url" => "/api/products/" . $this->firstProductId,
                    "parameters" => [],
                    "files" => [],
                    "server" => [],
                    "authenticated" => false,
                    "content" => "",
                    "expectedCode" => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testShowListTokenKo" => [
                [
                    "type" => "GET",
                    "url" => "/api/products",
                    "parameters" => [],
                    "files" => [],
                    "server" => ["HTTP_AUTHORIZATION" => $this->expiredToken],
                    "authenticated" => false,
                    "content" => "",
                    "expectedCode" => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false
                ]
            ],
            "testShowListNoToken" => [
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
            "testShowListTokenOk" => [
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
                    "additionalCheck" => "checkShowListTokenOk"
                ]
            ]
        ];
    }

    /**
     * Checks first user in list correspond to firs user data defined in class and check _links on each user displayed
     * @param $result
     */
    protected function checkShowListTokenOk($result){

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
    protected function checkShowDetailsTokenOkIdOk($result){
        $this->checkAttributes(
            (json_decode(json_encode($result), true)),
            (json_decode(json_encode($this->firstProduct), true))
        );
    }
}
