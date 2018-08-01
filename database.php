<?php

class Database {

    private $connection;

    public function __construct() {
        $this->connection = mysqli_connect("localhost", "root", "", "braintree");
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function insertData($sql) {
        if ($this->connection->query($sql) === TRUE) {
            return true;
        }
        return false;
    }

    public function getData($sql) {
        $result = $this->connection->query($sql);
        $reponse = (array) null;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reponse[] = $row;
            }
        }
        return $reponse;
    }

}
