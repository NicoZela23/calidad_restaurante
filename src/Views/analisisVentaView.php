<?php
include_once "../src/Core/header.php";
?>

<div class="container mt-3">
    <h2 class="text-center mb-4">Análisis de Ventas</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Productos más Vendidos</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Total Vendido</th>
                            <th>Total Ingreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productosMasVendidos as $producto): ?>
                            <tr>
                                <td><?= $producto['nombre'] ?></td>
                                <td><?= $producto['total_vendido'] ?></td>
                                <td><?= $producto['total_ingreso'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Ingresos por Fecha</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Ingreso Diario</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ingresosPorFecha as $ingreso): ?>
                                    <tr>
                                        <td><?= $ingreso['fecha'] ?></td>
                                        <td><?= $ingreso['ingreso_diario'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Ingresos por Sala</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sala</th>
                                    <th>Ingreso Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ingresosPorSala as $ingreso): ?>
                                    <tr>
                                        <td><?= $ingreso['sala'] ?></td>
                                        <td><?= $ingreso['ingreso_sala'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "../src/Core/footer.php"; ?>
