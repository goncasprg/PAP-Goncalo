<?php
require_once("../assets/php/db.php");

$pdo = getPDO();

$sql = "SELECT c.*, 
               COALESCE(ci.image_url, 'default-car.jpg') AS image_url
        FROM cars c
        LEFT JOIN car_images ci ON c.id = ci.car_id
        GROUP BY c.id";

$stmt = $pdo->query($sql);
$cars = $stmt->fetchAll();

header("Content-Type: application/json");
echo json_encode($cars);
?>
