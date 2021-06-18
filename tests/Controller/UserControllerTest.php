<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use App\Test\BilemoWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends BilemoWebTestCase
{
    protected $testUser;
    protected $userForClient1;
    protected $userIdForClient1 = 1;
    protected $userIdForClient2 = 9;

    public function loadEntryPoints(): void
    {
        $this->userForClient1 = array(
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
        $this->testUser = array(
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
                "url"            => "/api/users/".$this->userIdForClient1,
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
                "url"            => "/api/users/".$this->userIdForClient1,
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
                "url"            => "/api/users/".$this->userIdForClient2,
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
                "url"            => "/api/users/".$this->userIdForClient1,
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
                "url"            => "/api/users/".$this->userIdForClient2,
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
                "url"            => "/api/users/".$this->userIdForClient1,
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

    /**
     * Checks first user in list correspond to firs user data defined in class and check _links on each user displayed
     * @param $result
     */
    protected function checkShowListAuthenticated($result){

        $usersList = $result->_embedded->items;
        $firstUserInList = $this->userForClient1;

        // Unsetting address & phone because these values aren't displayed in list
        unset($firstUserInList['address']);
        unset($firstUserInList['phone']);

        $this->checkAttributes(
            (json_decode(json_encode($usersList[0]), true)),
            (json_decode(json_encode($firstUserInList), true)),
            "checkShowListAuthenticated");

        foreach ($usersList as $resultUser){
            $this->checkLinks($resultUser, ['create', 'delete', 'self']);
        }

        $this->checkLinks($result, ['first', 'last', 'self']);
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

    /**
     * Check if response equals "OK" and search user based on id in database. Assert this search's result is empty
     * @param $result
     */
    protected function checkDeleteAuthenticated($result){
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
    protected function checkShowDetailsAuthenticated($result){
        $this->checkAttributes(
            (json_decode(json_encode($result), true)),
            (json_decode(json_encode($this->userForClient1), true)),
            "checkShowDetailsAuthenticated");
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
            if (is_array($value)){
                $this->checkAttributes($result[$attribute], $value, $name);
                // Once all array attributes are checked, continue with next parent's attribute
                continue;
            }
            $this->assertEquals($value, $result[$attribute], "Failed on ".$name." at ".$attribute);
        }
    }
}
