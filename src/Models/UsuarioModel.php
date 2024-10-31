<?php

namespace Models;

use Core\Database
;
class UsuarioModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllUsers() {
        $result = $this->db->query("SELECT * FROM usuarios WHERE estado = 1");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = ? AND estado = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insertUser($nombre, $correo, $rol, $pass) {
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, correo, rol, pass) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nombre, $correo, $rol, $pass);
        return $stmt->execute();
    }

    public function updateUser($id, $nombre, $correo, $rol) {
        $stmt = $this->db->prepare("UPDATE usuarios SET nombre = ?, correo = ?, rol = ? WHERE idusuario = ?");
        $stmt->bind_param("ssii", $nombre, $correo, $rol, $id);
        return $stmt->execute();
    }
}
?>
