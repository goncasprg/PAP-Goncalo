<?php
session_start();
session_destroy();
header("Location: ../html/login.php"); // Redireciona para a página de login
exit();
?>
