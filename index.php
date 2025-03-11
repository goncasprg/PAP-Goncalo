<?php
include "./assets/php/db.php";
session_start();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="./assets/css/header.css" />
    <link rel="stylesheet" href="./assets/css/banner.css" />
    <link rel="stylesheet" href="./assets/css/cards.css" />
    <link rel="stylesheet" href="./assets/css/footer.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="./assets/css/contactar.css" />
    <link rel="icon" type="image/x-icon" href="./assets/images/carchoicedrk.png" />
    <script src="https://kit.fontawesome.com/YOUR_FONT_AWESOME_KIT.js" crossorigin="anonymous"></script>
    <script src="assets/js/load_cars.js"></script>
    <title>CarChoice - Stand Automóvel</title>
</head>

<body>
    <header class="header" id="header">
        <a href="index.php" class="nav-logo">
            <img src="./assets/images/carchoicedrk.png" alt="Logo CarChoice" />
        </a>
        <nav class="nav-bar">
            <ul class="nav-list">
                <li class="nav-item"><a href="index.php" class="nav-link">Início</a></li>
                <li class="nav-item"><a href="./assets/html/veiculos.php" class="nav-link">Viaturas</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Comparar</a></li>
                <li class="nav-item"><a href="./assets/html/sobre_nos.html" class="nav-link">Sobre Nós</a></li>
                <li class="nav-item"><a href="./assets/html/contactar.php" class="nav-link">Contactar</a></li>
            </ul>
        </nav>

        <?php if (isset($_SESSION["user_id"])): ?>
        <div class="user-menu">
            <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</span>
            <a href="./assets/php/logout.php" class="logout-button" title="Logout">
                <i class="fa-solid fa-sign-out-alt"></i>
            </a>
        </div>
        <?php else: ?>
        <a href="./assets/html/login.php" class="login-button" title="Login">Entrar</a>
        <?php endif; ?>
    </header>

    <main class="main">
        <div class="banner">
            <div class="banner-box">
                <h1 class="banner-title">Encontre aqui o seu futuro carro</h1>
            </div>

            <div class="banner-form-container">
                <form action="veiculos.php" method="GET">
                    <select name="brand" id="brand">
                        <option value="">Selecione uma marca</option>
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
                        <option value="">Selecione um modelo</option>
                    </select>

                    <select name="transmission">
                        <option value="">Transmissão</option>
                        <option value="Automática">Automática</option>
                        <option value="Manual">Manual</option>
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

            <h1 class="txt-destaque">Viaturas em Destaque</h1>
            <div id="cards-container" class="cards-container">
                <?php include("./assets/html/cards.php"); ?>
            </div>
        </section>
    </main>

    <?php include("./assets/html/footer.php"); ?>

    <script>
    document.getElementById('brand').addEventListener('change', function() {
        let brand = this.value;
        let modelSelect = document.getElementById('model');

        modelSelect.innerHTML = '<option value="">Selecione um modelo</option>';

        if (brand) {
            fetch('./admin/get_models.php?brand=' + encodeURIComponent(brand))
                .then(response => response.json())
                .then(data => {
                    data.forEach(model => {
                        let option = document.createElement('option');
                        option.value = model.id;
                        option.textContent = model.model;
                        modelSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao buscar modelos:', error));
        }
    });
    </script>
</body>

</html>