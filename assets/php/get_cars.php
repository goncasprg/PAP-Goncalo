<?php
include "db.php"; // Certifica-te que o caminho está correto

try {
    $stmt = getPDO()->query("
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
            ci.image_url
        FROM 
            cars c
        LEFT JOIN 
            car_images ci ON c.id = ci.car_id
    ");
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($cars);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>