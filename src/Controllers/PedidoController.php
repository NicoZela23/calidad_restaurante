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
        require_once '../src/Views/ventaPedido.php';
    }

    public function createPedido()
    {
        // if (!empty($_POST)) {
            $alert = "";
            $id_sala = $_POST['id_sala'];
            $mesa = $_POST['num_mesa'];
            $observacion = ''; // Example value; update as needed
            $id_usuario = '1'; // Example value; update as needed
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
        // }
        // header('Location: index.php?controller=AnalisisVentaController&action=index');
        // exit;
    }

}