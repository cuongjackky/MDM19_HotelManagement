<?php
//ko cho access directly = http
if(!defined('DirectAccess')) {
    die('Direct access not permitted');
}
require_once "./configs/db.php";
class UserModel {
    public $userid;
    public $username;
    public $password;


    function __construct() {
        
    }

    public static function getUserByUn($un,$pw) {
        $redis = DB::getRedisInstance();
        $key = $un+$pw;
        $value = $redis->get($key);
        if ($value){
            return true;
        }
        $redis->set('fuochuy101', 'nguyenfuochuy');

        $database = "MDM";
        $collection = "accounts";
        $mongo = DB::getMongoDBInstance($database,$collection);
        $filter = ['username'   =>  $un,
                    'password'  =>  $pw];
        $result = $mongo->findOne($filter);
        $redis->set($key, $result, 300);
        if ($result != null) {
            return true;
        }
        else return false;

    }

    public static function IsExistUser($un) {
        $database = "MDM";
        $collection = "accounts";
        $mongo = DB::getMongoDBInstance($database,$collection);
        $filter = ['username'   =>  $un];
        $result = $mongo->findOne($filter);
        if ($result != null) {
            return true;
        }
        else return false;
    }
    public static function create($un, $pw, $name, $email, $phone, $address) {
        $database = "MDM";
        $collection = "accounts";
        $mongo = DB::getMongoDBInstance($database,$collection);
        $user = ['username'   =>  $un,
            'password' => $pw,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
            ];
        $result = $mongo->insertOne($user);
        return $result;
    }

    
}

?>