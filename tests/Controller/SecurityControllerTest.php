<?php


namespace App\Tests\Controller;

use App\Tests\BilemoWebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends BilemoWebTestCase
{
    public function testEntryPoints(): void
    {
        $tests  = [
            [
                "name"           => "testAuthenticateGoodCredentials",
                "type"           => "DELETE",
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
                "needReturnOnOK" => false
            ],
            [
                "name"           => "testAuthenticateGoodCredentials",
                "type"           => "DELETE",
                "url"            => "/api/login_check",
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => true,
                "content"        => json_encode([
                    "username" => "user1",
                    "password" => "user2"
                ]),
                "expectedCode"   => Response::HTTP_UNAUTHORIZED,
                "needReturnOnOK" => false
            ]
        ];
        foreach ($tests as $test){
            $this->entryPoint($test);
        }
    }



}