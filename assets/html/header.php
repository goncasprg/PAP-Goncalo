<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel="stylesheet" href="../css/header.css">
<header class="header" id="header">
    <a href="/PAP-Goncalo/index.php" class="nav-logo">
        <img src="/PAP-Goncalo/assets/images/carchoicedrk.png" alt="Logo CarChoice" />

    </a>
    <nav class="nav-bar">
        <ul class="nav-list">
            <li class="nav-item"><a href="/PAP-Goncalo/index.php" class="nav-link">Início</a></li>
            <li class="nav-item"><a href="/PAP-Goncalo/assets/html/veiculos.php" class="nav-link">Viaturas</a></li>
            <li class="nav-item"><a href="/PAP-Goncalo/assets/html/comparar.php" class="nav-link">Comparar</a></li>
            <li class="nav-item"><a href="/PAP-Goncalo/assets/html/sobre_nos.php" class="nav-link">Sobre Nós</a></li>
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
