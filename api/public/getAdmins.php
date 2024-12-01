<?php

require_once '../autoload.php';

use Src\Controllers\AdminController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$controller = new AdminController();
echo $controller->getAdmins();
