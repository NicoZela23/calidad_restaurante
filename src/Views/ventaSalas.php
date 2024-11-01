<?php
include_once "../src/Core/header.php";
?>
<div class="card">
    <div class="card-header text-center">
        Salas
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            foreach ($salas as $sala):
                ?>
                <div class="col-md-3 shadow-lg">
                    <div class="col-12">
                        <img src="http://localhost/calidad_restaurante/assets/img/salas.jpg" class="product-image"
                            alt="Product Image">
                    </div>
                    <h6 class="my-3 text-center"><span class="badge badge-info"><?php echo $sala['nombre']; ?></span></h6>

                    <div class="mt-4">
                        <form action="index.php?controller=SalaController&action=showMesas" method="POST">
                            <input type="hidden" name="id" value="<?= $sala['id']; ?>">
                            <button type="submit" class="btn btn-primary btn-block btn-flat"> <i class="far fa-eye mr-2"></i>Mesas</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php include_once "../src/Core/footer.php"; ?>