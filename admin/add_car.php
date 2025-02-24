<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    $price = $_POST["price"];
    $image = $_FILES["image"];

    if ($image["error"] === UPLOAD_ERR_OK) {
        $imagePath = "../assets/images/carros/" . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $imagePath);
    } else {
        die("Erro ao carregar imagem.");
    }

    $pdo = getPDO();
    $stmt = $pdo->prepare("INSERT INTO cars (brand, model, registration_year, price, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$brand, $model, $year, $price, substr($imagePath, 3)]); // Remove "../"

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
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h1>Adicionar Novo Carro</h1>
    <form action="add_car.php" method="post" enctype="multipart/form-data">
        <input type="text" name="brand" placeholder="Marca" required>
        <input type="text" name="model" placeholder="Modelo" required>
        <input type="number" name="year" placeholder="Ano" required>
        <input type="number" step="0.01" name="price" placeholder="Preço" required>
        <input type="file" name="image" required>
        <button type="submit">Adicionar</button>
    </form>
</body>
</html>
