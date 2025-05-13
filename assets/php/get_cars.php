<?php
header('Content-Type: application/json');
include "db.php"; // Certifica-te de que o caminho está correto

try {
    // Obter parâmetros de filtro da query string
    $brand = isset($_GET['brand']) ? $_GET['brand'] : '';
    $model = isset($_GET['model']) ? $_GET['model'] : '';
    $transmission = isset($_GET['transmission']) ? $_GET['transmission'] : '';

    // Construir a consulta SQL base
    $sql = "
        SELECT 
            c.id, 
            c.brand, 
            c.model, 
            c.engine_capacity, 
            c.fuel_type, 
            c.registration_year, 
            c.mileage, 
            c.transmission, 
            c.price, 
            (SELECT ci.image_url 
             FROM car_images ci 
             WHERE ci.car_id = c.id 
             LIMIT 1) AS image_url
        FROM 
            cars c
        WHERE 1=1"; // WHERE 1=1 permite adicionar condições dinamicamente

    // Array para os parâmetros da consulta
    $params = [];

    // Adicionar condições de filtro se os parâmetros existirem
    if ($brand) {
        $sql .= " AND c.brand = :brand";
        $params[':brand'] = $brand;
    }
    if ($model) {
        $sql .= " AND c.model = :model";
        $params[':model'] = $model;
    }
    if ($transmission) {
        $sql .= " AND c.transmission = :transmission";
        $params[':transmission'] = $transmission;
    }

    // Preparar e executar a consulta
    $stmt = getPDO()->prepare($sql);
    $stmt->execute($params);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados como JSON
    echo json_encode($cars);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>