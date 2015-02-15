<?php

require_once ("Database.php");

class Insert {

    public $url;
    public $status;
    public $id;
    public $longurl;

    function __construct() {
        $this->db = new Database;
    }

    public function insert() {
        $this->db->sql = "
        INSERT INTO playlist (queue, url, status) 
        SELECT(
            SELECT MAX(queue)+1 from playlist
        ), 
        '$this->url',
        '$this->status'";
        
        $this->db->makeQuery();
    }
}
