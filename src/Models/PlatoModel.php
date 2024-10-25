<?php
namespace Models;

use Core\Database;

class PlatoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllPlatos() {
        $query = mysqli_query($this->db, "SELECT * FROM platos WHERE estado = 1");
        return mysqli_fetch_assoc($query);
    }

    public function getPlatoByName($plato) {
        $query = mysqli_query($this->db, "SELECT * FROM platos WHERE nombre = '$plato' AND estado = 1");
        return mysqli_fetch_array($query);
    }

    public function insertPlato($plato, $precio, $imagen, $descripcion) {
        $query = mysqli_query($this->db, "INSERT INTO platos (nombre, precio, imagen, descripcion) VALUES ('$plato', '$precio', '$imagen', '$descripcion')");
        return $query;
    }

    public function updatePlato($id, $plato, $precio, $imagen, $descripcion) {
        $query = mysqli_query($this->db, "UPDATE platos SET nombre = '$plato', precio = $precio, imagen = '$imagen', descripcion = '$descripcion' WHERE id = $id");
        return $query;
    }
}
