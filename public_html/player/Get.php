<?php

require_once("Database.php");

class Get {

    public $url;
    public $id;
    public $result;
    public $sql;
    
    function __construct() {
        $this->db = new Database;
    }

    public function playNow() {

        $this->sql = "SELECT * FROM playlist WHERE status = 'NOW' LIMIT 1";

        if ($this->isQueryNotEmpty()) {
            $this->setStatusToPlaying();
            $this->setPlayListPositionToZero();
        } else {
            return false;
        }
    }

    public function playNext() {

        $this->sql = "SELECT * FROM playlist WHERE queue IN (SELECT MIN(queue) 
                FROM playlist WHERE queue != 0) LIMIT 1";

        if ($this->isQueryNotEmpty()) {
            $this->setPlayListPositionToZero();
        } else {
            return false;
        }
    }

    private function isQueryNotEmpty() {
        $this->result = $this->db->connection->query($this->sql);
        
        if ($this->result->num_rows > 0) {
            $this->readDataToProperties();
        } else {
            return false;
        }
        return true;
    }
    
    private function readDataToProperties() {
        while($row = $this->result->fetch_assoc()) {
            $this->url = $row["url"];
            $this->id = $row['id'];
        }  
    }   
    
    private function setStatusToPlaying() {
        $this->db->sql = "
                UPDATE playlist SET status = 'playing' WHERE id = '$this->id'";
                
        $this->db->makeQuery(); 
    }
    
    private function setPlayListPositionToZero() {
        $this->db->sql = "
                UPDATE playlist SET queue = 0  WHERE id = '$this->id'";
        $this->db->makeQuery();   
    }
}
