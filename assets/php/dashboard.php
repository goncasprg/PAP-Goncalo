<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html"); // Redireciona se não estiver autenticado
    exit();
}

echo "Bem-vindo, " . $_SESSION["user_name"] . "!";
echo "<br><a href='logout.php'>Sair</a>";
?>
