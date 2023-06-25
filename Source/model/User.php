<?php
//ko cho access directly = http
if (!defined('DirectAccess')) {
    die('Direct access not permitted');
}
require_once "./configs/db.php";
class UserModel
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $username;
    public $password;


    function __construct()
    {
    }

    public static function getUserByUn($un, $pw)
    {
        $database = "MDM";
        $collection = "accounts";

        $redis = DB::getRedisInstance();

        if ($redis->exists($un)) {
            $data = unserialize($redis->get($un));
            $_SESSION['nameOfuser'] = $data['name'];
            $_SESSION['username'] = $data['username'];
            return true;
        } else {
            $mongo = DB::getMongoDBInstance($database, $collection);
            $filter = [
                'username'   =>  $un,
                'password'  =>  $pw
            ];
            $result = $mongo->findOne($filter);



            if ($result != null) {
                $redis->set($un, serialize($result));
                $redis->expire($un, 3600);

                $_SESSION['nameOfuser'] = $result['name'];
                $_SESSION['username'] = $result['username'];
                return true;
            }
        }

        return false;
    }
    public static function getUserInfoByUn($un)
    {
        $redis = DB::getRedisInstance();
        if ($redis->exists($un)) {
            $data = unserialize($redis->get($un));
            return $data;
        } else {
            $database = "MDM";
            $collection = "accounts";
            $mongo = DB::getMongoDBInstance($database, $collection);
            $filter = [
                'username'   =>  $un,
            ];
            $result = $mongo->findOne($filter);



            if ($result != null) {
                $redis->set($un, serialize($result));
                $redis->expire($un, 3600);

                $_SESSION['nameOfuser'] = $result['name'];
                $_SESSION['username'] = $result['username'];
                return $result;
            }
        }

        return null;
    }
    public static function IsExistUser($un) {
        $database = "MDM";
        $collection = "accounts";
        $mongo = DB::getMongoDBInstance($database,$collection);
        $filter = ['username'   =>  $un];
        $result = $mongo->findOne($filter);
        if ($result != null) {
            $redis->set($key, $result, 300);
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
