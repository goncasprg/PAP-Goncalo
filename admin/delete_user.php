<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

// Accept both POST and GET for compatibility
$id = $_POST['id'] ?? $_GET['id'] ?? null;
if (!$id) {
    die("ID do utilizador não especificado.");
}

$pdo = getPDO();
try {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: users.php");
    exit();
} catch (Exception $e) {
    die("Erro ao apagar utilizador: " . $e->getMessage());
}
?>
