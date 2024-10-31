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
}