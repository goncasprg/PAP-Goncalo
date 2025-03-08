<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $year = (int)$_POST["year"]; // Certifique-se de que o ano seja um número inteiro
    $price = $_POST["price"];
    $image = $_FILES["image"];
    $mileage = isset($_POST['mileage']) && $_POST['mileage'] !== '' ? $_POST['mileage'] : 0;
    $seats = $_POST["seats"];
    $fuel_type = $_POST["fuel_type"];
    $power = $_POST["power"];
    $engine_capacity = $_POST["engine_capacity"];
    $transmission = $_POST["transmission"];
    $color = $_POST["color"];
    $warranty = isset($_POST['warranty']) && $_POST['warranty'] !== '' ? $_POST['warranty'] : 0;
    $description = isset($_POST['description']) ? $_POST['description'] : NULL;

    if ($image["error"] === UPLOAD_ERR_OK) {
        $imagePath = "../assets/images/carros/" . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $imagePath);
        $image_url = substr($imagePath, 3); // Remove "../"
    } else {
        die("Erro ao carregar imagem.");
    }

    $pdo = getPDO();
    $stmt = $pdo->prepare("INSERT INTO cars (brand, model, registration_year, price, mileage, seats, fuel_type, power, engine_capacity, transmission, color, warranty, description, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$brand, $model, $year, $price, $mileage, $seats, $fuel_type, $power, $engine_capacity, $transmission, $color, $warranty, $description, $image_url]);

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
    <h1 class="form-title">Adicionar Novo Carro</h1>
    <form action="add_car.php" method="post" enctype="multipart/form-data" class="car-form">
        <input type="text" name="brand" placeholder="Marca" required class="form-input">
        <input type="text" name="model" placeholder="Modelo" required class="form-input">
        <input type="number" name="year" placeholder="Ano" required class="form-input">
        <input type="number" step="0.01" name="price" placeholder="Preço" required class="form-input">
        <input type="number" name="mileage" placeholder="Quilometragem" class="form-input">
        <input type="number" name="seats" placeholder="Número de Assentos" required class="form-input">
        <select name="fuel_type" required class="form-select">
            <option value="Gasolina">Gasolina</option>
            <option value="Diesel">Diesel</option>
            <option value="Elétrico">Elétrico</option>
            <option value="Híbrido">Híbrido</option>
        </select>
        <input type="number" name="power" placeholder="Potência" required class="form-input">
        <input type="number" step="0.01" name="engine_capacity" placeholder="Capacidade do Motor" required class="form-input">
        <select name="transmission" required class="form-select">
            <option value="Manual">Manual</option>
            <option value="Automática">Automática</option>
            <option value="Semi-Automática">Semi-Automática</option>
        </select>
        <input type="text" name="color" placeholder="Cor" required class="form-input">
        <input type="number" name="warranty" placeholder="Garantia (meses)" class="form-input">
        <textarea name="description" placeholder="Descrição" class="form-textarea"></textarea>
        <input type="file" name="image" required class="form-input">
        <button type="submit" class="form-btn">Adicionar</button>
    </form>
</body>

</html>
