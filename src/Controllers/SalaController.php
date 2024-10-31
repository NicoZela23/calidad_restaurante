<?php

namespace Controllers;

use Models\SalaModel;

class SalaController
{
    private $salaModel;

    public function __construct()
    {
        $this->salaModel = new SalaModel();
    }

    public function index()
    {
        if ($_SESSION['rol'] != 1) {
            header('Location: permisos.php');
            exit;
        }
        $salas = $this->salaModel->getAllSalas();
        include "../src/Views/sala.php";
    }

    public function saveSala()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $alert = '';
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $mesas = $_POST['mesas'];

            if (empty($nombre) || empty($mesas)) {
                $alert = 'Todos los campos son obligatorios';
            } else {
                if (empty($id)) {
                    if ($this->salaModel->getSalaByName($nombre)) {
                        $alert = 'La sala ya existe';
                    } else {
                        $this->salaModel->insertSala($nombre, $mesas);
                        $alert = 'Sala registrada';
                    }
                } else {
                    $this->salaModel->updateSala($id, $nombre, $mesas);
                    $alert = 'Sala modificada';
                }
            }

            $_SESSION['alert'] = $alert;
            header('Location: index.php?controller=SalaController&action=index');
            exit;
        }
    }
    public function deleteSala()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $this->salaModel->deleteSala($id);
            $alert = 'Sala eliminada';
            $_SESSION['alert'] = $alert;
            header('Location: index.php?controller=SalaController&action=index');
        }
    }
}