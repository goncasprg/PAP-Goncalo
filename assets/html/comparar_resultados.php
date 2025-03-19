<?php
include '../php/db.php'; // Conexão com a base de dados

// Obter os IDs dos carros a comparar
$car1_id = isset($_GET['car1']) ? intval($_GET['car1']) : 0;
$car2_id = isset($_GET['car2']) ? intval($_GET['car2']) : 0;

// Obter a conexão PDO
$pdo = getPDO();

// Buscar informações dos carros
$sql = "SELECT *, CONCAT('assets/images/carros/', image_url) AS full_image_url FROM cars WHERE id IN (:car1_id, :car2_id)";
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
                <img src="../<?php echo htmlspecialchars($car['full_image_url']); ?>"
                    alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>">
                <h2><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h2>
                <p><strong>Ano:</strong> <?php echo htmlspecialchars($car['registration_year']); ?></p>
                <p><strong>Quilometragem:</strong> <?php echo htmlspecialchars($car['mileage']); ?> km</p>
                <p><strong>Assentos:</strong> <?php echo htmlspecialchars($car['seats']); ?></p>
                <p><strong>Portas:</strong> <?php echo htmlspecialchars($car['doors']); ?></p>
                <p><strong>Combustível:</strong> <?php echo htmlspecialchars($car['fuel_type']); ?></p>
                <p><strong>Consumo de Combustível:</strong> <?php echo htmlspecialchars($car['fuel_consumption']); ?> L/100km</p>
                <p><strong>Emissões de CO2:</strong> <?php echo htmlspecialchars($car['co2_emissions']); ?> g/km</p>
                <p><strong>Potência:</strong> <?php echo htmlspecialchars($car['power']); ?> cv</p>
                <p><strong>Velocidade Máxima:</strong> <?php echo htmlspecialchars($car['top_speed']); ?> km/h</p>
                <p><strong>Aceleração (0-100 km/h):</strong> <?php echo htmlspecialchars($car['acceleration']); ?> s</p>
                <p><strong>Caixa de Velocidades:</strong> <?php echo htmlspecialchars($car['gearbox']); ?></p>
                <p><strong>Capacidade do Motor:</strong> <?php echo htmlspecialchars($car['engine_capacity']); ?> cc</p>
                <p><strong>Capacidade do Tanque:</strong> <?php echo htmlspecialchars($car['fuel_tank_capacity']); ?> L</p>
                <p><strong>Transmissão:</strong> <?php echo htmlspecialchars($car['transmission']); ?></p>
                <p><strong>Tração:</strong> <?php echo htmlspecialchars($car['traction']); ?></p>
                <p><strong>Cor:</strong> <?php echo htmlspecialchars($car['color']); ?></p>
                <p><strong>Dimensões (mm):</strong> <?php echo htmlspecialchars($car['dimensions']); ?></p>
                <p><strong>Capacidade do Porta-Malas:</strong> <?php echo htmlspecialchars($car['trunk_capacity']); ?> L</p>
                <p><strong>Garantia:</strong> <?php echo htmlspecialchars($car['warranty']); ?></p>
                <p><strong>Proprietários Anteriores:</strong> <?php echo htmlspecialchars($car['previous_owners']); ?></p>
                <p><strong>Histórico de Serviço:</strong> <?php echo htmlspecialchars($car['service_history']); ?></p>
                <p><strong>Condição:</strong> <?php echo htmlspecialchars($car['condition']); ?></p>
                <p><strong>Preço:</strong> €<?php echo number_format($car['price'], 2, ',', '.'); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>
