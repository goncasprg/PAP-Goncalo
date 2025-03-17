<?php
include '../php/db.php'; // Conexão com a base de dados

// Obter os IDs dos carros a comparar
$car1_id = isset($_GET['car1']) ? intval($_GET['car1']) : 0;
$car2_id = isset($_GET['car2']) ? intval($_GET['car2']) : 0;

// Obter a conexão PDO
$pdo = getPDO();

// Buscar informações dos carros
$sql = "SELECT c.*, ci.image_url FROM cars c 
        LEFT JOIN car_images ci ON c.id = ci.car_id 
        WHERE c.id IN (:car1_id, :car2_id)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':car1_id', $car1_id, PDO::PARAM_INT);
$stmt->bindParam(':car2_id', $car2_id, PDO::PARAM_INT);
$stmt->execute();
$cars = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Comparação</title>
    <link rel="stylesheet" href="../css/comparar_resultados.css">
</head>

<body>
    <h1>Resultados da Comparação</h1>
    <div class="comparison-container">
        <?php foreach ($cars as $car): ?>
            <div class="car-card">
                <img src="../<?php echo htmlspecialchars($car['image_url']); ?>"
                    alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>">
                <h2><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h2>
                <p><strong>Ano:</strong> <?php echo htmlspecialchars($car['registration_year']); ?></p>
                <p><strong>Quilometragem:</strong> <?php echo htmlspecialchars($car['mileage']); ?> km</p>
                <p><strong>Combustível:</strong> <?php echo htmlspecialchars($car['fuel_type']); ?></p>
                <p><strong>Potência:</strong> <?php echo htmlspecialchars($car['power']); ?> cv</p>
                <p><strong>Transmissão:</strong> <?php echo htmlspecialchars($car['transmission']); ?></p>
                <p><strong>Preço:</strong> €<?php echo number_format($car['price'], 2, ',', '.'); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>