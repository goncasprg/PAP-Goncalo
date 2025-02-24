<?php
session_start();
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../index.php"); // Redireciona para a página principal se não for admin
    exit();
}
?>
