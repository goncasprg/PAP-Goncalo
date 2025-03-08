<?php
session_start();
require_once '../assets/php/db.php';
require_once 'check_admin.php'; // Verifica se é admin

$pdo = getPDO(); // Conectar à BD

// Buscar os carros da base de dados
$stmt = $pdo->query("SELECT * FROM cars");
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="admin.css"> <!-- CSS do painel -->
</head>

<body>

    <header>
        <h1>Gestão de Viaturas</h1>
        <a href="../assets/php/logout.php">Logout</a> <!-- Link para logout -->
    </header>

    <section class="dashboard">
        <h2>Lista de Carros</h2>
        <a href="add_car.php" class="btn">Adicionar Novo Carro</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
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
                    <td><?= $car['id'] ?></td>
                    <td><img src="../<?= $car['image_url'] ?>" alt="Imagem do carro" width="100"></td>
                    <td><?= $car['brand'] ?></td>
                    <td><?= $car['model'] ?></td>
                    <td><?= $car['registration_year'] ?></td>
                    <td><?= number_format($car['price'], 2) ?> €</td>
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
    </section>

</body>

</html>