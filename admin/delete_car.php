<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

if (!isset($_GET["id"])) {
    die("ID do carro não especificado.");
}

$pdo = getPDO();
$id = $_GET["id"];

$stmt = $pdo->prepare("DELETE FROM cars WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit();
?>
