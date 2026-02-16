<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';  
require_once '../services/AuthService.php';
require_once '../controllers/AuthController.php';

$db = (new Database ()) ->connect();
$user = new User($db);
$authService = new AuthService($user);
$authController = new AuthController($authService);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $result = $authController->recoverPassword($_POST);

        if ($result['success'] === true) {
            $token = $result['token'];
            header("Location: reset-password.php?token=" . urlencode($token));
            exit;
        }

        $_SESSION['message'] = $result['message'];
        header("Location: recover-password.php");

        exit;
}