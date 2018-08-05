<?php
/**
 * Created by PhpStorm.
 * User: azzur
 * Date: 04/08/2018
 * Time: 23:48
 */

namespace Test\Routes;

use GetVeg\Routes\IndexRouter;
use PHPUnit\Framework\TestCase;
use Pseudo\Pdo;

class homeTest extends TestCase
{

    function testGetIndex(){
        $router = new IndexRouter();
        $data = $router->getIndex();
        $this->assertTrue($data == "\"Welcome to GetVeg, the web service of choice for your vegetable needs!\"");
    }

    function testGetEndpoints(){
        $endpointsMock = [
            "success" => true,
            "data" => [
                "0" => "/vegetables"
            ]
        ];
        $router = new IndexRouter();
        $data=$router->getEndpoints();

        $this->assertEquals($data,$endpointsMock);
    }
}