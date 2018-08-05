<?php
/**
 * Created by PhpStorm.
 * User: azzur
 * Date: 04/08/2018
 * Time: 23:47
 */

namespace Test\Models;

use GetVeg\Models\VegetableModel;
use PHPUnit\Framework\TestCase;
use Pseudo\Pdo;

class vegetablesTest extends TestCase
{
    function testSetPdo()
    {
        $pdoMock = $this->createMock(\PDO::class);
        $model = new \GetVeg\Models\VegetableModel();
        $model->setPdo($pdoMock);
        $this->assertInstanceOf(\PDO::class,$model->getPdo());

    }

    function testSetDataCleaner()
    {
        $mock = $this->createMock(\GetVeg\utils\DataCleaner::class);
        $model = new \GetVeg\Models\VegetableModel();
        $model->setDataCleaner($mock);
        $this->assertInstanceOf(\GetVeg\utils\DataCleaner::class,$model->getDataCleaner());
    }

    function testGetVegetableList()
    {
        $p = new Pdo();
        $results = [
            ['id' => 1, 'name' => 'test', "classification" => "test", "description" => "test", "edible" => "true"],
            ['id' => 2, 'name' => 'test', "classification" => "test", "description" => "test", "edible" => "true"],
            ['id' => 3, 'name' => 'test', "classification" => "test", "description" => "test", "edible" => "true"]
        ];
        $p->mock("SELECT * FROM Vegetables", $results);
        $model = new VegetableModel();
        $model->setPdo($p);
        $data = $model->getVegetableList();
        $this->assertEquals($results, $data);
    }
}