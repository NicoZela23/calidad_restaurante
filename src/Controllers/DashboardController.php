<?php
namespace Controllers;

use Models\DashboardModel;

class DashboardController {
    public function index() {
        $dashboardModel = new DashboardModel();

        $totalSalas = $dashboardModel->getTotalSalas();
        $totalPlatos = $dashboardModel->getTotalPlatos();
        $totalUsuarios = $dashboardModel->getTotalUsuarios();
        $totalPedidos = $dashboardModel->getTotalPedidos();
        $totalVentas = $dashboardModel->getTotalVentas();

        require_once '../src/Views/dashboard.php';
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = $_GET['controller'] ?? '';
    $action = $_GET['action'] ?? '';

    if ($controller === 'AnalisisVentaController' && $action === 'index') {
        $analisisVentaController = new AnalisisVentaController();
        $analisisVentaController->index();
        exit();
    }

    if ($controller === 'PlatoController' && $action === 'index') {
        $platoController = new PlatoController();
        $platoController->index();
        exit();
    }

    if ($controller === 'SalaController' && $action === 'index') {
        $salaController = new SalaController();
        $salaController->index();
        exit();
    }

    if ($controller === 'UsuarioController' && $action === 'index') {
        $usuarioController = new UsuarioController();
        $usuarioController->index();
        exit();
    }

    if ($controller === 'SalaController' && $action === 'nuevaVenta') {
        $salaController = new SalaController();
        $salaController->newVenta();
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = $_GET['controller'] ?? '';
    $action = $_GET['action'] ?? '';

    if ($controller === 'SalaController' && $action === 'saveSala') {
        $salaController = new SalaController();
        $salaController->saveSala();
        exit();
    }
    if($controller === 'SalaController' && $action === 'deleteSala') {
        $salaController = new SalaController();
        $salaController->deleteSala();
        exit();
    }

    if($controller === 'PlatoController' && $action === 'savePlato') {
        $platoController = new PlatoController();
        $platoController->savePlato();
        exit();
    }
    if($controller === 'PlatoController' && $action === 'deletePlato') {
        $salaController = new PlatoController();
        $salaController->deletePlato();
        exit();
    }
    if ($controller === 'SalaController'&& $action === 'showMesas') {
        $salaController = new SalaController();
        $salaController->showMesas();
        exit();
    }

    if ($controller === 'PedidoController' && $action === 'index') {
        $pedidoController = new PedidoController();
        $pedidoController->index();
        exit();
    }

    if ($controller === 'PedidoController' && $action === 'createPedido') {
        $pedidoController = new PedidoController();
        $pedidoController->createPedido();
        exit();
    }
    
    if ($controller === 'PedidoController' && $action === 'edit') {
        $pedidoController = new PedidoController();
        $pedidoController->edit();
        exit();
    }

    if ($controller === 'PedidoController' && $action === 'editPedido') {
        $pedidoController = new PedidoController();
        $pedidoController->editPedido();
        exit();
    }
    
    if ($controller === 'PedidoController' && $action === 'finish') {
        $pedidoController = new PedidoController();
        $pedidoController->finishPedido();
        exit();
    }
}
