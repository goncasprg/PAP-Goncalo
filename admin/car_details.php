<?php
session_start();
require_once '../assets/php/db.php'; // Conectar à base de dados

$pdo = getPDO(); // Conectar à BD

// Verifica se um ID foi passado na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Carro não encontrado!");
}

$car_id = $_GET['id'];

// Buscar informações do carro
$stmt = $pdo->prepare("
    SELECT c.*, ci.image_url 
    FROM cars c
    LEFT JOIN car_images ci ON c.id = ci.car_id
    WHERE c.id = ?
");
$stmt->execute([$car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    die("Carro não encontrado!");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Carro</title>
    <link rel="stylesheet" href="../admin/assets/css/car_details.css">
</head>
<?php include 'sidebar.php'; ?>

<body>

    <header>
        <h1>Detalhes do Carro</h1>
        <a href="dashboard.php" class="btn-back">Voltar</a>
    </header>

    <section class="car-details">
        <h2 class="car-title"><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h2>
        <img src="../<?php echo htmlspecialchars($car['image_url']); ?>" alt="Imagem do carro" class="car-image">
        
        <div class="car-info">
            <p><strong>Ano:</strong> <?php echo htmlspecialchars($car['registration_year']); ?></p>
            <p><strong>Quilometragem:</strong> <?php echo htmlspecialchars($car['mileage']); ?> km</p>
            <p><strong>Assentos:</strong> <?php echo htmlspecialchars($car['seats']); ?></p>
            <p><strong>Portas:</strong> <?php echo htmlspecialchars($car['doors']); ?></p>
            <p><strong>Combustível:</strong> <?php echo htmlspecialchars($car['fuel_type']); ?></p>
            <p><strong>Consumo:</strong> <?php echo htmlspecialchars($car['fuel_consumption']); ?> L/100km</p>
            <p><strong>CO2:</strong> <?php echo htmlspecialchars($car['co2_emissions']); ?> g/km</p>
            <p><strong>Potência:</strong> <?php echo htmlspecialchars($car['power']); ?> cv</p>
            <p><strong>Velocidade Máx:</strong> <?php echo htmlspecialchars($car['top_speed']); ?> km/h</p>
            <p><strong>Aceleração:</strong> <?php echo htmlspecialchars($car['acceleration']); ?> s</p>
            <p><strong>Caixa:</strong> <?php echo htmlspecialchars($car['gearbox']); ?></p>
            <p><strong>Motor:</strong> <?php echo htmlspecialchars($car['engine_capacity']); ?> cc</p>
            <p><strong>Tanque:</strong> <?php echo htmlspecialchars($car['fuel_tank_capacity']); ?> L</p>
            <p><strong>Transmissão:</strong> <?php echo htmlspecialchars($car['transmission']); ?></p>
            <p><strong>Tração:</strong> <?php echo htmlspecialchars($car['traction']); ?></p>
            <p><strong>Cor:</strong> <?php echo htmlspecialchars($car['color']); ?></p>
            <p><strong>Dimensões:</strong> <?php echo htmlspecialchars($car['dimensions']); ?></p>
            <p><strong>Porta-malas:</strong> <?php echo htmlspecialchars($car['trunk_capacity']); ?> L</p>
            <p><strong>Garantia:</strong> <?php echo htmlspecialchars($car['warranty']); ?> meses</p>
            <p><strong>Proprietários:</strong> <?php echo htmlspecialchars($car['previous_owners']); ?></p>
            <p><strong>Serviço:</strong> <?php echo htmlspecialchars($car['service_history']); ?></p>
            <p><strong>Condição:</strong> <?php echo htmlspecialchars($car['condition']); ?></p>
            <p><strong>Preço:</strong> €<?php echo number_format($car['price'], 2, ',', '.'); ?></p>
            <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($car['description'])); ?></p>
        </div>

        <a href="edit_car.php?id=<?php echo $car['id']; ?>" class="btn">Editar Carro</a>
    </section>

</body>
</html>
