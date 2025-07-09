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
                <!-- Linha Superior (4 filtros) -->
                <div class="filters-row">
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

                    <div class="filter-group">
                        <label for="fuel_type">Combustível:</label>
                        <select name="fuel_type" id="fuel_type">
                            <option value="">Todos</option>
                            <?php
                            $sql = "SELECT DISTINCT fuel_type FROM cars WHERE fuel_type IS NOT NULL ORDER BY fuel_type ASC";
                            $stmt = getPDO()->prepare($sql);
                            $stmt->execute();
                            while ($row = $stmt->fetch()) {
                                echo "<option value='" . htmlspecialchars($row['fuel_type']) . "'>" . htmlspecialchars($row['fuel_type']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Linha Inferior (4 filtros) -->
                <div class="filters-row">
                    <div class="filter-group">
                        <label for="registration_year">Ano:</label>
                        <select name="registration_year" id="registration_year">
                            <option value="">Todos</option>
                            <option value="2025-2025">2025</option>
                            <option value="2020-2024">2020-2024</option>
                            <option value="2015-2019">2015-2019</option>
                            <option value="2010-2014">2010-2014</option>
                            <option value="2000-2009">2000-2009</option>
                            <option value="1990-1999">1990-1999</option>
                            <option value="1980-1989">1980-1989</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="price">Preço (€):</label>
                        <select name="price" id="price">
                            <option value="">Todos</option>
                            <option value="0-10000">Até 10.000</option>
                            <option value="10000-20000">10.000 - 20.000</option>
                            <option value="20000-30000">20.000 - 30.000</option>
                            <option value="30000-50000">30.000 - 50.000</option>
                            <option value="50000-100000">50.000 - 100.000</option>
                            <option value="100000-999999">Acima de 100.000</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="mileage">Quilometragem (km):</label>
                        <select name="mileage" id="mileage">
                            <option value="">Todos</option>
                            <option value="0-10000">Até 10.000</option>
                            <option value="10000-50000">10.000 - 50.000</option>
                            <option value="50000-100000">50.000 - 100.000</option>
                            <option value="100000-150000">100.000 - 150.000</option>
                            <option value="150000-200000">150.000 - 200.000</option>
                            <option value="200000-999999">Acima de 200.000</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="power">Potência (CV):</label>
                        <select name="power" id="power">
                            <option value="">Todos</option>
                            <option value="0-100">Até 100</option>
                            <option value="100-150">100 - 150</option>
                            <option value="150-200">150 - 200</option>
                            <option value="200-300">200 - 300</option>
                            <option value="300-500">300 - 500</option>
                            <option value="500-9999">Acima de 500</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="filter-button">Filtrar</button>
            </form>
        </section>

        <!-- Cards das Viaturas -->
        <section class="section-cards">
            <h1 class="txt-destaque">Viaturas disponíveis</h1>
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
            const brand = this.value;
            const modelSelect = document.getElementById('model');
            modelSelect.innerHTML = '<option value="">Todos os modelos</option>';

            if (brand) {
                fetch('../../admin/get_models.php?brand=' + encodeURIComponent(brand))
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(model => {
                            let option = document.createElement('option');
                            option.value = model.model;
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
            const fuel_type = getParameterByName('fuel_type');
            const registration_year = getParameterByName('registration_year');
            const price = getParameterByName('price');
            const mileage = getParameterByName('mileage');
            const power = getParameterByName('power');

            // Preencher o select de marca e carregar modelos
            if (brand) {
                const brandSelect = document.getElementById('brand');
                for (let i = 0; i < brandSelect.options.length; i++) {
                    if (brandSelect.options[i].text === brand) {
                        brandSelect.selectedIndex = i;
                        break;
                    }
                }
                brandSelect.dispatchEvent(new Event('change'));
            }

            // Preencher os outros selects
            const selects = { model, transmission, fuel_type, registration_year, price, mileage, power };
            for (const [key, value] of Object.entries(selects)) {
                if (value) {
                    const selectElement = document.getElementById(key);
                    for (let i = 0; i < selectElement.options.length; i++) {
                        if (selectElement.options[i].value === value) {
                            selectElement.selectedIndex = i;
                            break;
                        }
                    }
                }
            }

            let url = '../../assets/php/get_cars.php';
            const params = new URLSearchParams();
            if (brand) params.append('brand', brand);
            if (model) params.append('model', model);
            if (transmission) params.append('transmission', transmission);
            if (fuel_type) params.append('fuel_type', fuel_type);
            if (registration_year) params.append('registration_year', registration_year);
            if (price) params.append('price', price);
            if (mileage) params.append('mileage', mileage);
            if (power) params.append('power', power);

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
            const fuelTypeSelect = document.getElementById('fuel_type');
            const registrationYearSelect = document.getElementById('registration_year');
            const priceSelect = document.getElementById('price');
            const mileageSelect = document.getElementById('mileage');
            const powerSelect = document.getElementById('power');

            const brand = brandSelect.options[brandSelect.selectedIndex].text;
            const model = modelSelect.value || '';
            const transmission = transmissionSelect.value || '';
            const fuel_type = fuelTypeSelect.value || '';
            const registration_year = registrationYearSelect.value || '';
            const price = priceSelect.value || '';
            const mileage = mileageSelect.value || '';
            const power = powerSelect.value || '';

            let url = '../../assets/php/get_cars.php';
            const params = new URLSearchParams();
            if (brand && brand !== 'Todas as marcas') params.append('brand', brand);
            if (model && model !== 'Todos os modelos') params.append('model', model);
            if (transmission && transmission !== 'Todas') params.append('transmission', transmission);
            if (fuel_type && fuel_type !== 'Todos') params.append('fuel_type', fuel_type);
            if (registration_year && registration_year !== 'Todos') params.append('registration_year', registration_year);
            if (price && price !== 'Todos') params.append('price', price);
            if (mileage && mileage !== 'Todos') params.append('mileage', mileage);
            if (power && power !== 'Todos') params.append('power', power);

            if (params.toString()) {
                url += '?' + params.toString();
                window.history.pushState({}, '', '?' + params.toString());
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
    <script src="../../assets/js/script.js"></script>
</body>

</html>