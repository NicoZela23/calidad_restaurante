<?php
namespace Models;

use Core\Database;

class PedidoModel
{
    private $db;
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getPedido($id)
    {
        $query = "
            
        ";
        return mysqli_query($this->db, $query);
    }

    public function getAllTempPedidos()
    {
        $query = "
            SELECT d.*, p.nombre 
            FROM temp_pedidos d 
            INNER JOIN platos p 
            ON d.id_producto = p.id";
        return mysqli_query($this->db, $query);
    }

    public function insertPlato($id_sala, $mesa, $total, $observacion, $id_usuario){
        $query = "
            INSERT INTO pedidos (id_sala, num_mesa, total, observacion, id_usuario)
            VALUES ('$id_sala', '$mesa', '$total', '$observacion', '$id_usuario')";
        $result = mysqli_query($this->db, $query);
        $id_pedido = $result ? mysqli_insert_id($this->db) : null;
        return $id_pedido;
    }
    public function insertDetallePedido($nombre, $precio, $cantidad, $id_pedido){
        $query = "
            INSERT INTO detalle_pedidos (nombre, precio, cantidad, id_pedido) 
            VALUES ('$nombre', '$precio', $cantidad, $id_pedido)";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
}