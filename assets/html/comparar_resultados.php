<?php
include '../php/db.php'; // Conexão com a base de dados

// Obter os IDs dos carros a comparar
$car1_id = isset($_GET['car1']) ? intval($_GET['car1']) : 0;
$car2_id = isset($_GET['car2']) ? intval($_GET['car2']) : 0;

// Obter a conexão PDO
$pdo = getPDO();

// Buscar informações dos carros e a imagem associada
$sql = "SELECT c.*, ci.image_url 
        FROM cars c 
        LEFT JOIN car_images ci ON c.id = ci.car_id
        WHERE c.id IN (:car1_id, :car2_id)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':car1_id', $car1_id, PDO::PARAM_INT);
$stmt->bindParam(':car2_id', $car2_id, PDO::PARAM_INT);
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <?php 
                    // Caminho da imagem
                    $imageUrl = !empty($car['image_url']) ? '../assets/images/carros/' . htmlspecialchars($car['image_url']) : '../assets/images/carros/default-car.jpg';
                ?>
                <img src="<?php echo $imageUrl; ?>" alt="Imagem do carro" class="car-image">
                <h2><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h2>
                <p>Ano: <?php echo htmlspecialchars($car['registration_year']); ?></p>
                <p>Quilometragem: <?php echo htmlspecialchars($car['mileage']); ?> km</p>
                <p>Assentos: <?php echo htmlspecialchars($car['seats']); ?></p>
                <p>Portas: <?php echo htmlspecialchars($car['doors']); ?></p>
                <p>Combustível: <?php echo htmlspecialchars($car['fuel_type']); ?></p>
                <p>Consumo de Combustível: <?php echo htmlspecialchars($car['fuel_consumption']); ?> L/100km</p>
                <p>Emissões de CO2: <?php echo htmlspecialchars($car['co2_emissions']); ?> g/km</p>
                <p>Potência: <?php echo htmlspecialchars($car['power']); ?> cv</p>
                <p>Velocidade Máxima: <?php echo htmlspecialchars($car['top_speed']); ?> km/h</p>
                <p>Aceleração (0-100 km/h): <?php echo htmlspecialchars($car['acceleration']); ?> s</p>
                <p>Caixa de Velocidades: <?php echo htmlspecialchars($car['gearbox']); ?></p>
                <p>Capacidade do Motor: <?php echo htmlspecialchars($car['engine_capacity']); ?> cc</p>
                <p>Capacidade do Tanque: <?php echo htmlspecialchars($car['fuel_tank_capacity']); ?> L</p>
                <p>Transmissão: <?php echo htmlspecialchars($car['transmission']); ?></p>
                <p>Tração: <?php echo htmlspecialchars($car['traction']); ?></p>
                <p>Cor: <?php echo htmlspecialchars($car['color']); ?></p>
                <p>Dimensões (mm): <?php echo htmlspecialchars($car['dimensions']); ?></p>
                <p>Capacidade do Porta-Malas: <?php echo htmlspecialchars($car['trunk_capacity']); ?> L</p>
                <p>Garantia: <?php echo htmlspecialchars($car['warranty']); ?></p>
                <p>Proprietários Anteriores: <?php echo htmlspecialchars($car['previous_owners']); ?></p>
                <p>Histórico de Serviço: <?php echo htmlspecialchars($car['service_history']); ?></p>
                <p>Condição: <?php echo htmlspecialchars($car['condition']); ?></p>
                <p>Preço: €<?php echo number_format($car['price'], 2, ',', '.'); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
