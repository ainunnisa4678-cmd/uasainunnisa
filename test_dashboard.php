<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config/Config.php';
require_once 'helpers/Security.php';
require_once 'controllers/BaseController.php';
require_once 'controllers/DashboardController.php';

session_start();
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';

echo "Instantiating DashboardController\n";
$controller = new DashboardController();
echo "Calling index\n";
$controller->index();
echo "Done\n";
