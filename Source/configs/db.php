<?php
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\ServerApi;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Manager;

class DB{
    private static $mongoInstance = NULL;
    private static $redisInstance = NULL;
    // config Mongodb
    public static function getMongoDBInstance($database,$collection){
        if (!isset(self::$mongoInstance))
            try {
                $mongoClient = new MongoDB\Client('mongodb://localhost:27017'); // Thay đổi host và port nếu cần thiết
                
            
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        }
        $database = $mongoClient->$database;
        self::$mongoInstance = $database->$collection;
        return self::$mongoInstance;
   
    }

        
        
    
    

    // config Redis
    public static function getRedisInstance(){

        if (!isset(self::$redisInstance)) {
            try {
                self::$redisInstance = new Redis();
                self::$redisInstance->connect('localhost', 6379);
           
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
      }
      return self::$redisInstance;
        
    }

}




?>