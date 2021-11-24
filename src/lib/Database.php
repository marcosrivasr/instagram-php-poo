<?php

namespace Marcosrivasr\Instagram\lib;

use PDO;
use PDOException;
use Marcosrivasr\Instagram\config\Constants;

class Database{

    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host = Constants::$HOST;
        $this->db = Constants::$DB;
        $this->user = Constants::$USER;
        $this->password = Constants::$PASSWORD;
        $this->charset = Constants::$CHARSET;
    }

    function connect(){
        try{
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $pdo = new PDO($connection, $this->user, $this->password, $options);
            return $pdo;
        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }
    }

}

?>