<?php
require_once '../assets/php/db.php';
require_once 'protect.php';

$pdo = getPDO();
if (!isset($_GET["id"])) {
    die("ID do carro não especificado.");
}

$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->execute([$id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    die("Carro não encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    $price = $_POST["price"];

    $stmt = $pdo->prepare("UPDATE cars SET brand = ?, model = ?, registration_year = ?, price = ? WHERE id = ?");
    $stmt->execute([$brand, $model, $year, $price, $id]);

    header("Location: index.php");
    exit();
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
    <form action="edit_car.php?id=<?= $id ?>" method="post">
        <input type="text" name="brand" value="<?= htmlspecialchars($car['brand']) ?>" required>
        <input type="text" name="model" value="<?= htmlspecialchars($car['model']) ?>" required>
        <input type="number" name="year" value="<?= htmlspecialchars($car['registration_year']) ?>" required>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($car['price']) ?>" required>
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
