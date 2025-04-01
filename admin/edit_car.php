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

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo->beginTransaction();

        // Captura dos valores do formulário
        $fields = [
            "brand", "model", "registration_year", "mileage", "seats", "doors", "fuel_type", "fuel_consumption",
            "co2_emissions", "power", "top_speed", "acceleration", "gearbox", "engine_capacity", "fuel_tank_capacity",
            "transmission", "traction", "color", "dimensions", "trunk_capacity", "warranty", "previous_owners",
            "service_history", "condition", "price", "description"
        ];
        
        $values = [];
        foreach ($fields as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                $errors[] = "O campo \"$field\" é obrigatório.";
            } else {
                $values[] = $_POST[$field];
            }
        }

        if (empty($errors)) {
            $values[] = $id;
            
            // Atualizar informações do carro
            $stmt = $pdo->prepare("UPDATE cars SET 
                brand = ?, model = ?, registration_year = ?, mileage = ?, seats = ?, doors = ?, fuel_type = ?, 
                fuel_consumption = ?, co2_emissions = ?, power = ?, top_speed = ?, acceleration = ?, gearbox = ?, 
                engine_capacity = ?, fuel_tank_capacity = ?, transmission = ?, traction = ?, color = ?, dimensions = ?, 
                trunk_capacity = ?, warranty = ?, previous_owners = ?, service_history = ?, `condition` = ?, price = ?, 
                description = ? WHERE id = ?");
            $stmt->execute($values);

            // Se houver uma nova imagem
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
                $imagePath = "../assets/images/carros/" . basename($_FILES["image"]["name"]);

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                    $image_url = substr($imagePath, 3); // Remover "../" para armazenar corretamente na BD

                    // Verificar se já existe imagem associada ao carro
                    $stmt = $pdo->prepare("SELECT id FROM car_images WHERE car_id = ?");
                    $stmt->execute([$id]);
                    $existingImage = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($existingImage) {
                        // Atualizar a imagem existente
                        $stmt = $pdo->prepare("UPDATE car_images SET image_url = ? WHERE car_id = ?");
                        $stmt->execute([$image_url, $id]);
                    } else {
                        // Inserir nova imagem
                        $stmt = $pdo->prepare("INSERT INTO car_images (car_id, image_url) VALUES (?, ?)");
                        $stmt->execute([$id, $image_url]);
                    }
                } else {
                    throw new Exception("Erro ao mover o arquivo de imagem.");
                }
            }

            $pdo->commit();
            header("Location: index.php");
            exit();
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $errors[] = "Erro: " . $e->getMessage();
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
    
    <?php if (!empty($errors)) : ?>
        <div style="color: red; font-weight: bold;">
            <p>⚠️ Preencha todos os campos obrigatórios antes de continuar:</p>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="edit_car.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="brand" placeholder="Marca" value="<?= htmlspecialchars($car['brand']) ?>" required>
        <input type="text" name="model" placeholder="Modelo" value="<?= htmlspecialchars($car['model']) ?>" required>
        <input type="number" name="registration_year" placeholder="Ano de Registo" value="<?= htmlspecialchars($car['registration_year']) ?>" required>
        <input type="number" name="mileage" placeholder="Quilometragem" value="<?= htmlspecialchars($car['mileage']) ?>" required>
        <input type="text" name="gearbox" placeholder="Caixa de Velocidades" value="<?= htmlspecialchars($car['gearbox']) ?>" required>
        <input type="text" name="engine_capacity" placeholder="Capacidade do Motor (cc)" value="<?= htmlspecialchars($car['engine_capacity']) ?>" required>
        <input type="text" name="fuel_tank_capacity" placeholder="Capacidade do Tanque (L)" value="<?= htmlspecialchars($car['fuel_tank_capacity']) ?>" required>
        <select name="fuel_type" required>
            <option value="Gasolina" <?= $car['fuel_type'] == 'Gasolina' ? 'selected' : '' ?>>Gasolina</option>
            <option value="GPL" <?= $car['fuel_type'] == 'GPL' ? 'selected' : '' ?>>GPL</option>
            <option value="Diesel" <?= $car['fuel_type'] == 'Diesel' ? 'selected' : '' ?>>Diesel</option>
            <option value="Elétrico" <?= $car['fuel_type'] == 'Elétrico' ? 'selected' : '' ?>>Elétrico</option>
        </select>
        <select name="service_history" required>
            <option value="Sim" <?= $car['service_history'] == 'Sim' ? 'selected' : '' ?>>Sim</option>
            <option value="Não" <?= $car['service_history'] == 'Não' ? 'selected' : '' ?>>Não</option>
        </select>
        <select name="condition" required>
            <option value="Novo" <?= $car['condition'] == 'Novo' ? 'selected' : '' ?>>Novo</option>
            <option value="Usado" <?= $car['condition'] == 'Usado' ? 'selected' : '' ?>>Usado</option>
            <option value="Semi-novo" <?= $car['condition'] == 'Semi-novo' ? 'selected' : '' ?>>Semi-novo</option>
        </select>
        <input type="number" step="0.01" name="price" placeholder="Preço (€)" value="<?= htmlspecialchars($car['price']) ?>" required>
        <textarea name="description" placeholder="Descrição do Carro" required><?= htmlspecialchars($car['description']) ?></textarea>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>