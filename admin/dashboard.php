<?php

require_once '../assets/php/db.php';

// Verifica se o usuário é um administrador
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

// Conectar à base de dados
$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM cars");
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice - Gestão de Carros</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="container">
        <h1>Gestão de Carros</h1>
        <a href="add_car.php" class="add-btn">Adicionar Novo Carro</a>

        <table>
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cars as $car): ?>
                <tr>
                    <td><img src="../<?= htmlspecialchars($car['image_url']) ?>" alt="Imagem do Carro"></td>
                    <td><?= htmlspecialchars($car['brand']) ?></td>
                    <td><?= htmlspecialchars($car['model']) ?></td>
                    <td><?= htmlspecialchars($car['registration_year']) ?></td>
                    <td><?= number_format($car['price'], 2, ',', '.') ?>€</td>
                    <td>
                        <form action="edit_car.php" method="get" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $car['id'] ?>">
                            <button type="submit" class="edit-btn">Editar</button>
                        </form>
                        <form action="delete_car.php" method="get" style="display:inline;"
                            onsubmit="return confirm('Tem certeza que deseja remover este carro?')">
                            <input type="hidden" name="id" value="<?= $car['id'] ?>">
                            <button type="submit" class="delete-btn">Remover</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>