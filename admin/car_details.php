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
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ?");
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
    <link rel="stylesheet" href="../admin/assets/css/car_details.css"> <!-- Novo CSS separado -->
</head>
<?php include 'sidebar.php'; ?>

<body>

    <header>
        <h1>Detalhes do Carro</h1>
        <a href="dashboard.php">Voltar</a> <!-- Link para voltar ao dashboard -->
    </header>

    <section class="car-details">
        <h2><?= $car['brand'] . ' ' . $car['model'] ?></h2>
        <img src="../<?= $car['image_url'] ?>" alt="Imagem do carro" width="300">
        
        <ul>
            <li><strong>ID:</strong> <?= $car['id'] ?></li>
            <li><strong>Marca:</strong> <?= $car['brand'] ?></li>
            <li><strong>Modelo:</strong> <?= $car['model'] ?></li>
            <li><strong>Ano de Registro:</strong> <?= $car['registration_year'] ?></li>
            <li><strong>Quilometragem:</strong> <?= number_format($car['mileage'], 0, ',', '.') ?> km</li>
            <li><strong>Tipo de Combustível:</strong> <?= $car['fuel_type'] ?></li>
            <li><strong>Preço:</strong> <?= number_format($car['price'], 2) ?> €</li>
        </ul>

        <a href="edit_car.php?id=<?= $car['id'] ?>" class="btn">Editar Carro</a>
    </section>

</body>
</html>
