<?php

require_once '../autoload.php';

use Src\Controllers\AuthController;

header("Content-Type: application/json");

$auth = new AuthController();
echo $auth->logout();
