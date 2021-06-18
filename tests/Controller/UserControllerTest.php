<?php

namespace App\Tests\Controller;

use App\Tests\BilemoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends BilemoWebTestCase
{
    public function testEntryPoints(): void
    {
        // Get token for this test
        $this->token = $this->entryPoint([
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

        $userForClient1 = 1;
        $userForClient2 = 5;
        $testUser = array
        (
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
        $tests = [
            [
                "name"           => "testShowDetailsUnauthenticated",
                "type"           => "GET",
                "url"            => "/api/users/".$userForClient1,
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => false,
                "content"        => "",
                "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                "needReturnOnOK" => false
            ],
            [
                "name"           => "testShowDetailsAuthenticated",
                "type"           => "GET",
                "url"            => "/api/users/".$userForClient1,
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => true,
                "content"        => "",
                "expectedCode"   => Response::HTTP_OK,
                "needReturnOnOK" => false
            ],
            [
                "name"           => "testShowDetailsWrongAuthenticated",
                "type"           => "GET",
                "url"            => "/api/users/".$userForClient2,
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => true,
                "content"        => "",
                "expectedCode"   => Response::HTTP_FORBIDDEN,
                "needReturnOnOK" => false
            ],
            [
                "name"           => "testShowListUnauthenticated",
                "type"           => "GET",
                "url"            => "/api/users",
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => false,
                "content"        => "",
                "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                "needReturnOnOK" => false
            ],
            [
                "name"           => "testShowListAuthenticated",
                "type"           => "GET",
                "url"            => "/api/users",
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => true,
                "content"        => "",
                "expectedCode"   => Response::HTTP_OK,
                "needReturnOnOK" => false
            ],
            [
                "name"           => "testCreateUnauthenticated",
                "type"           => "POST",
                "url"            => "/api/users",
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => false,
                "content"        => json_encode($testUser),
                "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                "needReturnOnOK" => false
            ],
            [
                "name"           => "testCreateAuthenticated",
                "type"           => "POST",
                "url"            => "/api/users",
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => true,
                "content"        => json_encode($testUser),
                "expectedCode"   => Response::HTTP_CREATED,
                "needReturnOnOK" => false
            ],
            [
                "name"           => "testDeleteUnauthenticated",
                "type"           => "DELETE",
                "url"            => "/api/users/".$userForClient1,
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => false,
                "content"        => "",
                "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                "needReturnOnOK" => false
            ],
            [
                "name"           => "testDeleteWrongAuthenticated",
                "type"           => "DELETE",
                "url"            => "/api/users/".$userForClient2,
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => true,
                "content"        => "",
                "expectedCode"   => Response::HTTP_FORBIDDEN,
                "needReturnOnOK" => false
            ],
            [
                "name"           => "testDeleteAuthenticated",
                "type"           => "DELETE",
                "url"            => "/api/users/".$userForClient1,
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => true,
                "content"        => "",
                "expectedCode"   => Response::HTTP_OK,
                "needReturnOnOK" => false
            ]
        ];
        foreach ($tests as $test){
            $this->entryPoint($test);
        }
    }
}
