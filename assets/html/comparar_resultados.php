<?php
include '../php/db.php'; // Conexão com a base de dados

// Obter os IDs dos carros a comparar (agora suporta vários)
$compare_ids = [];
if (isset($_GET['compare']) && is_array($_GET['compare'])) {
    foreach ($_GET['compare'] as $id) {
        $id = intval($id);
        if ($id > 0) $compare_ids[] = $id;
    }
}
if (empty($compare_ids)) {
    echo '<h2 style="color:red;text-align:center;margin-top:50px;">Nenhum carro selecionado para comparar.</h2>';
    exit;
}

$pdo = getPDO();
// Montar placeholders para o IN
$placeholders = implode(',', array_fill(0, count($compare_ids), '?'));
$sql = "SELECT c.*, ci.image_url 
        FROM cars c 
        LEFT JOIN car_images ci ON c.id = ci.car_id
        WHERE c.id IN ($placeholders)";
$stmt = $pdo->prepare($sql);
$stmt->execute($compare_ids);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Comparação</title>
    <link rel="stylesheet" href="../css/comparar_resultados.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Resultados da Comparação</h1>
    <div class="comparison-container">
        <?php foreach ($cars as $car): ?>
            <div class="car-card">
                <?php 
                    // Caminho da imagem igual comparar.php
                    if (!empty($car['image_url'])) {
                        $img = htmlspecialchars($car['image_url']);
                        if ($img[0] === '/') {
                            $imageUrl = $img;
                        } else {
                            $imageUrl = '/PAP-Goncalo/' . $img;
                        }
                    } else {
                        $imageUrl = '/PAP-Goncalo/assets/images/carros/default-car.jpg';
                    }
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