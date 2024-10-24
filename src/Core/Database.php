<?php

namespace Core;

class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "restaurante";
    private $connection;

    public function __construct() {
        $this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->database);

        if (mysqli_connect_errno()) {
            die("Failed to connect to MySQL: " . mysqli_connect_error());
        }

        mysqli_set_charset($this->connection, "utf8");
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}
