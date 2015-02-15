<?php
class Database {

      public $connection;
      public $sql;

      function __construct(){
          $this->connection = $this->connect();
      }

      private function connect() {
      	     $servername = "localhost";
      	     $username = "";
      	     $password = "";
	     $db = "";

	     // Create connection
	     $conn = new mysqli($servername, $username, $password, $db);

      	     // Check connection
	     if ($conn->connect_error) {
	     	die("Connection failed: " . $conn->connect_error);
             } 
             return $conn;
     }

     public function makeQuery() {
            if ($this->connection->query($this->sql) !== TRUE) {
                echo "Error: " . $this->sql . "<br>" . $this->connection->error;
            }
     }
}
