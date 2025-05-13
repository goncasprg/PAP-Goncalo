<?php
include "./assets/php/db.php";
session_start();

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $notification = '
    <div class="notifications-container">
      <div class="success">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="succes-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
          </div>
          <div class="success-prompt-wrap">
            <p class="success-prompt-heading">Testemunho enviado com sucesso!</p>
            <div class="success-prompt-prompt">
              <p>Obrigado pelo seu feedback! A sua avaliação foi enviada com sucesso.</p>
            </div>
            <div class="success-button-container">
              <button type="button" class="success-button-main" onclick="window.location.href=\'index.php\'">Ver status</button>
              <button type="button" class="success-button-secondary" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()">Fechar</button>
            </div>
          </div>
        </div>
      </div>
    </div>';
}

if (isset($_GET['error'])) {
    if ($_GET['error'] == 'missing_fields') {
        echo "<script>alert('Por favor, preencha todos os campos antes de enviar a avaliação.');</script>";
    } elseif ($_GET['error'] == 'database_error') {
        echo "<script>alert('Ocorreu um erro ao enviar a avaliação. Tente novamente mais tarde.');</script>";
    }
}
?>

<?php
if (isset($notification)) {
    echo $notification;
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
    <link rel="stylesheet" href="./assets/css/notifications.css">
    <link rel="icon" type="image/x-icon" href="./assets/images/carchoicedrk.png" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="assets/js/load_cars.js"></script>
    <title>CarChoice - Stand Automóvel</title>

</head>

<body>

    <!-- Header -->
    <?php include("./assets/html/header.php"); ?>

    <!-- banner -->
    <main class="main">
        <div class="banner">
            <div class="banner-box">
                <h1 class="banner-title">Encontre aqui o seu futuro carro</h1>
            </div>

            <div class="banner-form-container">
    <form action="/PAP-Goncalo/assets/html/veiculos.php" method="GET">
        <select name="brand" id="brand">
            <option value="">Selecione uma marca</option>
            <?php
            $sql = "SELECT * FROM brands ORDER BY brand ASC";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                echo "<option value='" . htmlspecialchars($row['brand']) . "'>" . htmlspecialchars($row['brand']) . "</option>";
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
        <div class="section-cards">
    <h1 class="txt-destaque">Os nossos clientes falam por nós!</h1>
    <div id="reviews-container" class="reviews-container">
        <?php
        function getStarColor($rating) {
            switch ($rating) {
                case 5: return "#edb407";
                case 4: return "#18b473";
                case 3: return "#da8422";
                case 2:
                case 1: return "#ef4444";
                default: return "#e0e0e0"; // caso de erro
            }
        }

        $svgStar = function($filled, $color) {
            $fill = $filled ? $color : "#e0e0e0";
            return '<svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 576 512" fill="' . $fill . '">
                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 
                150.3 51.4 171.5c-12 1.8-22 10.2-25.7 
                21.7s-.7 24.2 7.9 32.7L137.8 329 
                113.2 474.7c-2 12 3 24.2 12.9 
                31.3s23 8 33.8 2.3l128.3-68.5 
                128.3 68.5c10.8 5.7 23.9 4.9 
                33.8-2.3s14.9-19.3 12.9-31.3L438.5 
                329 542.7 225.9c8.6-8.5 11.7-21.2 
                7.9-32.7s-13.7-19.9-25.7-21.7L381.2 
                150.3 316.9 18z" />
            </svg>';
        };

        $sql = "SELECT sr.*, u.first_name 
                FROM stand_reviews sr
                JOIN users u ON sr.user_id = u.id
                ORDER BY sr.created_at DESC
                LIMIT 4";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $rating = (int) $row['rating'];
            $starColor = getStarColor($rating);

            echo "<div class='review'>";
            echo "<div>";
            echo "<h1 class='name-review'>" . htmlspecialchars($row['first_name']) . "</h1>";
            echo "<div class='row-stars-review'>";
            for ($i = 1; $i <= 5; $i++) {
                echo $svgStar($i <= $rating, $starColor);
            }
            echo "</div>";
            echo "</div>";
            echo "<p class='text-review'>" . htmlspecialchars($row['comment']) . "</p>";
            echo "<span class='date-review'>" . date("d/m/Y", strtotime($row['created_at'])) . "</span>";
            echo "</div>";
        }
        ?>
    </div>
</div>



        <div class="titulos-avaliar">
            <h1 class="titulo-avaliar">Também queremos a tua opinião!</h1>
            <h1 class="sub-avaliar">O que tens a dizer do nosso serviço?</h1>
        </div>
        <!-- Formulário de Avaliação -->
        <form class="review-form" action="assets/php/reviews.php" method="POST">
            <div class="rating">
                <input type="radio" id="star5" name="rating" value="5" required />
                <label title="Excelente" for="star5">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                        <path
                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">
                        </path>
                    </svg>
                </label>
                <input type="radio" id="star4" name="rating" value="4" />
                <label title="Muito Bom" for="star4">
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

    </main>

    <!-- Footer -->
    <?php include("./assets/html/footer.php"); ?>

    <!-- Script dos filtros -->
    <script src="./assets/js/script.js"></script>
    <script>
    document.getElementById('brand').addEventListener('change', function () {
        let brand = this.value; // Agora é o nome da marca
        let modelSelect = document.getElementById('model');

        modelSelect.innerHTML = '<option value="">Selecione um modelo</option>';

        if (brand) {
            fetch('./admin/get_models.php?brand=' + encodeURIComponent(brand))
                .then(response => response.json())
                .then(data => {
                    data.forEach(model => {
                        let option = document.createElement('option');
                        option.value = model.model; // Usa o nome do modelo como value
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