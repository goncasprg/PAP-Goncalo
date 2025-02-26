<?php
require '../assets/php/db.php'; // Conexão com a base de dados

// Captura os filtros
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$model = isset($_GET['model']) ? $_GET['model'] : '';
$transmission = isset($_GET['transmission']) ? $_GET['transmission'] : '';

// Query base
$query = "SELECT * FROM cars WHERE 1=1";

// Adiciona os filtros
$params = [];
if (!empty($brand)) {
    $query .= " AND brand = ?";
    $params[] = $brand;
}
if (!empty($model)) {
    $query .= " AND model = ?";
    $params[] = $model;
}
if (!empty($transmission)) {
    $query .= " AND transmission = ?";
    $params[] = $transmission;
}

// Prepara e executa a consulta
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Resultados da Pesquisa</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>
    <h1>Resultados da Pesquisa</h1>
    <div class="car-list">
        <?php if (count($cars) > 0): ?>
        <?php foreach ($cars as $car): ?>
        <div class="car-card">
            <h2><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h2>
            <p>Ano: <?php echo htmlspecialchars($car['registration_year']); ?></p>
            <p>Preço: €<?php echo number_format($car['price'], 2, ',', '.'); ?></p>
            <p>Transmissão: <?php echo htmlspecialchars($car['transmission']); ?></p>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>Nenhum carro encontrado.</p>
        <?php endif; ?>
    </div>
</body>

</html>