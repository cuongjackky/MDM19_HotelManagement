<?php
//ko cho access directly = http
if(!defined('DirectAccess')) {
    die('Direct access not permitted');
}

class UserModel {
    public $userid;
    public $username;
    public $password;


    function __construct() {
        
    }

    public static function getUserByUn($un) {
        return true;
    }

    
}

?>