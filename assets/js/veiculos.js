document.addEventListener("DOMContentLoaded", function () {
    carregarVeiculos();

    document.getElementById("marcaFilter").addEventListener("change", filtrarVeiculos);
    document.getElementById("modeloFilter").addEventListener("change", filtrarVeiculos);
    document.getElementById("anoFilter").addEventListener("change", filtrarVeiculos);
    document.getElementById("precoFilter").addEventListener("change", filtrarVeiculos);
});

function carregarVeiculos() {
    fetch("../api/get_veiculos.php")
        .then(response => response.json())
        .then(data => {
            mostrarVeiculos(data);
            preencherFiltros(data);
        })
        .catch(error => console.error("Erro ao carregar veículos:", error));
}

function mostrarVeiculos(veiculos) {
    const container = document.getElementById("veiculosContainer");
    container.innerHTML = "";

    veiculos.forEach(veiculo => {
        const card = document.createElement("div");
        card.classList.add("card");
        card.innerHTML = `
            <div class="card-img" style="background-image: url('${veiculo.imagem}');"></div>
            <div class="card-info">
                <p class="text-title">${veiculo.marca} ${veiculo.modelo}</p>
                <p class="text-body">${veiculo.descricao}</p>
                <div class="car-details">
                    <span><i class="fas fa-calendar-alt"></i> ${veiculo.ano}</span>
                    <span><i class="fas fa-road"></i> ${veiculo.km} km</span>
                    <span><i class="fas fa-cogs"></i> ${veiculo.transmissao}</span>
                </div>
                <p class="price-text">Preço</p>
                <p class="text-price">${veiculo.preco}€</p>
            </div>
            <button class="card-button">Saber mais</button>
        `;
        container.appendChild(card);
    });
}

function preencherFiltros(veiculos) {
    const marcas = [...new Set(veiculos.map(v => v.marca))];
    const modelos = [...new Set(veiculos.map(v => v.modelo))];
    const anos = [...new Set(veiculos.map(v => v.ano))];

    preencherOpcoes("marcaFilter", marcas);
    preencherOpcoes("modeloFilter", modelos);
    preencherOpcoes("anoFilter", anos);
}

function preencherOpcoes(id, opcoes) {
    const select = document.getElementById(id);
    select.innerHTML = `<option value="">Todos</option>`;
    opcoes.forEach(op => {
        const option = document.createElement("option");
        option.value = op;
        option.textContent = op;
        select.appendChild(option);
    });
}

function filtrarVeiculos() {
    const marca = document.getElementById("marcaFilter").value;
    const modelo = document.getElementById("modeloFilter").value;
    const ano = document.getElementById("anoFilter").value;
    const preco = document.getElementById("precoFilter").value;

    fetch("../api/get_veiculos.php")
        .then(response => response.json())
        .then(data => {
            let filtrados = data;

            if (marca) filtrados = filtrados.filter(v => v.marca === marca);
            if (modelo) filtrados = filtrados.filter(v => v.modelo === modelo);
            if (ano) filtrados = filtrados.filter(v => v.ano == ano);
            if (preco) {
                filtrados = filtrados.filter(v => {
                    if (preco === "low") return v.preco <= 10000;
                    if (preco === "mid") return v.preco > 10000 && v.preco <= 30000;
                    if (preco === "high") return v.preco > 30000;
                });
            }

            mostrarVeiculos(filtrados);
        })
        .catch(error => console.error("Erro ao filtrar veículos:", error));
}
