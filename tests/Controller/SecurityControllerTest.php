<?php


namespace App\Tests\Controller;

use App\Test\BilemoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends BilemoWebTestCase
{
    public function loadEntryPoints(): array
    {
        return [
            "testAuthenticateGoodCredentials" => [
                [
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
                    "needReturnOnOK" => false
                ]
            ],
            "testAuthenticateBadRequest" => [
                [
                    "type"           => "POST",
                    "url"            => "/api/login_check",
                    "parameters"     => [],
                    "files"          => [],
                    "server"         => [],
                    "authenticated"  => false,
                    "content"        => json_encode([
                        "username" => "user1",
                    ]),
                    "expectedCode"   => Response::HTTP_BAD_REQUEST,
                    "needReturnOnOK" => false
                ]
            ],
            "testAuthenticateBadCredentials" => [
                [
                    "type"           => "POST",
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
            ]
        ];
    }



}