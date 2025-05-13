<?php
include "../../assets/php/db.php"; // Ajuste o caminho relativo para subir até a raiz
session_start();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarChoice - Viaturas do Stand</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/cards.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/veiculos.css"> <!-- Novo arquivo CSS -->
    <link rel="icon" type="image/x-icon" href="../../assets/images/carchoicedrk.png">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="../../assets/js/load_cars.js" defer></script>
    <script src="../../assets/js/filter_cars.js" defer></script>
</head>

<body>

    <!-- Header -->
    <?php include("../../assets/html/header.php"); ?>

    <main class="main">
        <!-- Filtros -->
        <section class="filters-section">
            <form id="filter-form" action="javascript:void(0);" method="GET">
                <div class="filter-group">
                    <label for="brand">Marca:</label>
                    <select name="brand" id="brand">
                        <option value="">Todas as marcas</option>
                        <?php
                        $sql = "SELECT id, brand FROM brands ORDER BY brand ASC";
                        $stmt = getPDO()->prepare($sql);
                        $stmt->execute();
                        while ($row = $stmt->fetch()) {
                            echo "<option value='" . htmlspecialchars($row['brand']) . "'>" . htmlspecialchars($row['brand']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="model">Modelo:</label>
                    <select name="model" id="model">
                        <option value="">Todos os modelos</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="transmission">Transmissão:</label>
                    <select name="transmission" id="transmission">
                        <option value="">Todas</option>
                        <option value="Automática">Automática</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>

                <button type="submit" class="filter-button">Filtrar</button>
            </form>
        </section>

        <!-- Cards das Viaturas -->
        <section class="section-cards">
            <h1 class="txt-destaque">Viaturas do Stand</h1>
            <div id="cards-container" class="cards-container"></div>
        </section>
    </main>

    <!-- Footer -->
    <?php include("../../assets/html/footer.php"); ?>

    <script>
        // Função para obter parâmetros da URL
        function getParameterByName(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Carregar modelos dinamicamente ao mudar a marca
        document.getElementById('brand').addEventListener('change', function () {
            const brand = this.value; // ID da marca
            const modelSelect = document.getElementById('model');
            modelSelect.innerHTML = '<option value="">Todos os modelos</option>';

            if (brand) {
                fetch('../../admin/get_models.php?brand=' + encodeURIComponent(brand))
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(model => {
                            let option = document.createElement('option');
                            option.value = model.model; // Usa o nome do modelo
                            option.textContent = model.model;
                            modelSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Erro ao buscar modelos:', error));
            }
        });

        // Carregar carros com base nos filtros da URL ao carregar a página
        window.addEventListener('load', function () {
            const brand = getParameterByName('brand');
            const model = getParameterByName('model');
            const transmission = getParameterByName('transmission');

            // Preencher o select de marca se houver brand na URL
            if (brand) {
                const brandSelect = document.getElementById('brand');
                for (let i = 0; i < brandSelect.options.length; i++) {
                    if (brandSelect.options[i].text === brand) {
                        brandSelect.selectedIndex = i;
                        break;
                    }
                }
                // Carregar modelos correspondentes
                brandSelect.dispatchEvent(new Event('change'));
            }

            // Preencher os outros selects se houver valores na URL
            if (model) {
                const modelSelect = document.getElementById('model');
                for (let i = 0; i < modelSelect.options.length; i++) {
                    if (modelSelect.options[i].value === model) {
                        modelSelect.selectedIndex = i;
                        break;
                    }
                }
            }
            if (transmission) {
                const transmissionSelect = document.getElementById('transmission');
                for (let i = 0; i < transmissionSelect.options.length; i++) {
                    if (transmissionSelect.options[i].value === transmission) {
                        transmissionSelect.selectedIndex = i;
                        break;
                    }
                }
            }

            let url = '../../assets/php/get_cars.php';
            const params = new URLSearchParams();
            if (brand) params.append('brand', brand);
            if (model) params.append('model', model);
            if (transmission) params.append('transmission', transmission);

            if (params.toString()) {
                url += '?' + params.toString();
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('cards-container');
                    container.innerHTML = '';
                    if (data.error) {
                        console.error('Erro ao carregar os carros:', data.error);
                        return;
                    }
                    if (data.length === 0) {
                        container.innerHTML = '<p class="txt-destaque" style="text-align: center;">Nenhum carro encontrado com os filtros selecionados.</p>';
                        return;
                    }
                    data.forEach(car => {
                        const imageUrl = car.image_url ? `/PAP-Goncalo/${car.image_url}` : '/PAP-Goncalo/assets/images/carros/default-car.jpg';
                        const card = document.createElement('div');
                        card.classList.add('card');
                        card.innerHTML = `
                        <div class="card-img" style="background-image: url('${imageUrl}');"></div>
                        <div class="card-info">
                            <p class="text-title">${car.brand} ${car.model}</p>
                            <p class="text-body">${car.engine_capacity}L ${car.fuel_type}</p>
                            <div class="car-details">
                                <span><i class="fas fa-calendar-alt"></i> ${car.registration_year}</span>
                                <span><i class="fas fa-road"></i> ${car.mileage} km</span>
                                <span><i class="fas fa-cogs"></i> ${car.transmission}</span>
                            </div>
                            <p class="price-text">Preço</p>
                            <p class="text-price">${car.price}€</p>
                        </div>
                        <button class="card-button" onclick="window.location.href='/PAP-Goncalo/assets/html/car_details.php?id=${car.id}'">Saber mais</button>
                    `;
                        container.appendChild(card);
                    });
                })
                .catch(error => console.error('Erro ao carregar os carros:', error));
        });

        // Evento de filtragem manual
        document.getElementById('filter-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const brandSelect = document.getElementById('brand');
            const modelSelect = document.getElementById('model');
            const transmissionSelect = document.getElementById('transmission');

            const brand = brandSelect.options[brandSelect.selectedIndex].text; // Usa o texto (nome da marca)
            const model = modelSelect.value || ''; // Usa o valor (nome do modelo)
            const transmission = transmissionSelect.value || '';

            let url = '../../assets/php/get_cars.php';
            const params = new URLSearchParams();
            if (brand && brand !== 'Todas as marcas') params.append('brand', brand);
            if (model && model !== 'Todos os modelos') params.append('model', model);
            if (transmission && transmission !== 'Todas') params.append('transmission', transmission);

            if (params.toString()) {
                url += '?' + params.toString();
                window.history.pushState({}, '', '?' + params.toString()); // Atualiza a URL sem recarregar
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('cards-container');
                    container.innerHTML = '';
                    if (data.error) {
                        console.error('Erro ao carregar os carros:', data.error);
                        return;
                    }
                    if (data.length === 0) {
                        container.innerHTML = '<p class="txt-destaque" style="text-align: center;">Nenhum carro encontrado com os filtros selecionados.</p>';
                        return;
                    }
                    data.forEach(car => {
                        const imageUrl = car.image_url ? `/PAP-Goncalo/${car.image_url}` : '/PAP-Goncalo/assets/images/carros/default-car.jpg';
                        const card = document.createElement('div');
                        card.classList.add('card');
                        card.innerHTML = `
                        <div class="card-img" style="background-image: url('${imageUrl}');"></div>
                        <div class="card-info">
                            <p class="text-title">${car.brand} ${car.model}</p>
                            <p class="text-body">${car.engine_capacity}L ${car.fuel_type}</p>
                            <div class="car-details">
                                <span><i class="fas fa-calendar-alt"></i> ${car.registration_year}</span>
                                <span><i class="fas fa-road"></i> ${car.mileage} km</span>
                                <span><i class="fas fa-cogs"></i> ${car.transmission}</span>
                            </div>
                            <p class="price-text">Preço</p>
                            <p class="text-price">${car.price}€</p>
                        </div>
                        <button class="card-button" onclick="window.location.href='/PAP-Goncalo/assets/html/car_details.php?id=${car.id}'">Saber mais</button>
                    `;
                        container.appendChild(card);
                    });
                })
                .catch(error => console.error('Erro ao carregar os carros:', error));
        });
    </script>
</body>

</html>