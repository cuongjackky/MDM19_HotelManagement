<?php
// models/HotelModel.php

// Không cho phép truy cập trực tiếp thông qua HTTP
if (!defined('DirectAccess')) {
    die('Direct access not permitted');
}

require_once "./configs/db.php";

class HotelModel
{
    public function getAllHotels()
    {
        $database = "MDM";
        $collection = "hotels";
        $mongo = DB::getMongoDBInstance($database, $collection);

        $query = $mongo->find([]);
        $hotels = $query->toArray();

        return $hotels;
    }
}
