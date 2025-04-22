<?php
include "./assets/php/db.php";
session_start();

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>alert('Avaliação enviada com sucesso!');</script>";
}

if (isset($_GET['error'])) {
    if ($_GET['error'] == 'missing_fields') {
        echo "<script>alert('Por favor, preencha todos os campos antes de enviar a avaliação.');</script>";
    } elseif ($_GET['error'] == 'database_error') {
        echo "<script>alert('Ocorreu um erro ao enviar a avaliação. Tente novamente mais tarde.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

    <!-- Header -->
    <header class="header" id="header">
        <a href="index.php" class="nav-logo">
            <img src="./assets/images/carchoicedrk.png" alt="Logo CarChoice" />
        </a>
        <nav class="nav-bar">
            <ul class="nav-list">
                <li class="nav-item"><a href="index.php" class="nav-link">Início</a></li>
                <li class="nav-item"><a href="./assets/html/veiculos.php" class="nav-link">Viaturas</a></li>
                <li class="nav-item"><a href="./assets/html/comparar.php" class="nav-link">Comparar</a></li>
                <li class="nav-item"><a href="./assets/html/sobre_nos.php" class="nav-link">Sobre Nós</a></li>
                <li class="nav-item"><a href="./assets/html/contact.php" class="nav-link">Contactar</a></li>
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

    <!-- banner -->
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
        <!-- Logo das marcas -->
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
            </div>
        </section>

        <!-- Avaliações -->
        <h1 class="txt-destaque">Avaliações</h1>
        <form action="/assets/php/reviews.php" method="POST">
            <div class="rating">
                <input type="radio" id="star5" name="rating" value="5" required />
                <label title="Excelente!" for="star5">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                        <path
                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                        </path>
                    </svg>
                </label>
                <input type="radio" id="star4" name="rating" value="4" />
                <label title="Muito bom!" for="star4">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                        <path
                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                        </path>
                    </svg>
                </label>
                <input type="radio" id="star3" name="rating" value="3" />
                <label title="Bom" for="star3">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                        <path
                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                        </path>
                    </svg>
                </label>
                <input type="radio" id="star2" name="rating" value="2" />
                <label title="Razoável" for="star2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                        <path
                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                        </path>
                    </svg>
                </label>
                <input type="radio" id="star1" name="rating" value="1" />
                <label title="Mau" for="star1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                        <path
                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                        </path>
                    </svg>
                </label>
            </div>
            <br>
            <textarea name="comment" rows="4" cols="50" placeholder="Diz-nos a tua opinião sobre o stand!"
                required></textarea>
            <br><br>
            <button type="submit">Enviar Avaliação</button>
        </form>
        <div class="section-cards">
            <div id="reviews-container" class="reviews-container">
                <?php
                $sql = "SELECT * FROM reviews ORDER BY created_at DESC";
                $stmt = getPDO()->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch()) {
                    echo "<div class='review'>";
                    echo "<p><strong>" . htmlspecialchars($row['created_at']) . "</strong></p>";
                    echo "<p>" . htmlspecialchars($row['comment']) . "</p>";
                    echo "<p>Avaliação: " . htmlspecialchars($row['rating']) . " estrelas</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>


    </main>

    <!-- Footer -->
    <?php include("./assets/html/footer.php"); ?>

    <!-- Script dos filtros -->
    <script src="./assets/js/script.js"></script>
    <script>
        document.getElementById('brand').addEventListener('change', function () {
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