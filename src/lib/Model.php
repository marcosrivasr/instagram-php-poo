<?php

namespace Marcosrivasr\Instagram\lib;

use Marcosrivasr\Instagram\lib\Database;

class Model{

    private Database $db;
    
    function __construct(){
        $this->db = new Database();
    }

    function query($query){
        return $this->db->connect()->query($query);
    }

    function prepare($query){
        return $this->db->connect()->prepare($query);
    }
}

?>