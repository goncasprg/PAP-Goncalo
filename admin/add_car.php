<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = getPDO();

    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $registration_year = (int)$_POST["registration_year"];
    $mileage = $_POST["mileage"];
    $seats = $_POST["seats"];
    $doors = $_POST["doors"];
    $fuel_type = $_POST["fuel_type"];
    $fuel_consumption = $_POST["fuel_consumption"];
    $co2_emissions = $_POST["co2_emissions"];
    $power = $_POST["power"];
    $top_speed = $_POST["top_speed"];
    $acceleration = $_POST["acceleration"];
    $gearbox = $_POST["gearbox"];
    $engine_capacity = $_POST["engine_capacity"];
    $fuel_tank_capacity = $_POST["fuel_tank_capacity"];
    $transmission = $_POST["transmission"];
    $traction = $_POST["traction"];
    $color = $_POST["color"];
    $dimensions = $_POST["dimensions"];
    $trunk_capacity = $_POST["trunk_capacity"];
    $warranty = $_POST["warranty"];
    $previous_owners = $_POST["previous_owners"];
    $service_history = $_POST["service_history"];
    $condition = $_POST["condition"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    // Upload da imagem
    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $imagePath = "../assets/images/carros/" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
        $image_url = substr($imagePath, 3); // Remover "../" para armazenar corretamente na BD
    } else {
        die("Erro ao carregar imagem.");
    }

    // Inserir dados no banco
    $stmt = $pdo->prepare("INSERT INTO cars (brand, model, registration_year, mileage, seats, doors, fuel_type, fuel_consumption, co2_emissions, power, top_speed, acceleration, gearbox, engine_capacity, fuel_tank_capacity, transmission, traction, color, dimensions, trunk_capacity, warranty, previous_owners, service_history, condition, price, description, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$brand, $model, $registration_year, $mileage, $seats, $doors, $fuel_type, $fuel_consumption, $co2_emissions, $power, $top_speed, $acceleration, $gearbox, $engine_capacity, $fuel_tank_capacity, $transmission, $traction, $color, $dimensions, $trunk_capacity, $warranty, $previous_owners, $service_history, $condition, $price, $description, $image_url]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Carro</title>
    <link rel="stylesheet" href="../admin/assets/css/admin.css">
</head>
<body>
    <h1>Adicionar Novo Carro</h1>
    <form action="add_car.php" method="post" enctype="multipart/form-data">
        <input type="text" name="brand" placeholder="Marca" required>
        <input type="text" name="model" placeholder="Modelo" required>
        <input type="number" name="registration_year" placeholder="Ano de Registo" required>
        <input type="number" name="mileage" placeholder="Quilometragem" required>
        <input type="number" name="seats" placeholder="Número de Assentos" required>
        <input type="number" name="doors" placeholder="Número de Portas" required>
        <input type="text" name="fuel_type" placeholder="Tipo de Combustível" required>
        <input type="text" name="fuel_consumption" placeholder="Consumo de Combustível (L/100km)" required>
        <input type="text" name="co2_emissions" placeholder="Emissões de CO2 (g/km)" required>
        <input type="text" name="power" placeholder="Potência (cv)" required>
        <input type="text" name="top_speed" placeholder="Velocidade Máxima (km/h)" required>
        <input type="text" name="acceleration" placeholder="Aceleração (0-100 km/h)" required>
        <input type="text" name="gearbox" placeholder="Caixa de Velocidades" required>
        <input type="text" name="engine_capacity" placeholder="Capacidade do Motor (cc)" required>
        <input type="text" name="fuel_tank_capacity" placeholder="Capacidade do Tanque (L)" required>
        <input type="text" name="transmission" placeholder="Transmissão" required>
        <input type="text" name="traction" placeholder="Tração" required>
        <input type="text" name="color" placeholder="Cor" required>
        <input type="text" name="dimensions" placeholder="Dimensões (mm)" required>
        <input type="text" name="trunk_capacity" placeholder="Capacidade do Porta-Malas (L)" required>
        <input type="number" name="warranty" placeholder="Garantia (meses)" required>
        <input type="number" name="previous_owners" placeholder="Número de Proprietários Anteriores" required>
        <input type="text" name="service_history" placeholder="Histórico de Serviço" required>
        <input type="text" name="condition" placeholder="Condição" required>
        <input type="number" step="0.01" name="price" placeholder="Preço (€)" required>
        <textarea name="description" placeholder="Descrição do Carro" required></textarea>
        <input type="file" name="image" required>

        <button type="submit">Adicionar</button>
    </form>
</body>
</html>
