<?php
include '../php/db.php'; // Conexão com a base de dados

// Obter a conexão PDO
$pdo = getPDO();

// Buscar todos os carros disponíveis para seleção
$sql = "SELECT id, brand, model FROM cars";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$allCars = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparação de Carros</title>
    <link rel="stylesheet" href="../css/comparar.css">
</head>

<body>
    <h1>Comparação de Carros</h1>

    <!-- Formulário para selecionar os carros -->
    <form action="comparar_resultados.php" method="GET">
        <label for="car1">Escolha o primeiro carro:</label>
        <select name="car1" id="car1" required>
            <option value="" disabled selected>Selecione um carro</option>
            <?php foreach ($allCars as $car): ?>
                <option value="<?php echo $car['id']; ?>">
                    <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="car2">Escolha o segundo carro:</label>
        <select name="car2" id="car2" required>
            <option value="" disabled selected>Selecione um carro</option>
            <?php foreach ($allCars as $car): ?>
                <option value="<?php echo $car['id']; ?>">
                    <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Comparar</button>
    </form>
</body>

</html>