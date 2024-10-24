<?php
namespace Models;

use Core\Database;

class DashboardModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getTotalSalas() {
        $query = mysqli_query($this->db, "SELECT COUNT(id) AS total FROM salas WHERE estado = 1");
        return mysqli_fetch_assoc($query);
    }

    public function getTotalPlatos() {
        $query = mysqli_query($this->db, "SELECT COUNT(id) AS total FROM platos WHERE estado = 1");
        return mysqli_fetch_assoc($query);
    }

    public function getTotalUsuarios() {
        $query = mysqli_query($this->db, "SELECT COUNT(id) AS total FROM usuarios WHERE estado = 1");
        return mysqli_fetch_assoc($query);
    }

    public function getTotalPedidos() {
        $query = mysqli_query($this->db, "SELECT COUNT(id) AS total FROM pedidos WHERE estado = 1");
        return mysqli_fetch_assoc($query);
    }

    public function getTotalVentas() {
        $query = mysqli_query($this->db, "SELECT SUM(total) AS total FROM pedidos");
        return mysqli_fetch_assoc($query);
    }
}
