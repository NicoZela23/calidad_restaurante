<?php
namespace Models;

use Core\Database;

class AnalisisVentaModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getProductosMasVendidos() {
        $query = "
            SELECT p.nombre, SUM(dp.cantidad) AS total_vendido, SUM(dp.cantidad * dp.precio) AS total_ingreso
            FROM detalle_pedidos dp
            JOIN platos p ON dp.nombre = p.nombre
            JOIN pedidos pe ON dp.id_pedido = pe.id
            WHERE pe.estado = 'FINALIZADO'
            GROUP BY p.nombre
            ORDER BY total_vendido DESC
        ";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getIngresosPorFecha() {
        $query = "
            SELECT DATE(pe.fecha) AS fecha, SUM(pe.total) AS ingreso_diario
            FROM pedidos pe
            WHERE pe.estado = 'FINALIZADO'
            GROUP BY DATE(pe.fecha)
            ORDER BY fecha DESC
        ";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getIngresosPorSala() {
        $query = "
            SELECT s.nombre AS sala, SUM(pe.total) AS ingreso_sala
            FROM pedidos pe
            JOIN salas s ON pe.id_sala = s.id
            WHERE pe.estado = 'FINALIZADO'
            GROUP BY s.nombre
        ";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
