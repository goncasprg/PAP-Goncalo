<?php
require '../assets/php/db.php';

if (isset($_GET["brand"])) {
    $brand = $_GET["brand"];

    $pdo = getPDO();
    $sql = "SELECT DISTINCT model FROM cars WHERE brand = :brand ORDER BY model ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":brand", $brand, PDO::PARAM_STR);
    $stmt->execute();

    $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Transformar o array para conter apenas os nomes dos modelos como value e text
    $models = array_map(function ($model) {
        return ['model' => $model['model']];
    }, $models);
    echo json_encode($models);
}
?>