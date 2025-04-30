<?php
session_start();
require_once '../php/db.php';

if (!isset($_SESSION['user_id'])) {
    // Utilizador não autenticado, redireciona para login
    header("Location: ../html/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;
    $comment = trim($_POST['comment'] ?? '');

    if ($rating && !empty($comment)) {
        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("INSERT INTO stand_reviews (user_id, rating, comment, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$user_id, $rating, $comment]);

            // Redireciona para a página principal com sucesso
            header("Location: ../../index.php?success=1");
            exit;
        } catch (PDOException $e) {
            // Em caso de erro, redireciona com uma mensagem de erro
            header("Location: ../../index.php?error=database_error");
            exit;
        }
    } else {
        // Campos obrigatórios em falta
        header("Location: ../../index.php?error=missing_fields");
        exit;
    }
} else {
    // Requisição inválida
    header("Location: ../../index.php");
    exit;
}
