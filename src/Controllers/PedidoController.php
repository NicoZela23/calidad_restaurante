<?php
namespace Controllers;

use Models\PedidoModel;
use Models\PlatoModel;

class PedidoController
{
    private $pedidoModel;
    private $platoModel;
    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->platoModel = new PlatoModel();
    }
    public function index()
    {
        $platos = $this->platoModel->getAllPlatos();
        $this->pedidoModel->deleteTempPedido();
        require_once '../src/Views/ventaPedido.php';
    }

    public function createPedido()
    {
        $alert = "";
        $id_sala = $_POST['id_sala'];
        $mesa = $_POST['num_mesa'];
        $observacion = '';
        $id_usuario = '1';
        $total = 0;
        $temp_Pedidos = $this->pedidoModel->getAllTempPedidos();

        if (empty($id_sala) || empty($mesa)) {
            $alert = 'No se añadieron platos al pedido, por favor seleccione al menos un plato';
        } else {
            foreach ($temp_Pedidos as $temp_pedido) {
                $total += $temp_pedido['precio'] * $temp_pedido['cantidad'];
            }

            $id_pedido = $this->pedidoModel->insertPlato($id_sala, $mesa, $total, $observacion, $id_usuario);
            if (!$id_pedido) {
                $alert = 'Error al registrar el pedido principal.';
            } else {
                foreach ($temp_Pedidos as $temp_pedido) {
                    $result = $this->pedidoModel->insertDetallePedido($temp_pedido['nombre'], $temp_pedido['precio'], $temp_pedido['cantidad'], $id_pedido);
                    if (!$result) {
                        $alert = 'Error al registrar detalles del pedido';
                        break;
                    }
                }
                $alert = 'Pedido registrado';
            }
            $_SESSION['alert'] = $alert;
            header('Location: index.php?controller=SalaController&action=nuevaVenta');
            exit;
        }
    }

    public function edit()
    {
        $id_sala = $_POST['id_sala'];
        $num_mesa = $_POST['num_mesa'];
        $platos = $this->platoModel->getAllPlatos();
        $pedidos = $this->pedidoModel->getPedidoById($id_sala, $num_mesa);
        $this->pedidoModel->deleteTempPedido();
        foreach ($pedidos as $pedido) {
            $this->pedidoModel->insertTempPedido($pedido['cantidad'], $pedido['precio'], $pedido['plato_id']);
        }
        require_once '../src/Views/ventaPedidoEdit.php';
    }

    public function editPedido(){
        $alert = "";
        $id_sala = $_POST['id_sala'];
        $mesa = $_POST['num_mesa'];
        $total = 0;
        $temp_Pedidos = $this->pedidoModel->getAllTempPedidos();

        if (mysqli_num_rows($temp_Pedidos) === 0) {
            $alert = 'No se añadieron platos al pedido, por favor seleccione al menos un plato';
            $_SESSION['alert'] = $alert;
            header('Location: index.php?controller=SalaController&action=nuevaVenta');
            exit;
        } else {
            foreach ($temp_Pedidos as $temp_pedido) {
                $total += $temp_pedido['precio'] * $temp_pedido['cantidad'];
            }

            $id_pedido = $this->pedidoModel->updatePlato($id_sala, $mesa, $total);
            if (!$id_pedido) {
                $alert = 'Error al actualizar el pedido.';
            } else {
                foreach ($temp_Pedidos as $temp_pedido) {
                    $this->pedidoModel->updateDetallePedido($temp_pedido['nombre'], $temp_pedido['precio'], $temp_pedido['cantidad'], $id_pedido);
                }
                $this->pedidoModel->deleteLeftoverDetallePedido($id_pedido);
                $alert = "Pedido actualizado: Sala = $id_sala - Mesa = $mesa";
            }
            $_SESSION['alert'] = $alert;
            header('Location: index.php?controller=SalaController&action=nuevaVenta');
            exit;
        }
    }

    public function finishPedido(){
        $alert = "";
        $id_sala = $_POST['id_sala'];
        $mesa = $_POST['num_mesa'];
        $result = $this->pedidoModel->finishPedidoState($id_sala, $mesa);
        if(empty($result)) {
            $alert = 'Error al finalizar el pedido.';
        } else {
            $alert = 'Pedido finalizado';
        }
        $_SESSION['alert'] = $alert;
        header('Location: index.php?controller=SalaController&action=nuevaVenta');
        exit;
    }
}