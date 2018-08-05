<?php
/**
 * Created by PhpStorm.
 * User: azzur
 * Date: 04/08/2018
 * Time: 01:43
 */

namespace GetVeg\Routes;

class IndexRouter
{
    public function getIndex()
    {
        return json_encode("Welcome to GetVeg, the web service of choice for your vegetable needs!");
    }

    /**
     * Returns a list of endpoints
     * @return string
     */
    public function getEndpoints()
    {
        /*
         *  Could do something here to work out all the files in /route and list the endpoints
         *  but it's beyond the scope here and there are considerations such as would
         *  you want to expose all endpoints etc
         */
        $endpoints = [
            "success" => true,
            "data" => [
                "0" => "/vegetables"
            ]
        ];
        return $endpoints;
    }
}