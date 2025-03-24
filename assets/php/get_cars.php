<?php
include "db.php"; // Certifica-te que o caminho está correto

try {
    $stmt = getPDO()->query("SELECT brand, model, engine_capacity, fuel_type, registration_year, mileage, transmission, price, 
        CONCAT('assets/images/carros/', image_url) AS image_url FROM cars");
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($cars);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
