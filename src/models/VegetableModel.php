<?php
/**
 * Created by PhpStorm.
 * User: Justin Carter
 * Date: 04/08/2018
 * Time: 10:25
 */

namespace GetVeg\Models;

use PDO;
use GetVeg\utils\DataCleaner;
class VegetableModel
{
    /**
     * @var \PDO
     */
    public $pdo;
    
     /**
     * @var \GetVeg\Utils\DataCleaner
     */
    public $dataCleaner;

    /**
     * Set PDO.
     *
     * @param \PDO $pdo
     */
    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPdo(){
        return $this->pdo;
    }

    public function setDataCleaner(DataCleaner $cleaner){
        $this->dataCleaner = $cleaner;
    }

    public function getDataCleaner(){
        return $this->dataCleaner;
    }


    /**
     * @return mixed
     */
    public function getVegetableList()
    {
        try {
            $stmnt = $this->pdo->prepare("SELECT * FROM Vegetables");
            $stmnt->execute();
            return $this->getDataCleaner()->clean($stmnt->fetchAll($this->pdo::FETCH_ASSOC));
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
     * Get a specific vegetable, pass results through dataCleaner before returning
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
