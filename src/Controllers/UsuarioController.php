<?php

namespace Controllers;

use Models\UsuarioModel;

class UsuarioController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UsuarioModel();
    }

    public function index() {
        if ($_SESSION['rol'] != 1) {
            header('Location: permisos.php');
            exit;
        }
        
        $users = $this->userModel->getAllUsers();
        include "../src/Views/usuario.php";
    }

    public function saveUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $alert = '';
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $rol = $_POST['rol'];
            $pass = isset($_POST['pass']) ? $_POST['pass'] : null;

            if (empty($nombre) || empty($correo) || empty($rol)) {
                $alert = 'Todos los campos son obligatorios';
            } else {
                if (empty($id)) { // New user
                    if (empty($pass)) {
                        $alert = 'La contraseña es requerida';
                    } else {
                        if ($this->userModel->getUserByEmail($correo)) {
                            $alert = 'El correo ya existe';
                        } else {
                            $this->userModel->insertUser($nombre, $correo, $rol, md5($pass));
                            $alert = 'Usuario registrado';
                        }
                    }
                } else { // Update existing user
                    $this->userModel->updateUser($id, $nombre, $correo, $rol);
                    $alert = 'Usuario modificado';
                }
            }

            $_SESSION['alert'] = $alert;
            header('Location: /users');
            exit;
        }
    }
}
