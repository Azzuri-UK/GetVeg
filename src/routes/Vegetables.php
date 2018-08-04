<?php
/**
 * Created by PhpStorm.
 * User: Justin Carter
 * Date: 03/08/2018
 * Time: 23:37
 */

namespace GetVeg\Routes;

class Vegetables
{
    /**
     * @var \GetVeg\Models\Vegetables
     */
    public $model;

    /**
     * Set PDO.
     *
     * @param \GetVeg\Models\Vegetables $model
     */
    public function setModel(\GetVeg\Models\Vegetables $model)
    {
        $this->model = $model;
    }


    /**
     *  Default get method for /vegetables
     * @return array
     */
    public function getIndex()
    {
        try {
            $veg = $this->model->getVegetableList();
            $data = [
                "success" => true,
                "recordCount" => count($veg),
                "data" => $veg
            ];
            return $data;

        } catch (\Exception $e) {
            $data = [
                "success" => false,
                "error" => $e->getMessage()
            ];
            return $data;
        }
    }


    /**
     * Returns a list of edible vegetables
     * @return array
     */
    public function getEdible()
    {
        try {
            $veg = $this->model->getEdibleVegetableList();
            $data = [
                "success" => true,
                "recordCount" => count($veg),
                "data" => $veg
            ];
            return $data;

        } catch (\Exception $e) {
            $data = [
                "success" => false,
                "error" => $e->getMessage()
            ];
            return $data;
        }
    }

    /**
     * Returns a list of inedible vegetables (I'M LOOKING AT YOU TOMATO!)
     * @return array
     */
    public function getInedible()
    {
        try {
            $veg = $this->model->getInedibleVegetableList();
            $data = [
                "success" => true,
                "recordCount" => count($veg),
                "data" => $veg
            ];
            return $data;

        } catch (\Exception $e) {
            $data = [
                "success" => false,
                "error" => $e->getMessage()
            ];
            return $data;
        }
    }

    /**
     * Returns the data for a specific vegetable
     * @param $vegetable
     * @return array
     */
    public function getVegetable($vegetable)
    {
        try {
            $veg = $this->model->getVegetable($vegetable);
            $data = [
                "success" => true,
                "recordCount" => count($veg),
                "data" => $veg
            ];
            return $data;

        } catch (\Exception $e) {
            $data = [
                "success" => false,
                "error" => $e->getMessage()
            ];
            return $data;
        }
    }

}

?>