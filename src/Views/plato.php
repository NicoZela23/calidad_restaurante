<!-- platos.php -->
<?php
include_once "../src/Core/header.php";
?>
<div class="card shadow-lg">
    <div class="card-body">
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-info">
                <?= $_SESSION['alert'];
                unset($_SESSION['alert']); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=PlatoController&action=savePlato" method="post" autocomplete="off"
            enctype="multipart/form-data">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="foto_actual" name="foto_actual">
                        <label for="plato" class=" text-dark font-weight-bold">Plato</label>
                        <input type="text" placeholder="Ingrese nombre del plato" name="plato" id="plato"
                            class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="precio" class=" text-dark font-weight-bold">Precio</label>
                        <input type="number" placeholder="Ingrese precio" class="form-control" name="precio" id="precio"
                            step="0.01" min="0" max="99999.99" pattern="^\d{1,8}(\.\d{1,2})?$"
                            title="Please enter a valid price with up to 8 digits and 2 decimal places." required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="foto" class=" text-dark font-weight-bold">Foto (512px - 512px)</label>
                        <input type="file" class="form-control" name="foto" id="foto">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="descripcion" class="text-dark font-weight-bold">Descripción</label>
                        <textarea name="descripcion"name="descripcion" id="descripcion" placeholder="Ingrese una descripción del plato"
                            class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Acciones</label> <br>
                    <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                    <input type="button" value="Limpiar" onclick="limpiar()" class="btn btn-success" id="btnNuevo">
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plato</th>
                    <th>Precio</th>
                    <th class="col-5">Descripción</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($platos as $plato) { ?>
                    <tr>
                        <td><?php echo $plato['id']; ?></td>
                        <td><?php echo $plato['nombre']; ?></td>
                        <td><?php echo $plato['precio']; ?></td>
                        <td><?php echo $plato['descripcion']; ?></td>
                        <td><img class="img-thumbnail"
                                src="<?php echo ($plato['imagen'] == null) ? 'http://localhost/calidad_restaurante/assets/img/default.png' : $plato['imagen']; ?>"
                                alt="" width="100"></td>
                        <td>
                            <button type="button" class="btn btn-primary"
                                onclick="editarPlato('<?= $plato['id']; ?>', '<?= $plato['nombre']; ?>', '<?= $plato['precio']; ?>', '<?= $plato['descripcion']; ?>')">Editar</button>


                            <form action="index.php?controller=PlatoController&action=deletePlato" method="post"
                                class="confirmar d-inline">
                                <input type="hidden" name="id" value="<?= $plato['id']; ?>">
                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once "../src/Core/footer.php"; ?>