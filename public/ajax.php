<?php
include_once("../src/Core/Database.php");
use Core\Database;

$db = new \Core\Database(); 
$conexion = $db->getConnection();

session_start();
if (isset($_GET['detalle'])) {
    $id = $_SESSION['idUser'];
    $datos = array();
    $detalle = mysqli_query($conexion, "SELECT d.*, p.nombre, p.precio, p.imagen FROM temp_pedidos d INNER JOIN platos p ON d.id_producto = p.id WHERE d.id_usuario = $id");
    while ($row = mysqli_fetch_assoc($detalle)) {
        $data['id'] = $row['id'];
        $data['nombre'] = $row['nombre'];
        $data['cantidad'] = $row['cantidad'];
        $data['precio'] = $row['precio'];
        $data['imagen'] = ($row['imagen'] == null) ? '../assets/img/default.png' : $row['imagen'];
        $data['total'] = $data['precio'] * $data['cantidad'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
} else if (isset($_GET['delete_detalle'])) {
    $id_detalle = $_GET['id'];
    $query = mysqli_query($conexion, "DELETE FROM temp_pedidos WHERE id = $id_detalle");
    if ($query) {
        $msg = "ok";
    } else {
        $msg = "Error";
    }
    echo $msg;
    die();
} else if (isset($_GET['detalle_cantidad'])) {
    $id_detalle = $_GET['id'];
    $cantidad = $_GET['cantidad'];
    $query = mysqli_query($conexion, "UPDATE temp_pedidos set cantidad = $cantidad WHERE id = $id_detalle");
    if ($query) {
        $msg = "ok";
    } else {
        $msg = "Error";
    }
    echo $msg;
    die();
} else if (isset($_GET['procesarPedido'])) {
    $id_sala = $_GET['id_sala'];
    $id_user = $_SESSION['idUser'];
    $mesa = $_GET['mesa'];
    $observacion = $_GET['observacion'];
    $consulta = mysqli_query($conexion, "SELECT d.*, p.nombre FROM temp_pedidos d INNER JOIN platos p ON d.id_producto = p.id WHERE d.id_usuario = $id_user");
    $total = 0;
    while ($row = mysqli_fetch_assoc($consulta)) {
        $total += $row['cantidad'] * $row['precio'];
    }
    $insertar = mysqli_query($conexion, "INSERT INTO pedidos (id_sala, num_mesa, total, observacion, id_usuario) VALUES ($id_sala, $mesa, '$total', '$observacion', $id_user)");
    $id_pedido = mysqli_insert_id($conexion);
    if ($insertar == 1) {
        //$insertarDet = 0;
        $consulta = mysqli_query($conexion, "SELECT d.*, p.nombre FROM temp_pedidos d INNER JOIN platos p ON d.id_producto = p.id WHERE d.id_usuario = $id_user");
        while ($dato = mysqli_fetch_assoc($consulta)) {
            $nombre = $dato['nombre'];
            $cantidad = $dato['cantidad'];
            $precio = $dato['precio'];
            $insertarDet = mysqli_query($conexion, "INSERT INTO detalle_pedidos (nombre, precio, cantidad, id_pedido) VALUES ('$nombre', '$precio', $cantidad, $id_pedido)");
        }
        if ($insertarDet > 0) {
            $eliminar = mysqli_query($conexion, "DELETE FROM temp_pedidos WHERE id_usuario = $id_user");
            $sala = mysqli_query($conexion, "SELECT * FROM salas WHERE id = $id_sala");
            $resultSala = mysqli_fetch_assoc($sala);
            $msg = array('mensaje' => $resultSala['mesas']);
        }
    } else {
        $msg = array('mensaje' => 'error');
    }

    echo json_encode($msg);
    die();
} else if (isset($_GET['editarPedido'])) {
    // var_dump($_GET);
    // die();

    $id_sala = $_GET['id_sala'];
    $id_user = $_SESSION['idUser'];
    $mesa = $_GET['mesa'];
    $observacion = $_GET['observacion'];
    $id_pedido = $_GET['id_pedido'];

    // Calcular el total de los productos del usuario
    $consulta = mysqli_query($conexion, "SELECT d.*, p.nombre FROM temp_pedidos d INNER JOIN platos p ON d.id_producto = p.id WHERE d.id_usuario = $id_user");
    $total = 0;
    while ($row = mysqli_fetch_assoc($consulta)) {
        $total += $row['cantidad'] * $row['precio'];
    }

    // Actualizar el pedido existente
    $actualizar = mysqli_query($conexion, "UPDATE pedidos SET id_sala = $id_sala, num_mesa = $mesa, total = '$total', observacion = '$observacion' WHERE id = $id_pedido AND id_usuario = $id_user");

    if ($actualizar == 1) {
        // Obtener los detalles actuales del pedido
        $consulta_detalle_actual = mysqli_query($conexion, "SELECT * FROM detalle_pedidos WHERE id_pedido = $id_pedido");
        $detalles_actuales = array();
        while ($detalle = mysqli_fetch_assoc($consulta_detalle_actual)) {
            $detalles_actuales[$detalle['id']] = $detalle;
        }

        // Actualizar detalles del pedido o insertarlos si no existen
        $consulta = mysqli_query($conexion, "SELECT d.*, p.nombre FROM temp_pedidos d INNER JOIN platos p ON d.id_producto = p.id WHERE d.id_usuario = $id_user");
        while ($dato = mysqli_fetch_assoc($consulta)) {
            $nombre = $dato['nombre'];
            $cantidad = $dato['cantidad'];
            $precio = $dato['precio'];

            // Buscar si este detalle ya existe en `detalle_pedidos`
            $id_detalle_actual = null;
            foreach ($detalles_actuales as $id_detalle => $detalle) {
                if ($detalle['nombre'] == $nombre) {
                    $id_detalle_actual = $id_detalle;
                    break;
                }
            }

            if ($id_detalle_actual) {
                // Actualizar detalle existente
                $actualizarDet = mysqli_query($conexion, "UPDATE detalle_pedidos SET precio = '$precio', cantidad = $cantidad WHERE id = $id_detalle_actual");
            } else {
                // Insertar nuevo detalle
                $actualizarDet = mysqli_query($conexion, "INSERT INTO detalle_pedidos (nombre, precio, cantidad, id_pedido) VALUES ('$nombre', '$precio', $cantidad, $id_pedido)");
            }
        }

        if ($actualizarDet) {
            // Eliminar productos temporales del pedido
            $eliminar = mysqli_query($conexion, "DELETE FROM temp_pedidos WHERE id_usuario = $id_user");
            $sala = mysqli_query($conexion, "SELECT * FROM salas WHERE id = $id_sala");
            $resultSala = mysqli_fetch_assoc($sala);
            $msg = array('mensaje' => $resultSala['mesas']);
        } else {
            $msg = array('mensaje' => 'Error actualizando detalles');
        }
    } else {
        $msg = array('mensaje' => 'Error actualizando pedido');
    }

    echo json_encode($msg);
    die();
} else if (isset($_GET['editarUsuario'])) {
    $idusuario = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $idusuario");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarProducto'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM platos WHERE id = $id");
    $data = mysqli_fetch_array($sql);

    $response = array(
        'id' => $data['id'],
        'nombre' => $data['nombre'],
        'precio' => $data['precio'],
        'descripcion' => $data['descripcion'],
        'foto_actual' => $data['imagen']
    );

    echo json_encode($response);
    exit;
} else if (isset($_GET['finalizarPedido'])) {
    $id_sala = $_GET['id_sala'];
    $id_user = $_SESSION['idUser'];
    $mesa = $_GET['mesa'];
    $insertar = mysqli_query($conexion, "UPDATE pedidos SET estado='FINALIZADO' WHERE id_sala=$id_sala AND num_mesa=$mesa AND estado='PENDIENTE' AND id_usuario=$id_user");
    if ($insertar) {
        $sala = mysqli_query($conexion, "SELECT * FROM salas WHERE id = $id_sala");
        $resultSala = mysqli_fetch_assoc($sala);
        $msg = array('mensaje' => $resultSala['mesas']);
    } else {
        $msg = array('mensaje' => 'error');
    }

    echo json_encode($msg);
    die();
}
if (isset($_POST['regDetalle'])) {
    $id_producto = $_POST['id'];
    $id_user = $_SESSION['idUser'];
    $consulta = mysqli_query($conexion, "SELECT * FROM temp_pedidos WHERE id_producto = $id_producto AND id_usuario = $id_user");
    $row = mysqli_fetch_assoc($consulta);
    if (empty($row)) {
        $producto = mysqli_query($conexion, "SELECT * FROM platos WHERE id = $id_producto");
        $result = mysqli_fetch_assoc($producto);
        $precio = $result['precio'];
        $query = mysqli_query($conexion, "INSERT INTO temp_pedidos (cantidad, precio, id_producto, id_usuario) VALUES (1, $precio, $id_producto, $id_user)");
    } else {
        $nueva = $row['cantidad'] + 1;
        $query = mysqli_query($conexion, "UPDATE temp_pedidos SET cantidad = $nueva WHERE id_producto = $id_producto AND id_usuario = $id_user");
    }
    if ($query) {
        $msg = "registrado";
    } else {
        $msg = "Error al ingresar";
    }
    echo json_encode($msg);
    die();
}
