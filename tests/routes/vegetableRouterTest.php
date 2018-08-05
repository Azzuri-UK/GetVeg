<?php
/**
 * Created by PhpStorm.
 * User: azzur
 * Date: 04/08/2018
 * Time: 23:47
 */

namespace Test\Routes;

use GetVeg\Models\VegetableModel;
use GetVeg\Routes\VegetableRouter;
use PHPUnit\Framework\TestCase;
use Pseudo\Pdo;

class vegetableRouterTest extends TestCase
{
    function testSetModel()
    {
        $modelMock = $this->createMock(VegetableModel::class);
        $this->assertTrue((new VegetableRouter())->setModel($modelMock));
    }

    function testExceptionHandler(){
        $p = new Pdo();
        $results = [
            ['id' => 1, 'name' => 'test', "classification" => "test", "description" => "test", "edible" => "true"],
            ['id' => 2, 'name' => 'test', "classification" => "test", "description" => "test", "edible" => "true"],
            ['id' => 3, 'name' => 'test', "classification" => "test", "description" => "test", "edible" => "true"]
        ];
        $p->mock("SELECT * FROM Vegetables WHERE fail=true", $results);
        $model = new VegetableModel();
        $model->setPdo($p);

        $router = new VegetableRouter();
        $router->setModel($model);
        $data = $router->getIndex();
        $this->assertTrue($data['success']===false);
    }

    function testGetVegetableList(){
        $p = new Pdo();
        $results = [
            ['id' => 1, 'name' => 'test', "classification" => "test", "description" => "test", "edible" => "true"],
            ['id' => 2, 'name' => 'test', "classification" => "test", "description" => "test", "edible" => "true"],
            ['id' => 3, 'name' => 'test', "classification" => "test", "description" => "test", "edible" => "true"]
        ];
        $p->mock("SELECT * FROM Vegetables", $results);
        $model = new VegetableModel();
        $model->setPdo($p);

        $router = new VegetableRouter();
        $router->setModel($model);
        $data = $router->getIndex();
        $this->assertTrue($data['success']===true);
        $this->assertEquals($results, $data['data']);
    }


}