<?php
header('Content-Type: application/json');
include "db.php";

try {
    // Obter parâmetros de filtro da query string
    $brand = isset($_GET['brand']) ? $_GET['brand'] : '';
    $model = isset($_GET['model']) ? $_GET['model'] : '';
    $transmission = isset($_GET['transmission']) ? $_GET['transmission'] : '';
    $fuel_type = isset($_GET['fuel_type']) ? $_GET['fuel_type'] : '';
    $registration_year = isset($_GET['registration_year']) ? $_GET['registration_year'] : '';
    $price = isset($_GET['price']) ? $_GET['price'] : '';
    $mileage = isset($_GET['mileage']) ? $_GET['mileage'] : '';
    $power = isset($_GET['power']) ? $_GET['power'] : '';

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
        WHERE 1=1";

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
    if ($fuel_type) {
        $sql .= " AND c.fuel_type = :fuel_type";
        $params[':fuel_type'] = $fuel_type;
    }
    if ($registration_year) {
        list($min_year, $max_year) = explode('-', $registration_year);
        $sql .= " AND c.registration_year BETWEEN :min_year AND :max_year";
        $params[':min_year'] = $min_year;
        $params[':max_year'] = $max_year;
    }
    if ($price) {
        list($min_price, $max_price) = explode('-', $price);
        $sql .= " AND c.price BETWEEN :min_price AND :max_price";
        $params[':min_price'] = $min_price;
        $params[':max_price'] = $max_price;
    }
    if ($mileage) {
        list($min_mileage, $max_mileage) = explode('-', $mileage);
        $sql .= " AND c.mileage BETWEEN :min_mileage AND :max_mileage";
        $params[':min_mileage'] = $min_mileage;
        $params[':max_mileage'] = $max_mileage;
    }
    if ($power) {
        list($min_power, $max_power) = explode('-', $power);
        $sql .= " AND c.power BETWEEN :min_power AND :max_power";
        $params[':min_power'] = $min_power;
        $params[':max_power'] = $max_power;
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