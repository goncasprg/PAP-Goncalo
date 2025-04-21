<?php
session_start();
require_once '../assets/php/db.php';

if (!isset($_SESSION['user_id'])) {
    // Utilizador não está autenticado, redireciona para login
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;
    $comment = trim($_POST['comment'] ?? '');

    if ($rating && !empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, rating, comment, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$user_id, $rating, $comment]);

        // Redireciona para a página principal
        header("Location: ../index.php");
        exit;
    } else {
        // Campos obrigatórios em falta
        header("Location: ../index.php?error=missing_fields");
        exit;
    }
} else {
    // Requisição inválida
    header("Location: ../index.php");
    exit;
}
