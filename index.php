<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/banner.css">
    <link rel="stylesheet" href="./assets/css/cards.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/contactar.css">
    <link rel="icon" type="image/x-icon" href="./assets/images/carchoicedrk.png">
    <title>CarChoice - Stand Automóvel</title>
</head>
<body>
    <header class="header" id="header">
        <a href="" class="nav-logo"><img src="./assets/images/carchoicedrk.png" alt="Logo CarChoice"></a>
        <nav class="nav-bar">
            <ul class="nav-list">
                <li class="nav-item"><a href="" class="nav-link">Início</a></li>
                <li class="nav-item"><a href="" class="nav-link">Viaturas</a></li>
                <li class="nav-item"><a href="" class="nav-link">Comparar</a></li>
                <li class="nav-item"><a href="./assets/html/sobre_nos.html" class="nav-link">Sobre Nós</a></li>
            </ul>
        </nav>
        <a href="./assets/html/contactar.php" class="nav-button">Contactar</a>
    </header>
    
    <main class="main">
        <div class="banner">
            <div class="banner-box">
                <div class="banner-box-text">
                    <h3 class="banner-subtitle">Confira as nossas novidades diárias</h3>
                    <h1 class="banner-title">Encontre aqui o seu futuro carro</h1>
                </div>

                <form action="">
                    <select name="" id="">
                        <option value="">Marca</option>
                        <option value="">Modelo</option>
                        <option value="">Ano</option>
                        <option value="">Preço</option>
                    </select>
                    <select name="" id="">
                        <option value="">Marca</option>
                        <option value="">Modelo</option>
                        <option value="">Ano</option>
                        <option value="">Preço</option>
                    </select>
                    <select name="" id="">
                        <option value="">Marca</option>
                        <option value="">Modelo</option>
                        <option value="">Ano</option>
                        <option value="">Preço</option>
                    </select>
                    <input type="submit" value="Pesquisar" class="banner-button">  
                </form>
            </div>
        </div>
        
        <section class="section-cards">
            <h1 class="txt-destaque">Viaturas em Destaque</h1>
            <div id="cards-container" class="cards-container">
                <?php include("./assets/html/cards.php");  ?>
            </div>
        </section>
    </main>
    <?php 
        include("./assets/html/footer.php"); 
    ?>
</body>
</html>
