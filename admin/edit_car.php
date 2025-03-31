<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

$pdo = getPDO();
if (!isset($_GET["id"])) {
    die("ID do carro não especificado.");
}

$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT c.*, ci.image_url FROM cars c LEFT JOIN car_images ci ON c.id = ci.car_id WHERE c.id = ?");
$stmt->execute([$id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    die("Carro não encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $registration_year = $_POST["registration_year"];
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

    $pdo->beginTransaction();

    try {
        // Atualizar os dados do carro na tabela cars
        $stmt = $pdo->prepare("UPDATE cars SET brand = ?, model = ?, registration_year = ?, mileage = ?, seats = ?, doors = ?, fuel_type = ?, fuel_consumption = ?, co2_emissions = ?, power = ?, top_speed = ?, acceleration = ?, gearbox = ?, engine_capacity = ?, fuel_tank_capacity = ?, transmission = ?, traction = ?, color = ?, dimensions = ?, trunk_capacity = ?, warranty = ?, previous_owners = ?, service_history = ?, `condition` = ?, price = ?, description = ? WHERE id = ?");
        $stmt->execute([$brand, $model, $registration_year, $mileage, $seats, $doors, $fuel_type, $fuel_consumption, $co2_emissions, $power, $top_speed, $acceleration, $gearbox, $engine_capacity, $fuel_tank_capacity, $transmission, $traction, $color, $dimensions, $trunk_capacity, $warranty, $previous_owners, $service_history, $condition, $price, $description, $id]);

        // Verificar se uma nova imagem foi enviada
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $imagePath = "../assets/images/carros/" . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $image_url = substr($imagePath, 3); // Remover "../" para armazenar corretamente na BD

                // Atualizar ou inserir a imagem na tabela car_images
                $stmt = $pdo->prepare("INSERT INTO car_images (car_id, image_url) VALUES (?, ?) ON DUPLICATE KEY UPDATE image_url = VALUES(image_url)");
                $stmt->execute([$id, $image_url]);
            } else {
                throw new Exception("Erro ao mover o arquivo de imagem.");
            }
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
    <title>Editar Carro</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Editar Carro</h1>
    <form action="edit_car.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="brand" value="<?= htmlspecialchars($car['brand']) ?>" required>
        <input type="text" name="model" value="<?= htmlspecialchars($car['model']) ?>" required>
        <input type="number" name="registration_year" value="<?= htmlspecialchars($car['registration_year']) ?>"
            required>
        <input type="number" name="mileage" value="<?= htmlspecialchars($car['mileage']) ?>" required>
        <input type="number" name="seats" value="<?= htmlspecialchars($car['seats']) ?>" required>
        <input type="number" name="doors" value="<?= htmlspecialchars($car['doors']) ?>" required>
        <select name="fuel_type" required>
            <option value="Gasolina" <?= $car['fuel_type'] == 'Gasolina' ? 'selected' : '' ?>>Gasolina</option>
            <option value="GPL" <?= $car['fuel_type'] == 'GPL' ? 'selected' : '' ?>>GPL</option>
            <option value="Diesel" <?= $car['fuel_type'] == 'Diesel' ? 'selected' : '' ?>>Diesel</option>
            <option value="Elétrico" <?= $car['fuel_type'] == 'Elétrico' ? 'selected' : '' ?>>Elétrico</option>
        </select>
        <input type="text" name="fuel_consumption" value="<?= htmlspecialchars($car['fuel_consumption']) ?>" required>
        <input type="text" name="co2_emissions" value="<?= htmlspecialchars($car['co2_emissions']) ?>" required>
        <input type="text" name="power" value="<?= htmlspecialchars($car['power']) ?>" required>
        <input type="text" name="top_speed" value="<?= htmlspecialchars($car['top_speed']) ?>" required>
        <input type="text" name="acceleration" value="<?= htmlspecialchars($car['acceleration']) ?>" required>
        <input type="text" name="gearbox" value="<?= htmlspecialchars($car['gearbox']) ?>" required>
        <input type="text" name="engine_capacity" value="<?= htmlspecialchars($car['engine_capacity']) ?>" required>
        <input type="text" name="fuel_tank_capacity" value="<?= htmlspecialchars($car['fuel_tank_capacity']) ?>"
            required>
        <select name="transmission" required>
            <option value="Manual" <?= $car['transmission'] == 'Manual' ? 'selected' : '' ?>>Manual</option>
            <option value="Automática" <?= $car['transmission'] == 'Automática' ? 'selected' : '' ?>>Automática</option>
            <option value="CVT" <?= $car['transmission'] == 'CVT' ? 'selected' : '' ?>>CVT</option>
        </select>
        <select name="traction" required>
            <option value="Dianteira" <?= $car['traction'] == 'Dianteira' ? 'selected' : '' ?>>Dianteira</option>
            <option value="Traseira" <?= $car['traction'] == 'Traseira' ? 'selected' : '' ?>>Traseira</option>
            <option value="4x4" <?= $car['traction'] == '4x4' ? 'selected' : '' ?>>4x4</option>
        </select>
        <input type="text" name="color" value="<?= htmlspecialchars($car['color']) ?>" required>
        <input type="text" name="dimensions" value="<?= htmlspecialchars($car['dimensions']) ?>" required>
        <input type="text" name="trunk_capacity" value="<?= htmlspecialchars($car['trunk_capacity']) ?>" required>
        <input type="number" name="warranty" value="<?= htmlspecialchars($car['warranty']) ?>" required>
        <input type="number" name="previous_owners" value="<?= htmlspecialchars($car['previous_owners']) ?>" required>
        <input type="text" name="service_history" value="<?= htmlspecialchars($car['service_history']) ?>" required>
        <select name="condition" required>
            <option value="Novo" <?= $car['condition'] == 'Novo' ? 'selected' : '' ?>>Novo</option>
            <option value="Usado" <?= $car['condition'] == 'Usado' ? 'selected' : '' ?>>Usado</option>
            <option value="Semi-novo" <?= $car['condition'] == 'Semi-novo' ? 'selected' : '' ?>>Semi-novo</option>
        </select>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($car['price']) ?>" required>
        <textarea name="description" required><?= htmlspecialchars($car['description']) ?></textarea>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Salvar Alterações</button>
    </form>
</body>

</html>