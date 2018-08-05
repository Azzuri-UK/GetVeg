<?php
/**
 * Created by PhpStorm.
 * User: Justin Carter
 * Date: 04/08/2018
 * Time: 10:25
 */

namespace GetVeg\Models;

use PDO;
class VegetableModel
{
    /**
     * @var \PDO
     */
    public $pdo;

    /**
     * Set PDO.
     *
     * @param \PDO $pdo
     */
    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
        return true;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function dataCleaner($data)
    {
        /** In the real world we would want code to clean the data here as you can't assume the data coming from
         *  from the database is clean
         */
        return $data;
    }

    /**
     * @return mixed
     */
    public function getVegetableList()
    {
        try {
            $stmnt = $this->pdo->prepare("SELECT * FROM Vegetables");
            $stmnt->execute();
            return $this->dataCleaner($stmnt->fetchAll($this->pdo::FETCH_ASSOC));
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * @return mixed
     */
    public function getEdibleVegetableList()
    {
        try {
            $stmnt = $this->pdo->prepare("SELECT * FROM Vegetables WHERE edible=:value");
            $stmnt->execute(array(':value' => "TRUE"));
            return $this->dataCleaner($stmnt->fetchAll($this->pdo::FETCH_ASSOC));
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * @return mixed
     */
    public function getInedibleVegetableList()
    {
        try {
            $stmnt = $this->pdo->prepare("SELECT * FROM Vegetables WHERE edible=?");
            $stmnt->execute(array("FALSE"));
            return $this->dataCleaner($stmnt->fetchAll($this->pdo::FETCH_ASSOC));
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * @param $vegetable
     * @return mixed
     */
    public function getVegetable($vegetable)
    {
        try {
            $stmnt = $this->pdo->prepare("SELECT * FROM Vegetables WHERE name=?");
            $stmnt->execute(array("$vegetable"));
            return $this->dataCleaner($stmnt->fetchAll($this->pdo::FETCH_ASSOC));
        } catch (PDOException $e) {
            throw $e;
        }
    }
}