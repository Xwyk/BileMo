<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use App\Test\BilemoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends BilemoWebTestCase
{
    protected $testUser = array(
        "address"  => [
            "number"=> 4,
            "street"=> "Rue des vignerons",
            "postal"=> "44860",
            "city"=> "Pont-Saint-Martin",
            "country"=> "France"
        ],
        "first_name"=> "Florian",
        "last_name"=> "LEBOUL",
        "mail_address"=> "phpunit@test.com",
        "phone"=> "0605410616"
    );
    protected $badTestUser = array(
        "address"  => [
            "number"=> 4,
            "street"=> "Rue des vignerons",
            "postal"=> "44860",
            "city"=> "Pont-Saint-Martin",
            "country"=> "France"
        ],
        "mail_address"=> "phpunit@test.com",
        "phone"=> "0605410616"
    );
    protected $userForClient1 = array(
            "address" => array(
                "number"  => 1,
                "street"  => "Rue des users",
                "postal"  => "44000",
                "city"    => "Nantes",
                "country" => "France"
            ),
            "first_name"   => "User 1",
            "last_name"    => "of Client 1",
            "mail_address" => "user1.1@gmail.com",
            "phone"        => "0601010101"
        );
    protected $userIdForClient1 = 1;
    protected $userIdForClient2 = 9;

    public function loadEntryPoints(): array
    {
        return [
            "testCreateTokenOkDataOk" => [
                [
                    "type"           => "POST",
                    "url"            => "/api/users",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => true,
                    "content"        => json_encode($this->testUser),
                    "expectedCode"   => Response::HTTP_CREATED,
                    "needReturnOnOK" => true,
                    "additionalCheck"=> "checkCreateTokenOkDataOk"
                ]
            ],
            "testCreateTokenOkDataKo" => [
                [
                    "type"           => "POST",
                    "url"            => "/api/users",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => true,
                    "content"        => json_encode($this->badTestUser),
                    "expectedCode"   => Response::HTTP_BAD_REQUEST,
                    "needReturnOnOK" => false,
                ]
            ],
            "testCreateTokenKoDataOk" => [
                [
                    "type"           => "POST",
                    "url"            => "/api/users",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => ["HTTP_AUTHORIZATION" => $this->expiredToken],
                    "authenticated"  => false,
                    "content"        => json_encode($this->testUser),
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testCreateTokenKoDataKo" => [
                [
                    "type"           => "POST",
                    "url"            => "/api/users",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => ["HTTP_AUTHORIZATION" => $this->expiredToken],
                    "authenticated"  => false,
                    "content"        => json_encode($this->badTestUser),
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testCreateNoTokenDataOk" => [
                [
                    "type"           => "POST",
                    "url"            => "/api/users",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => false,
                    "content"        => json_encode($this->testUser),
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testCreateNoTokenDataKo" => [
                [
                    "type"           => "POST",
                    "url"            => "/api/users",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => false,
                    "content"        => json_encode($this->badTestUser),
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testGetUserTokenOkIdOkBelongOK" => [
                [
                    "type"           => "GET",
                    "url"            => "/api/users/".$this->userIdForClient1,
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => true,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_OK,
                    "needReturnOnOK" => true,
                    "additionalCheck"=> "checkGetUserTokenOkIdOkBelongOK"
                ]
            ],
            "testGetUserTokenOkIdOkBelongKo" => [
                [
                    "type"           => "GET",
                    "url"            => "/api/users/".$this->userIdForClient2,
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => true,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_FORBIDDEN,
                    "needReturnOnOK" => false,
                ]
            ],
            "testGetUserTokenOkIdKo" => [
                [
                    "type"           => "GET",
                    "url"            => "/api/users/1000",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => true,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_NOT_FOUND,
                    "needReturnOnOK" => false,
                ]
            ],
            "testGetUserTokenKoIdOk" => [
                [
                    "type"           => "GET",
                    "url"            => "/api/users/".$this->userIdForClient1,
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => ["HTTP_AUTHORIZATION" => $this->expiredToken],
                    "authenticated"  => false,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testGetUserTokenKoIdKo" => [
                [
                    "type"           => "GET",
                    "url"            => "/api/users/1000",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => ["HTTP_AUTHORIZATION" => $this->expiredToken],
                    "authenticated"  => false,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testGetUserNoTokenIdOk" => [
                [
                    "type"           => "GET",
                    "url"            => "/api/users/".$this->userIdForClient1,
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => false,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testGetUserNoTokenIdKo" => [
                [
                    "type"           => "GET",
                    "url"            => "/api/users/1000",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => false,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testListUserTokenOk" => [
                [
                    "type"           => "GET",
                    "url"            => "/api/users",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => true,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_OK,
                    "needReturnOnOK" => true,
                    "additionalCheck"=> "checkListUserTokenOk"
                ]
            ],
            "testListUserTokenKo" => [
                [
                    "type"           => "GET",
                    "url"            => "/api/users",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => ["HTTP_AUTHORIZATION" => $this->expiredToken],
                    "authenticated"  => false,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testListUserNoToken" => [
                [
                    "type"           => "GET",
                    "url"            => "/api/users",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => false,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testDeleteUserTokenOkIdOkBelongOK" => [
                [
                    "type"           => "DELETE",
                    "url"            => "/api/users/".$this->userIdForClient1,
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => true,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_OK,
                    "needReturnOnOK" => true,
                    "additionalCheck"=> "checkDeleteUserTokenOkIdOkBelongOK"
                ]
            ],
            "testDeleteUserTokenOkIdOkBelongKo" => [
                [
                    "type"           => "DELETE",
                    "url"            => "/api/users/".$this->userIdForClient2,
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => true,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_FORBIDDEN,
                    "needReturnOnOK" => false,
                ]
            ],
            "testDeleteUserTokenOkIdKo" => [
                [
                    "type"           => "DELETE",
                    "url"            => "/api/users/1000",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => true,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_NOT_FOUND,
                    "needReturnOnOK" => false,
                ]
            ],
            "testDeleteUserTokenKoIdOk" => [
                [
                    "type"           => "DELETE",
                    "url"            => "/api/users/".$this->userIdForClient1,
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => ["HTTP_AUTHORIZATION" => $this->expiredToken],
                    "authenticated"  => false,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testDeleteUserTokenKoIdKo" => [
                [
                    "type"           => "DELETE",
                    "url"            => "/api/users/1000",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => ["HTTP_AUTHORIZATION" => $this->expiredToken],
                    "authenticated"  => false,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testDeleteUserNoTokenIdOk" => [
                [
                    "type"           => "DELETE",
                    "url"            => "/api/users/".$this->userIdForClient1,
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => false,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
            "testDeleteUserNoTokenIdKo" => [
                [
                    "type"           => "DELETE",
                    "url"            => "/api/users/1000",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => false,
                    "content"        => "",
                    "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                    "needReturnOnOK" => false,
                ]
            ],
        ];
    }

    /**
     * Checks first user in list correspond to firs user data defined in class and check _links on each user displayed
     * @param $result
     */
    protected function checkListUserTokenOk($result){

        $usersList = $result->_embedded->items;
        $firstUserInList = $this->userForClient1;

        // Unsetting address & phone because these values aren't displayed in list
        unset($firstUserInList['address']);
        unset($firstUserInList['phone']);

        $this->checkAttributes(
            (json_decode(json_encode($usersList[0]), true)),
            (json_decode(json_encode($firstUserInList), true))
        );

        foreach ($usersList as $resultUser){
            $this->checkLinks($resultUser, ['create', 'delete', 'self']);
        }

        $this->checkLinks($result, ['first', 'last', 'self']);
    }

    /**
     * Checks newly created user by comparing returned user values on creation with initial set of data
     * @param $result
     */
    protected function checkCreateTokenOkDataOk($result){
        $this->checkAttributes(
            (json_decode(json_encode($result), true)),
            (json_decode(json_encode($this->testUser), true))
        );
        $this->checkLinks($result, ['create', 'delete']);
    }

    /**
     * Check if response equals "OK" and search user based on id in database. Assert this search's result is empty
     * @param $result
     */
    protected function checkDeleteUserTokenOkIdOkBelongOK($result){
        $this->assertEquals("OK", $result);
        $this->assertEmpty(
            static::$container->get(UserRepository::class)->createQueryBuilder('u')
                ->andWhere('u.id = :val')
                ->setParameter('val', $this->userIdForClient1)
                ->getQuery()
                ->getResult()
        );
    }

    /**
     * Checks if returned user (id defined in class) correspond to data (defined in class) and check _links content
     * @param $result
     */
    protected function checkGetUserTokenOkIdOkBelongOK($result){
        $this->checkAttributes(
            (json_decode(json_encode($result), true)),
            (json_decode(json_encode($this->userForClient1), true))
        );
        $this->checkLinks($result, ['create', 'delete']);
    }
}
