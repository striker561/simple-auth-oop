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

        $token = $_POST['token'] ?? null;

        if (!$token) {    
            $_SESSION['message'] = "Invalid or missing token.";
            header("Location: reset-password.php");
            exit;
        }

        $hashed_token = hash('sha256', $token);

        $result = $authController->resetPassword($_POST, $hashed_token);

        if ($result === true) {
            $_SESSION['message'] = "Password reset successful. You can now log in with your new password.";
            header("Location: login.php");
        } else {
            $_SESSION['message'] = $result ?? "Password reset failed. Please try again.";
            header("Location: reset-password.php?token=" . urlencode($token));
        }

        exit;
}