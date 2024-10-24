<?php

namespace Controllers;

use Core\Database;
use Models\UserModel;

class AuthController {
    public function login() {
        session_start();

        if (!empty($_SESSION['active'])) {
            header('Location: /src/Views/dashboard.php');
            exit();
        }

        $alert = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['correo'] ?? '';
            $password = $_POST['pass'] ?? '';

            if (empty($email) || empty($password)) {
                $alert = $this->createAlert('warning', 'Ingrese correo y contraseña');
            } else {
                $userModel = new UserModel();
                $user = $userModel->getUserByEmailAndPassword($email, $password);

                if ($user) {
                    $_SESSION['active'] = true;
                    $_SESSION['idUser'] = $user['id'];
                    $_SESSION['nombre'] = $user['nombre'];
                    $_SESSION['rol'] = $user['rol'];
                    header('Location: /src/Views/dashboard.php');
                    exit();
                } else {
                    $alert = $this->createAlert('danger', 'Contraseña incorrecta');
                    session_destroy();
                }
            }
        }

        require_once '../src/Views/login.php';
    }

    private function createAlert($type, $message) {
        return '
            <div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
                ' . $message . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
    }
}
