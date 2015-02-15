<?php

require_once("Database.php");

class Get {

    public $url;
    public $id;
    public $longUrl;

    function __construct() {
        $this->db = new Database;
    }

    public function playNow() {

        $sql = "SELECT * FROM playlist WHERE status = 'NOW' LIMIT 1";
        $result = $this->db->connection->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $this->url = $row["url"];
                $this->id = $row['id'];
                $this->longUrl = $row['long_url'];
            }

            $this->db->sql = "UPDATE playlist SET status = 'playing' WHERE id = '$this->id' ";
            $this->db->makeQuery();

            $this->db->sql = "UPDATE playlist SET queue = 0 WHERE id = '$this->id' ";
            $this->db->makeQuery();

        } else {
            return false;
        }
    }

    public function playNext() {

        $sql = "SELECT * FROM playlist WHERE queue IN (SELECT MIN(queue) FROM playlist WHERE queue != 0) LIMIT 1";
        $result = $this->db->connection->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $this->url = $row["url"];
                $this->id = $row['id'];
                $this->longUrl = $row['long_url'];
            }

            $this->db->sql = "UPDATE playlist SET queue = 0 WHERE id = '$this->id' ";
            $this->db->makeQuery();

        } else {
            return false;
        }
    }
}
