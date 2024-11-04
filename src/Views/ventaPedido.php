<?php
include_once "../src/Core/header.php";
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Platos
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-right-tabContent">
                    <div class="tab-pane fade show active" id="vert-tabs-right-home" role="tabpanel"
                        aria-labelledby="vert-tabs-right-home-tab">
                        <input type="hidden" id="id_sala" value="<?php echo $_POST['id_sala'] ?>">
                        <input type="hidden" id="mesa" value="<?php echo $_POST['num_mesa'] ?>">
                        <div class="row">
                            <?php
                            foreach ($platos as $plato): ?>
                                <div class="col-md-3">
                                    <div class="col-12">
                                        <img src="<?php echo ($plato['imagen'] == null) ? 'http://localhost/calidad_restaurante/assets/img/default.png' : $data['imagen']; ?>"
                                            class="product-image" alt="Product Image">
                                    </div>
                                    <h6 class="my-3"><?php echo $plato['nombre']; ?></h6>
                                    <div class="bg-light py-2 px-3 mt-2 rounded">
                                        <p class="text-muted mb-0">
                                            <?php echo $plato['descripcion']; ?>
                                        </p>
                                    </div>
                                    <div class="bg-gray py-2 px-3 mt-4">
                                        <h2 class="mb-0">
                                            $<?php echo $plato['precio']; ?>
                                        </h2>
                                    </div>

                                    <div class="mt-4">
                                        <a class="btn btn-primary btn-block btn-flat addDetalle" href="#"
                                            data-id="<?php echo $plato['id']; ?>">
                                            <i class="fas fa-cart-plus mr-2"></i>
                                            Agregar
                                        </a>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pedido" role="tabpanel" aria-labelledby="pedido-tab">
                        <div class="row" id="detalle_pedido"></div>
                        <hr>
                        <div class="form-group">
                            <label for="observacion">Observaciones</label>
                            <textarea id="observacion" class="form-control" rows="3"
                                placeholder="Observaciones"></textarea>
                        </div>
                        <form action="index.php?controller=PedidoController&action=createPedido" method="POST">
                            <input type="hidden" name="id_sala" value="<?php echo $_POST['id_sala'] ?>">
                            <input type="hidden" name="num_mesa" value="<?php echo $_POST['num_mesa'] ?>">
                            <button type="submit" class="btn btn-primary">Realizar Pedido</button>
                        </form>
                        <!-- <button class="btn btn-primary" type="button" id="realizar_pedido">Realizar pedido</button> -->
                    </div>
                </div>
            </div>
            <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs nav-tabs-right h-100" id="vert-tabs-right-tab" role="tablist"
                    aria-orientation="vertical">
                    <a class="nav-link active" id="vert-tabs-right-home-tab" data-toggle="pill"
                        href="#vert-tabs-right-home" role="tab" aria-controls="vert-tabs-right-home"
                        aria-selected="true">Platos</a>
                    <a class="nav-link" id="pedido-tab" data-toggle="pill" href="#pedido" role="tab"
                        aria-controls="pedido" aria-selected="false">Pedido</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once "../src/Core/footer.php"; ?>