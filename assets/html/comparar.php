<?php
include '../php/db.php'; // Conexão com a base de dados

// Obter a conexão PDO
$pdo = getPDO();

// Buscar todos os carros disponíveis para seleção com a imagem associada
$sql = "SELECT c.id, c.brand, c.model, 
               (SELECT image_url FROM car_images WHERE car_id = c.id LIMIT 1) AS image_url 
        FROM cars c";
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
    <link rel="stylesheet" href="../../assets/css/header.css">
    <style>
        .car-option {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .car-option img {
            width: 50px;
            height: 30px;
            object-fit: cover;
            border-radius: 5px;
        }

        select {
            width: 100%;
            padding: 8px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <?php include("header.php"); ?>
    <h1>Comparação de Carros</h1>

    <!-- Formulário para selecionar os carros -->
    <form action="comparar_resultados.php" method="GET">
        <label for="car1">Escolha o primeiro carro:</label>
        <select name="car1" id="car1" required>
            <option value="" disabled selected>Selecione um carro</option>
            <?php foreach ($allCars as $car): ?>
                <?php
                // Caminho da imagem com o padrão do projeto
                $imageUrl = !empty($car['image_url']) ? '/PAP-Goncalo/' . htmlspecialchars($car['image_url']) : '/PAP-Goncalo/assets/images/carros/default-car.jpg';
                ?>
                <option value="<?php echo $car['id']; ?>" data-image="<?php echo $imageUrl; ?>">
                    <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <img id="car1-image" src="" alt="Imagem do carro" style="width:420px; height:250px; margin-top: 10px;">

        <label for="car2">Escolha o segundo carro:</label>
        <select name="car2" id="car2" required>
            <option value="" disabled selected>Selecione um carro</option>
            <?php foreach ($allCars as $car): ?>
                <?php
                // Mesmo caminho para o segundo select
                $imageUrl = !empty($car['image_url']) ? '/PAP-Goncalo/' . htmlspecialchars($car['image_url']) : '/PAP-Goncalo/assets/images/carros/default-car.jpg';
                ?>
                <option value="<?php echo $car['id']; ?>" data-image="<?php echo $imageUrl; ?>">
                    <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <img id="car2-image" src="" alt="Imagem do carro" style="width:420px; height:250px; margin-top: 10px;">

        <button type="submit">Comparar</button>
    </form>

    <script>
        // Atualizar imagem ao selecionar um carro
        document.getElementById('car1').addEventListener('change', function () {
            let selectedOption = this.options[this.selectedIndex];
            document.getElementById('car1-image').src = selectedOption.getAttribute('data-image');
        });

        document.getElementById('car2').addEventListener('change', function () {
            let selectedOption = this.options[this.selectedIndex];
            document.getElementById('car2-image').src = selectedOption.getAttribute('data-image');
        });
    </script>
</body>

</html>