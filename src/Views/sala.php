<?php
include_once "../src/Core/header.php";
?>

<div class="card">
    <div class="card-body">
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-info">
                <?= $_SESSION['alert'];
                unset($_SESSION['alert']); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=SalaController&action=saveSala" method="post" id="formulario">
            <input type="hidden" name="id" id="id">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="mesas">Mesas</label>
                        <input type="number" name="mesas" id="mesas" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-5 text-center">
                    <label for="">Acciones</label> <br>
                    <input type="submit" value="Registrar" class="btn btn-primary" id="registerButton">
                    <button type="button" onclick="limpiar()" class="btn btn-success">Limpiar</button>
                </div>
            </div>
        </form>

        <div class="table-responsive mt-4">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Mesas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salas as $sala): ?>
                        <tr>
                            <td><?= $sala['id']; ?></td>
                            <td><?= $sala['nombre']; ?></td>
                            <td><?= $sala['mesas']; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary"
                                    onclick="editarSala('<?= $sala['id']; ?>', '<?= $sala['nombre']; ?>', '<?= $sala['mesas']; ?>')">Editar</button>

                                <form action="index.php?controller=SalaController&action=deleteSala" method="post"
                                    class="d-inline confirmar">
                                    <input type="hidden" name="id" value="<?= $sala['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once "../src/Core/footer.php"; ?>