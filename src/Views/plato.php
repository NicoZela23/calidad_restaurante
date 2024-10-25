<!-- platos.php -->
<?php include_once "includes/header.php"; ?>
<div class="card shadow-lg">
    <div class="card-body">
        <form action="plato_save" method="post" autocomplete="off" enctype="multipart/form-data">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="foto_actual" name="foto_actual">
                        <label for="plato" class=" text-dark font-weight-bold">Plato</label>
                        <input type="text" placeholder="Ingrese nombre del plato" name="plato" id="plato" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="precio" class=" text-dark font-weight-bold">Precio</label>
                        <input type="text" placeholder="Ingrese precio" class="form-control" name="precio" id="precio">
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
                        <textarea name="descripcion" id="descripcion" placeholder="Ingrese una descripción del plato" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Acciones</label> <br>
                    <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                    <input type="button" value="Nuevo" onclick="limpiar()" class="btn btn-success" id="btnNuevo">
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plato</th>
                    <th>Precio</th>
                    <th>Descripción</th>
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
                    <td><img class="img-thumbnail" src="<?php echo ($plato['imagen'] == null) ? '../assets/img/default.png' : $plato['imagen']; ?>" alt="" width="100"></td>
                    <td>
                        <a href="#" onclick="editarPlato(<?php echo $plato['id']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                        <form action="plato_eliminar?id=<?php echo $plato['id']; ?>" method="post" class="confirmar d-inline">
                            <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i></button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>
