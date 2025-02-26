<?php
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
    <!-- Font Awesome -->
    <title>CarChoice - Stand Automóvel</title>
</head>
<script src="assets/js/load_cars.js"></script>

<body>
    <header class="header" id="header">
        <a href="index.php" class="nav-logo"><img src="./assets/images/carchoicedrk.png" alt="Logo CarChoice" /></a>
        <nav class="nav-bar">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Início</a>
                </li>
                <li class="nav-item">
                    <a href="./assets/html/veiculos.php" class="nav-link">Viaturas</a>
                </li>
                <li class="nav-item"><a href="#" class="nav-link">Comparar</a></li>
                <li class="nav-item">
                    <a href="./assets/html/sobre_nos.html" class="nav-link">Sobre Nós</a>
                </li>
                <li class="nav-item">
                    <a href="./assets/html/contactar.php" class="nav-link">Contactar</a>
                </li>
            </ul>
        </nav>

        <?php if (isset($_SESSION["user_id"])): ?>
        <div class="user-menu">
            <span>Bem-vindo,
                <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</span>
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
                <h3 class="banner-subtitle"></h3>
                <h1 class="banner-title">Encontre aqui o seu futuro carro</h1>
            </div>

            <div class="banner-form-container">
                <form action="veiculos.php" method="GET">
                    <select name="brand">
                        <option value="">Marca</option>
                        <option value="Audi">Audi</option>
                        <option value="BMW">BMW</option>
                        <option value="Mercedes">Mercedes</option>
                        <option value="Nissan">Nissan</option>
                        <option value="Volkswagen">Volkswagen</option>
                    </select>

                    <select name="model">
                        <option value="">Modelo</option>
                        <option value="A3">A3</option>
                        <option value="Série 3">Série 3</option>
                        <option value="Classe C">Classe C</option>
                        <option value="Qashqai">Qashqai</option>
                        <option value="Golf">Golf</option>
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
                <a href="assets/html/veiculos.php"><img src="assets/images/marcas/volkswagen.png" alt="Mercedes"></a>
                <a href="assets/html/veiculos.php"><img src="assets/images/marcas/nissan.png" alt="BMW"></a>
            </div>
            <h1 class="txt-destaque">Viaturas em Destaque</h1>
            <div id="cards-container" class="cards-container">
                <?php include("./assets/html/cards.php");  ?>
            </div>
        </section>
    </main>
    <?php 
        include("./assets/html/footer.php"); 
    ?>
    <script src="assets/js/script.js"></script>
</body>

</html>