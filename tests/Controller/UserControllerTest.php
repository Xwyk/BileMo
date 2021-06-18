<?php

namespace App\Tests\Controller;

use App\Test\BilemoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends BilemoWebTestCase
{
    protected $testUser;
    public function loadEntryPoints(): void
    {
        $userForClient1 = 1;
        $userForClient2 = 5;
        $this->testUser = array
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
        $this->tests = [
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
                "needReturnOnOK" => true,
                "additionalCheck"=> "checkShowDetailsAuthenticated"
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
                "needReturnOnOK" => true,
                "additionalCheck"=> "checkShowListAuthenticated"
            ],
            [
                "name"           => "testCreateUnauthenticated",
                "type"           => "POST",
                "url"            => "/api/users",
                "parameters"     => [],
                "files"          => [],
                "server"         => [],
                "authenticated"  => false,
                "content"        => json_encode($this->testUser),
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
                "content"        => json_encode($this->testUser),
                "expectedCode"   => Response::HTTP_CREATED,
                "needReturnOnOK" => true,
                "additionalCheck"=> "checkCreateAuthenticated"
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
                "needReturnOnOK" => true,
                "additionalCheck"=> "checkDeleteAuthenticated"
            ]
        ];
    }

    protected function checkShowListAuthenticated($result){

    }

    /**
     * Checks newly created user by comparing returned user values on creation with initial set of data
     * @param $result
     */
    protected function checkCreateAuthenticated($result){
        $this->checkAttributes(
            (json_decode(json_encode($result), true)),
            (json_decode(json_encode($this->testUser), true)),
            "checkCreateAuthenticated");
        $this->checkLinks($result, ['create', 'delete']);
    }

    protected function checkDeleteAuthenticated($result){

    }

    protected function checkShowDetailsAuthenticated($result){
        $this->checkLinks($result, ['create', 'delete']);
    }

    /**
     * Checks for each link in $expetedLinks if it exists in $object->_links.
     * @param object $object
     * @param array $expectedLinks
     */
    protected function checkLinks(object $object, array $expectedLinks)
    {
        foreach ($expectedLinks as $link){
            $this->assertTrue(isset($object->_links->$link), "Link ".$link." isn't present in object");
        }
    }

    /**
     * Recursively check that result contains all toCompare values
     * @param array $result
     * @param array $toCompare
     */
    protected function checkAttributes(array $result, array $toCompare, string $name){
        foreach ($toCompare as $attribute => $value){
            // If $value is an array, enter in the recursive world
            if (gettype($value) == "array"){
                $this->checkAttributes($result[$attribute], $value, $name);
                // Once all array attributes are checked, continue with next parent's attribute
                continue;
            }
            $this->assertEquals($value, $result[$attribute], "Failed on ".$name." at ".$attribute);
        }
    }
}
