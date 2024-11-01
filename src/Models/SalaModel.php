<?php
namespace Models;

use Core\Database;

class SalaModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllSalas() {
        $query = mysqli_query($this->db, "SELECT * FROM salas WHERE estado = 1");
        $salas = [];
        while ($data = mysqli_fetch_assoc($query)) {
            $salas[] = $data;
        }
        return $salas;
    }

    public function getAllSalas_Pedidos($id_sala) {
        $query = "SELECT * FROM salas 
        INNER JOIN pedidos ON salas.id = pedidos.id_sala 
        WHERE pedidos.id_sala = $id_sala 
        ORDER BY pedidos.id_sala";
        $result = mysqli_query($this->db, $query);
        $sala_pedidos = [];
    
        while ($data = mysqli_fetch_assoc($result)) {
            $sala_pedidos[] = $data;
        }
    
        return $sala_pedidos;
    }
    
    public function getSalaByName($nombre) {
        $query = mysqli_query($this->db, "SELECT * FROM salas WHERE nombre = '$nombre' AND estado = 1");
        return mysqli_fetch_assoc($query);
    }

    public function insertSala($nombre, $mesas) {
        $query = mysqli_query($this->db, "INSERT INTO salas (nombre, mesas) VALUES ('$nombre', '$mesas')");
        return $query;
    }

    public function updateSala($id, $nombre, $mesas) {
        $query = mysqli_query($this->db, "UPDATE salas SET nombre = '$nombre', mesas = '$mesas' WHERE id = $id");
        return $query;
    }
    public function deleteSala($id) {
        $query = "
            DELETE 
            FROM salas 
            WHERE id = $id
        ";
        return mysqli_query($this->db, $query);
    }
}
