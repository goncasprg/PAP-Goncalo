<?php
require '../assets/php/db.php';

if (isset($_GET["brand"])) {
    $brand = $_GET["brand"];

    $pdo = getPDO();
    $sql = "SELECT id, model FROM models WHERE brand = :brand ORDER BY model ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":brand", $brand, PDO::PARAM_STR);
    $stmt->execute();

    $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($models);
}
?>