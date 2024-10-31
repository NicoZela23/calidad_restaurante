<?php
namespace Controllers;

use Models\PlatoModel;

class PlatoController {
    private $platoModel;

    public function __construct() {
        $this->platoModel = new PlatoModel();
    }

    public function index() {
        if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
            $data['platos'] = $this->platoModel->getAllPlatos();
            $platos = $data['platos'];
            require_once '../src/Views/plato.php';
        } else {
            header('Location: permisos.php');
        }
    }
    

    public function savePlato() {
        if (!empty($_POST)) {
            $alert = "";
            $id = $_POST['id'];
            $plato = $_POST['plato'];
            $precio = $_POST['precio'];
            $descripcion = $_POST['descripcion'];
            $foto_actual = $_POST['foto_actual'];
            $foto = $_FILES['foto'];
            $fecha = date('YmdHis');
            $nombre = (!empty($foto['name'])) ? '../assets/img/platos/' . $fecha . '.jpg' : $foto_actual;

            if (empty($plato) || empty($precio) || $precio < 0 || empty($descripcion)) {
                $alert = 'Todos los campos son obligatorios';
            } else {
                if (empty($id)) {
                    // Add new plato
                    if ($this->platoModel->getPlatoByName($plato)) {
                        $alert = 'El plato ya existe';
                    } else {
                        $this->platoModel->insertPlato($plato, $precio, $nombre, $descripcion);
                        if (!empty($foto['name'])) {
                            move_uploaded_file($foto['tmp_name'], $nombre);
                        }
                        $alert = 'Plato registrado';
                    }
                } else {
                    $this->platoModel->updatePlato($id, $plato, $precio, $nombre, $descripcion);
                    if (!empty($foto['name'])) {
                        move_uploaded_file($foto['tmp_name'], $nombre);
                    }
                    $alert = 'Plato modificado';
                }
            }
        }

        $this->index();
    }
}
