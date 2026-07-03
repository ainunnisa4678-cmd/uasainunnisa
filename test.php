<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';
$_SESSION['USER_AGENT'] = md5('test');
$_SERVER['HTTP_USER_AGENT'] = 'test';
$_GET['url'] = 'dashboard';

ob_start();
try {
    include 'index.php';
} catch (\Throwable $e) {
    echo "ERROR CAUGHT: " . $e->getMessage();
}
$output = ob_get_clean();
file_put_contents('test_output.txt', $output);
echo "Done";
