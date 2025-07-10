<?php
session_start();
require_once '../assets/php/db.php';
require_once 'check_admin.php';

// Verifica se o usuário é um administrador
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

// Buscar os carros na base de dados com apenas uma imagem associada
$pdo = getPDO();
$stmt = $pdo->query("
    SELECT c.*, 
           (SELECT image_url FROM car_images WHERE car_id = c.id LIMIT 1) AS image_url
    FROM cars c
");
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="/PAP-Goncalo/admin/assets/css/sidebar.css">
    <link rel="stylesheet" href="/PAP-Goncalo/admin/assets/css/admin.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="container">
        <header>
            <h1>Gestão de Viaturas</h1>
        </header>

        <section class="dashboard">
            <h2>Lista de Carros</h2>
            <a class="button" href="add_car.php" class="add-btn">Adicionar Novo Carro</a>
            <?php if (empty($cars)): ?>
                <p>Nenhum carro encontrado.</p>
            <?php else: ?>
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
                            <tr class="clickable-row" data-href="car_details.php?id=<?= htmlspecialchars($car['id']) ?>">
                                <td>
                                    <img src="<?php echo !empty($car['image_url']) ? '/PAP-Goncalo/' . htmlspecialchars($car['image_url']) : '/PAP-Goncalo/assets/images/carros/default-car.jpg'; ?>" alt="Imagem do Carro" width="100">
                                </td>
                                <td><?= htmlspecialchars($car['brand']) ?></td>
                                <td><?= htmlspecialchars($car['model']) ?></td>
                                <td><?= htmlspecialchars($car['registration_year']) ?></td>
                                <td><?= number_format($car['price'], 2, ',', '.') ?>€</td>
                                <td>
                                    <form action="edit_car.php" method="get" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($car['id']) ?>">
                                        <button type="submit" class="edit-btn">Editar</button>
                                    </form>
                                    <form action="delete_car.php" method="get" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja remover este carro?')">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($car['id']) ?>">
                                        <button type="submit" class="delete-btn">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </div>

    <script src="/PAP-Goncalo/admin/assets/js/sidebar.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let rows = document.querySelectorAll(".clickable-row");

            rows.forEach(row => {
                row.addEventListener("click", function (event) {
                    if (!event.target.closest("button")) {
                        window.location.href = this.dataset.href;
                    }
                });
            });
        });
    </script>
</body>
</html>