<?php
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\ServerApi;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Manager;

class DB{
    
    private static $redisInstance = NULL;
    // config Mongodb
    public static function getMongoDBInstance($database,$collection){
        $mongoInstance = NULL;
        try {
            $mongoClient = new MongoDB\Client('mongodb://localhost:27017'); // Thay đổi host và port nếu cần thiết
            $database = $mongoClient->$database;
            $mongoInstance = $database->$collection;
        
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        return $mongoInstance;
   
    }

        
        
    
    

    // config Redis
    public static function getRedisInstance(){

        if (!isset(self::$redisInstance)) {
            try {
                $redisInstance = new Redis();
                $redisInstance->connect('localhost', 6379);
           
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
      }
      return self::$redisInstance;
        
    }

}




?>