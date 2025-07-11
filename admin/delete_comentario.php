<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

// Aceita tanto POST quanto GET para compatibilidade
$id = $_POST['id'] ?? $_GET['id'] ?? null;
if (!$id) {
    die("ID do comentário não especificado.");
}

$pdo = getPDO();
try {
    $stmt = $pdo->prepare("DELETE FROM stand_reviews WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: comentarios.php");
    exit();
} catch (Exception $e) {
    die("Erro ao apagar comentário: " . $e->getMessage());
}
?>
