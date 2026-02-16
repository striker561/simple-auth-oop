<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../services/AuthService.php';
require_once '../controllers/AuthController.php';

$db = (new Database())->connect();
$user = new User($db);
$authService = new AuthService($user);
$authController = new AuthController($authService);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $authController->register($_POST);

    if ($result === true){
        $_SESSION['message'] = "Registration successful!";
        header("Location: login.php?message=registration_success");
        exit;
    }
    if($result !== true){
        $_SESSION['message'] = $result;
        header("Location: register.php");
        exit;
    } 
}
?>



