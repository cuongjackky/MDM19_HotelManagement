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

    /**
     * @throws RedisException
     */
    public static function getUserByUn($un, $pw): bool
    {
        $redis = DB::getRedisInstance();
        $key = "";
        if($un != null && $pw != null){
            $key = $un . $pw;
        }
        $value = $redis->get($key);
        if ($value){
            return true;
        }

        $database = "MDM";
        $collection = "accounts";
        $mongo = DB::getMongoDBInstance($database,$collection);
        $filter = ['username'   =>  $un,
                    'password'  =>  $pw];
        $result = $mongo->findOne($filter);
        if ($result != null) {
            $redis->set($key, $result, 300);
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