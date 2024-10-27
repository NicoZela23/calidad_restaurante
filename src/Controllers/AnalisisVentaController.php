<?php
namespace Controllers;

use Models\AnalisisVentaModel;

class AnalisisVentaController {
    public function index() {
        $analisisVentaModel = new AnalisisVentaModel();
        
        $productosMasVendidos = $analisisVentaModel->getProductosMasVendidos();
        $ingresosPorFecha = $analisisVentaModel->getIngresosPorFecha();
        $ingresosPorSala = $analisisVentaModel->getIngresosPorSala();

        require_once '../src/Views/analisisVentaView.php';
    }
}
