<?php
 include_once "../src/Core/header.php";
 ?>

<div class="card">
    <div class="card-body">
        <form action="" method="post" autocomplete="off" id="formulario">
            <?php if (!empty($alert)): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <?php echo $alert; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <!-- Form Fields Here -->
            <!-- Name, Email, Role, Password -->

            <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
            <input type="button" value="Nuevo" class="btn btn-success" id="btnNuevo" onclick="limpiar()">
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered mt-2" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['idusuario']; ?></td>
                    <td><?php echo $user['nombre']; ?></td>
                    <td><?php echo $user['correo']; ?></td>
                    <td><?php echo $user['rol'] == 1 ? "Administrador" : ($user['rol'] == 2 ? "Cocinero" : "Mozo"); ?></td>
                    <td>
                        <a href="#" onclick="editarUsuario(<?php echo $user['idusuario']; ?>)" class="btn btn-success"><i class="fas fa-edit"></i></a>
                        <form action="eliminar.php?id=<?php echo $user['idusuario']; ?>&accion=usuarios" method="post" class="confirmar d-inline">
                            <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once "../src/Core/footer.php"; ?>
