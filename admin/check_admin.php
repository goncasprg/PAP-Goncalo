<?php

// Verificar se o utilizador está autenticado e se é administrador
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== 'admin') {
    header("Location: ../../index.php"); // Redireciona para a página inicial se não for admin
    exit();
}
?>