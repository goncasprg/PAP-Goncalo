<?php
session_start();

// Verificar se a sessão do utilizador está iniciada e se é admin
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirecionar para o login caso não seja admin
    header("Location: ../login/index.php");
    exit;
}
?>
