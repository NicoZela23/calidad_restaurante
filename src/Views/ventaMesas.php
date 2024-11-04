<?php
include_once "../src/Core/header.php";
?>
<div class="card">
    <div class="card-header text-center">
        Mesas
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            $lista_pendientes = [];

            foreach ($sala_pedidos as $sala_pedido):
                if ($sala_pedido['estado'] == 'PENDIENTE') {
                    $lista_pendientes[] = [
                        'num_mesa' => $sala_pedido['num_mesa'],
                        'id' => $sala_pedido['id']
                    ];
                }
            endforeach;
            $numMesas = $sala_pedidos[1]['mesas'];
            for ($i = 1; $i <= $numMesas; $i++) {

                $is_pending = false;
                foreach ($lista_pendientes as $pedido) {
                    if ($pedido['num_mesa'] == $i) {
                        $is_pending = true;
                        $pedido_id = $pedido['id'];
                        $num_mesa = $pedido['num_mesa'];
                        break;
                    }
                }
                ?>
                <div class="col-md-3">
                    <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-<?php echo $is_pending ? 'danger' : 'success' ?>">
                            <h3 class="widget-user-username">MESA</h3>
                            <h5 class="widget-user-desc"><?php echo $i; ?></h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2"
                                src="http://localhost/calidad_restaurante/assets/img/mesa.jpg" alt="User Avatar">
                        </div>

                        <div class="card-footer">
                            <div class="description-block">
                                <?php if (!$is_pending): ?>
                                    <form action="index.php?controller=PedidoController&action=index" method="POST">
                                        <input type="hidden" name="id_sala" value="<?= $id_sala ?>">
                                        <input type="hidden" name="num_mesa" value="<?= $i ?>">
                                        <button type="submit" class="btn btn-outline-info">Hacer Pedido</button>
                                    </form>
                                <?php else: ?>
                                    <form action="index.php?controller=SalaController&action=showMesas" method="POST">
                                        <input type="hidden" name="id_sala" value="<?= $id_sala ?>">
                                        <input type="hidden" name="num_mesa" value="<?= $i ?>">
                                        <button type="submit" class="btn btn-outline-success">Editar Pedido</button>
                                    </form>
                                    <form action="index.php?controller=SalaController&action=showMesas" method="POST">
                                        <input type="hidden" name="id_sala" value="<?= $id_sala ?>">
                                        <input type="hidden" name="num_mesa" value="<?= $i ?>">
                                        <button type="submit" class="btn btn-outline-success">Finalizar</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php include_once "../src/Core/footer.php"; ?>