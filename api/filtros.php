<?php
require_once '../assets/php/db.php';

header('Content-Type: application/json');

$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$model = isset($_GET['model']) ? $_GET['model'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';

$query = "SELECT c.*, ci.image_url FROM cars c 
          LEFT JOIN car_images ci ON c.id = ci.car_id WHERE 1=1";

if (!empty($brand)) {
    $query .= " AND c.brand = ?";
}
if (!empty($model)) {
    $query .= " AND c.model = ?";
}
if (!empty($year)) {
    $query .= " AND c.registration_year = ?";
}
if (!empty($price)) {
    if ($price == "low") {
        $query .= " AND c.price <= 10000";
    } elseif ($price == "mid") {
        $query .= " AND c.price BETWEEN 10000 AND 30000";
    } elseif ($price == "high") {
        $query .= " AND c.price > 30000";
    }
}

$stmt = $conn->prepare($query);

$params = [];
if (!empty($brand)) $params[] = $brand;
if (!empty($model)) $params[] = $model;
if (!empty($year)) $params[] = $year;

if (!empty($params)) {
    $stmt->execute($params);
} else {
    $stmt->execute();
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results);
?>