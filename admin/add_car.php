<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = getPDO();

    $brand = $_POST["brand"] ?? '';
    $model = $_POST["model"] ?? '';
    $registration_year = $_POST["registration_year"] ?? '';
    $mileage = $_POST["mileage"] ?? '';
    $seats = $_POST["seats"] ?? '';
    $doors = $_POST["doors"] ?? '';
    $fuel_type = $_POST["fuel_type"] ?? '';
    $fuel_consumption = $_POST["fuel_consumption"] ?? '';
    $co2_emissions = $_POST["co2_emissions"] ?? '';
    $power = $_POST["power"] ?? '';
    $top_speed = $_POST["top_speed"] ?? '';
    $acceleration = $_POST["acceleration"] ?? '';
    $gearbox = $_POST["gearbox"] ?? '';
    $engine_capacity = $_POST["engine_capacity"] ?? '';
    $fuel_tank_capacity = $_POST["fuel_tank_capacity"] ?? '';
    $transmission = $_POST["transmission"] ?? '';
    $traction = $_POST["traction"] ?? '';
    $color = $_POST["color"] ?? '';
    $dimensions = $_POST["dimensions"] ?? '';
    $trunk_capacity = $_POST["trunk_capacity"] ?? '';
    $warranty = $_POST["warranty"] ?? '';
    $previous_owners = $_POST["previous_owners"] ?? '';
    $service_history = $_POST["service_history"] ?? '';
    $condition = $_POST["condition"] ?? '';
    $price = $_POST["price"] ?? '';
    $description = $_POST["description"] ?? '';

    // Validação do campo 'traction'
    $validTractions = ['FWD', 'RWD', 'AWD', '4x4'];
    if (!in_array($traction, $validTractions)) {
        die("Erro: Valor inválido para o campo 'traction'.");
    }

    // Validação do campo 'service_history'
    $validServiceHistory = ['Sim', 'Não'];
    if (!in_array($service_history, $validServiceHistory)) {
        die("Erro: Valor inválido para o campo 'service_history'.");
    }

    $pdo->beginTransaction();

    try {
        // Inserir os dados do carro na tabela cars
        $stmt = $pdo->prepare("INSERT INTO cars (brand, model, registration_year, mileage, seats, doors, fuel_type, fuel_consumption, co2_emissions, power, top_speed, acceleration, gearbox, engine_capacity, fuel_tank_capacity, transmission, traction, color, dimensions, trunk_capacity, warranty, previous_owners, service_history, `condition`, price, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$brand, $model, $registration_year, $mileage, $seats, $doors, $fuel_type, $fuel_consumption, $co2_emissions, $power, $top_speed, $acceleration, $gearbox, $engine_capacity, $fuel_tank_capacity, $transmission, $traction, $color, $dimensions, $trunk_capacity, $warranty, $previous_owners, $service_history, $condition, $price, $description]);

        // Obter o ID do carro recém-inserido
        $car_id = $pdo->lastInsertId();

        // Verificar se uma imagem foi enviada
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $imagePath = "../assets/images/carros/" . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $image_url = substr($imagePath, 3); // Remover "../" para armazenar corretamente na BD

                // Inserir o link da imagem na tabela car_images
                $stmt = $pdo->prepare("INSERT INTO car_images (car_id, image_url) VALUES (?, ?)");
                $stmt->execute([$car_id, $image_url]);
            } else {
                throw new Exception("Erro ao mover o arquivo de imagem.");
            }
        } else {
            throw new Exception("Nenhuma imagem foi enviada ou ocorreu um erro no upload.");
        }

        $pdo->commit();
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erro: " . $e->getMessage());
    }
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
        <input type="number" name="seats" placeholder="Número de Lugares" required>
        <input type="number" name="doors" placeholder="Número de Portas" required>

        <!-- Corrigido: Nome do campo alterado para fuel_type -->
        <select name="fuel_type" required>
            <option value="" disabled selected>Selecione o tipo de combustível</option>
            <option value="Gasolina">Gasolina</option>
            <option value="GPL">GPL</option>
            <option value="Diesel">Diesel</option>
            <option value="Elétrico">Elétrico</option>
        </select>

        <input type="text" name="fuel_consumption" placeholder="Consumo de Combustível (L/100km)" required>
        <input type="text" name="co2_emissions" placeholder="Emissões de CO2 (g/km)" required>
        <input type="text" name="power" placeholder="Potência (cv)" required>
        <input type="text" name="top_speed" placeholder="Velocidade Máxima (km/h)" required>
        <input type="text" name="acceleration" placeholder="Aceleração (0-100 km/h)" required>
        <input type="text" name="gearbox" placeholder="Caixa de Velocidades" required>
        <input type="text" name="engine_capacity" placeholder="Capacidade do Motor (cc)" required>
        <input type="text" name="fuel_tank_capacity" placeholder="Capacidade do Tanque (L)" required>

        <!-- Dropdown para Transmissão -->
        <select name="transmission" required>
            <option value="" disabled selected>Selecione a Transmissão</option>
            <option value="Manual">Manual</option>
            <option value="Automática">Automática</option>
            <option value="CVT">CVT</option>
        </select>

        <!-- Corrigido: Valores do campo traction -->
        <select name="traction" required>
            <option value="" disabled selected>Selecione o tipo de tração</option>
            <option value="FWD">Dianteira (FWD)</option>
            <option value="RWD">Traseira (RWD)</option>
            <option value="AWD">Integral (AWD)</option>
            <option value="4x4">4x4</option>
        </select>

        <input type="text" name="color" placeholder="Cor" required>
        <input type="text" name="dimensions" placeholder="Dimensões (mm)" required>
        <input type="text" name="trunk_capacity" placeholder="Capacidade do Porta-Malas (L)" required>
        <input type="number" name="warranty" placeholder="Garantia (meses)" required>
        <input type="number" name="previous_owners" placeholder="Número de Proprietários Anteriores" required>

        <!-- Dropdown para Histórico de Serviço -->
        <select name="service_history" required>
            <option value="" disabled selected>Histórico de Serviço</option>
            <option value="Sim">Sim</option>
            <option value="Não">Não</option>
        </select>

        <!-- Dropdown para Condição -->
        <select name="condition" required>
            <option value="" disabled selected>Selecione a Condição</option>
            <option value="Novo">Novo</option>
            <option value="Usado">Usado</option>
            <option value="Semi-novo">Semi-novo</option>
        </select>

        <input type="number" step="0.01" name="price" placeholder="Preço (€)" required>
        <textarea name="description" placeholder="Descrição do Carro" required></textarea>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Adicionar</button>
    </form>
</body>

</html>