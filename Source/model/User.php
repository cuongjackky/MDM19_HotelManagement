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
        $database = "MDM";
        $collection = "accounts";
        $mongo = DB::getMongoDBInstance($database,$collection);
        $filter = ['username'   =>  $un,
                    'password'  =>  $pw];
        $result = $mongo->findOne($filter);

        
        

        if ($result != null) {
            return true;
        }
        else return false;

    }

    
}

?>