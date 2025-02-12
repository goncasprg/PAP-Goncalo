<?php
require '../php/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = getPDO();

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Busca o utilizador na BD
    $stmt = $pdo->prepare("SELECT id, first_name, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["first_name"];
        $_SESSION["user_role"] = $user["role"];

        echo "Login bem-sucedido!";
    } else {
        echo "Email ou senha incorretos!";
    }
}
?>
