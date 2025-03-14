<?php
include "../php/db.php";
session_start();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <link rel="stylesheet" href="./assets/css/header.css" />

</head>

<body>
    <main class="main">
        <div class="banner">
            <div class="banner-box">
                <h1 class="banner-title">Está indeciso?</h1>
                <h2>Use a nossa ferramenta de comparação!</h2>
            </div>

            <div class="banner-form-container">
                <form action="veiculos.php" method="GET">
                    <select name="brand" id="brand">
                        <option value="">Selecione um carro</option>
                        <?php
                        $sql = "SELECT * FROM brands ORDER BY brand ASC";
                        $stmt = getPDO()->prepare($sql);
                        $stmt->execute();

                        while ($row = $stmt->fetch()) {
                            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['brand']) . "</option>";
                        }
                        ?>
                    </select>

                    <select name="model" id="model">
                        <option value="">Selecione um carro</option>
                        <?php
                        $sql = "SELECT * FROM brands ORDER BY brand ASC";
                        $stmt = getPDO()->prepare($sql);
                        $stmt->execute();

                        while ($row = $stmt->fetch()) {
                            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['brand']) . "</option>";
                        }
                        ?>
                    </select>

                    <input type="submit" value="Pesquisar" class="banner-button" />
                </form>
            </div>
        </div>

        <section class="section-cards">
            <div class="brand-container">
                <a href="assets/html/veiculos.php"><img src="assets/images/marcas/audi.png" alt="Audi"></a>
                <a href="assets/html/veiculos.php"><img src="assets/images/marcas/bmw.png" alt="BMW"></a>
                <a href="assets/html/veiculos.php"><img src="assets/images/marcas/mercedes.png" alt="Mercedes"></a>
                <a href="assets/html/veiculos.php"><img src="assets/images/marcas/volkswagen.png" alt="Volkswagen"></a>
                <a href="assets/html/veiculos.php"><img src="assets/images/marcas/nissan.png" alt="Nissan"></a>
            </div>
            <div id="cards-container" class="cards-container">
                <?php include("./assets/html/cards.php"); ?>
            </div>
        </section>
    </main>
</body>

</html>