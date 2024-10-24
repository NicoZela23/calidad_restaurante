<?php

namespace Models;

use Core\Database;

class UserModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getUserByEmailAndPassword($email, $password) {
        $email = mysqli_real_escape_string($this->db, $email);
        $password = md5(mysqli_real_escape_string($this->db, $password));

        $query = "SELECT * FROM usuarios WHERE correo = '$email' AND pass = '$password'";
        $result = mysqli_query($this->db, $query);

        return mysqli_fetch_array($result);
    }
}
