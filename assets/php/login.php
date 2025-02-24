<?php
session_start();
require_once 'db.php'; // Conectar à base de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;

    if (!$email || !$password) {
        die("Erro: Preencha todos os campos.");
    }

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT id, first_name, email, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            // Criar sessão
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["first_name"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_role"] = $user["role"];

            // ✅ Se for admin, redireciona para o dashboard
            if ($user["role"] === "admin") {
                header("Location: ../../admin/dashboard.php");
            } else {
                header("Location: ../../index.php");
            }
            exit();
        } else {
            echo "Erro: Email ou palavra-passe incorretos.";
        }
    } catch (PDOException $e) {
        die("Erro ao fazer login: " . $e->getMessage());
    }
}
?>
