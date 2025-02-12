<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veículos Disponíveis</title>
    <link rel="stylesheet" href="../css/veiculos.css">
    <script defer src="../js/veiculos.js"></script>
</head>
<body>
    <header>
        <h1>Veículos Disponíveis</h1>
    </header>
    
    <section class="filtros">
        <select id="marcaFilter">
            <option value="">Todas as Marcas</option>
        </select>
        <select id="modeloFilter">
            <option value="">Todos os Modelos</option>
        </select>
        <select id="anoFilter">
            <option value="">Todos os Anos</option>
        </select>
        <select id="precoFilter">
            <option value="">Todos os Preços</option>
            <option value="low">Até 10.000€</option>
            <option value="mid">10.000€ - 30.000€</option>
            <option value="high">Acima de 30.000€</option>
        </select>
        <button onclick="filtrarVeiculos()">Filtrar</button>
    </section>
    
    <section class="veiculos-lista" id="veiculosContainer">
        <!-- Veículos serão carregados aqui via JS -->
    </section>
</body>
</html>
