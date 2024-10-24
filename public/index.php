<?php

require_once '../vendor/autoload.php';

use Controllers\AuthController;

$authController = new AuthController();
$authController->login();