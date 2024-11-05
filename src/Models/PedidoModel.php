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

    public function insertPlato($id_sala, $mesa, $total, $observacion, $id_usuario)
    {
        $query = "
            INSERT INTO pedidos (id_sala, num_mesa, total, observacion, id_usuario)
            VALUES ('$id_sala', '$mesa', '$total', '$observacion', '$id_usuario')";
        $result = mysqli_query($this->db, $query);
        $id_pedido = $result ? mysqli_insert_id($this->db) : null;
        return $id_pedido;
    }
    public function insertDetallePedido($nombre, $precio, $cantidad, $id_pedido)
    {
        $query = "
            INSERT INTO detalle_pedidos (nombre, precio, cantidad, id_pedido) 
            VALUES ('$nombre', '$precio', $cantidad, $id_pedido)
        ";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function getPedidoById($id_sala, $num_mesa)
    {
        $query = "
            SELECT dp.cantidad, dp.precio, p.id AS plato_id
            FROM pedidos AS pe
            JOIN detalle_pedidos AS dp ON pe.id = dp.id_pedido
            JOIN platos AS p ON dp.nombre = p.nombre
            WHERE pe.id_sala = $id_sala
            AND pe.num_mesa = $num_mesa
            AND pe.estado = 'PENDIENTE';
        ";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function deleteTempPedido()
    {
        $query = "
            DELETE 
            FROM temp_pedidos
        ";
        $result = mysqli_query($this->db, $query);
        return $result;
    }
    public function insertTempPedido($cantidad, $precio, $id_producto)
    {
        $query = "
        INSERT INTO temp_pedidos (cantidad, precio, id_producto, id_usuario) 
        VALUES ($cantidad, $precio, $id_producto, '1')";
        $result = mysqli_query($this->db, $query);
        return $result; //tal vez cambiar a nada
    }

    public function updatePlato($id_sala, $mesa, $total)
    {
        $query = "
            UPDATE pedidos
            SET total = '$total'
            WHERE id_sala = $id_sala AND num_mesa = $mesa AND estado = 'PENDIENTE'
        ";
        $result = mysqli_query($this->db, $query);

        $selectQuery = "
                SELECT id
                FROM pedidos
                WHERE id_sala = $id_sala AND num_mesa = $mesa AND estado = 'PENDIENTE'
                LIMIT 1
            ";
        $selectResult = mysqli_query($this->db, $selectQuery);
        if ($row = mysqli_fetch_assoc($selectResult)) {
            return $row['id'];
        }

        return null;
    }

    public function updateDetallePedido($nombre, $precio, $cantidad, $id_pedido)
    {
        $checkQuery = "
        SELECT *
        FROM detalle_pedidos
        WHERE id_pedido = $id_pedido AND nombre = '$nombre' AND precio = $precio AND cantidad = $cantidad";
        $resultCheck = mysqli_query($this->db, $checkQuery);

        if (mysqli_num_rows($resultCheck) === 0) {
            $anotherCheckQuery = "
            SELECT *
            FROM detalle_pedidos
            WHERE id_pedido = $id_pedido AND nombre = '$nombre' AND precio = $precio";
            $result = mysqli_query($this->db, $anotherCheckQuery);
            if (mysqli_num_rows($result) === 1) {
                $query = "
                UPDATE detalle_pedidos
                SET cantidad = $cantidad
                WHERE id_pedido = $id_pedido AND nombre = '$nombre' AND precio = $precio";
                $result = mysqli_query($this->db, $query);
                return $result;
            } else {
                $result = $this->insertDetallePedido($nombre, $precio, $cantidad, $id_pedido);
                return $result;
            }
        } else if (mysqli_num_rows($resultCheck) === 1) {
            return false;
        }
    }
    public function deleteLeftoverDetallePedido($id_pedido)
    {
        $detalleCountQuery = "
        SELECT COUNT(*) as count 
        FROM detalle_pedidos 
        WHERE id_pedido = $id_pedido
        ";
        $resultDetalle = mysqli_query($this->db, $detalleCountQuery);
        $detalleCount = mysqli_fetch_assoc($resultDetalle)['count'];

        $tempCountQuery = "
        SELECT COUNT(*) as count 
        FROM temp_pedidos
        ";
        $resultTemp = mysqli_query($this->db, $tempCountQuery);
        $tempCount = mysqli_fetch_assoc($resultTemp)['count'];

        if ($detalleCount > $tempCount) {
            // $pedidosMesaQuery = "
            // SELECT *
            // FROM `detalle_pedidos`
            // JOIN `platos` ON detalle_pedidos.nombre = platos.nombre
            // WHERE detalle_pedidos.id_pedido = $id_pedido
            // ORDER BY platos.id
            // ";
            // $resultadoPedidosMesa = mysqli_query($this->db, $pedidosMesaQuery);

            // $tempPedidosQuery = "
            // SELECT * 
            // FROM `temp_pedidos`
            // ORDER BY temp_pedidos.id_producto
            // ";
            // $resultadoTempPedidos = mysqli_query($this->db, $tempPedidosQuery);

            $deleteQuery = "
            DELETE FROM detalle_pedidos
            WHERE id_pedido = $id_pedido 
            AND nombre NOT IN (
                SELECT p.nombre
                FROM temp_pedidos tp
                JOIN platos p ON tp.id_producto = p.id
            );
            ";
            $result = mysqli_query($this->db, $deleteQuery);
            return $result;
        }
    }
    public function finishPedidoState($id_sala, $mesa){
        $query = "
            UPDATE pedidos
            SET estado = 'FINALIZADO'
            WHERE id_sala = $id_sala AND num_mesa = $mesa AND estado = 'PENDIENTE'
        ";
        $result = mysqli_query($this->db, $query);
        return $result;
    }   
}