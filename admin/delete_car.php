<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

if (!isset($_GET["id"])) {
    die("ID do carro não especificado.");
}

$pdo = getPDO();
$id = $_GET["id"];

try {
    $pdo->beginTransaction();

    // Apagar imagens associadas ao carro
    $stmt = $pdo->prepare("DELETE FROM car_images WHERE car_id = ?");
    $stmt->execute([$id]);

    // Agora podemos apagar o carro
    $stmt = $pdo->prepare("DELETE FROM cars WHERE id = ?");
    $stmt->execute([$id]);

    $pdo->commit();

    header("Location: index.php");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Erro ao apagar carro: " . $e->getMessage());
}
?>
