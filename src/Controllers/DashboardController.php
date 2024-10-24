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
    }
}
