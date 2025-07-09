<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se a página atual é index.php
$headerClass = (basename($_SERVER['PHP_SELF']) === 'index.php') ? 'header-index' : 'header-other';
?>

<div class="header-mobile">
    <a href="/PAP-Goncalo/index.php" class="nav-logo-mobile">
        <img src="/PAP-Goncalo/assets/images/carchoicedrk.png" alt="Logo CarChoice">
    </a>
    <div class="btn-open-menu">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<header class="header <?php echo $headerClass; ?>" id="header">
    <a href="/PAP-Goncalo/index.php" class="nav-logo">
        <img src="/PAP-Goncalo/assets/images/carchoicedrk.png" alt="Logo CarChoice">
    </a>
    <nav class="nav-bar">
        <ul class="nav-list">
            <li class="nav-item"><a href="/PAP-Goncalo/index.php" class="nav-link">Início</a></li>
            <li class="nav-item"><a href="/PAP-Goncalo/assets/html/veiculos.php" class="nav-link">Viaturas</a></li>
            <li class="nav-item"><a href="/PAP-Goncalo/assets/html/comparar.php" class="nav-link">Comparar</a></li>
            <li class="nav-item"><a href="/PAP-Goncalo/assets/html/about_us.php" class="nav-link">Sobre Nós</a></li>
            <li class="nav-item"><a href="/PAP-Goncalo/assets/html/contact.php" class="nav-link">Contactar</a></li>
        </ul>
    </nav>
    
    <div class="btn-close-menu">
        <span></span>
        <span></span>
    </div>
    <?php if (isset($_SESSION["user_id"])): ?>
        <div class="user-menu">
            <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</span>
            <a href="/PAP-Goncalo/assets/php/logout.php" class="logout-button" title="Logout">
                <i class="fa-solid fa-sign-out-alt"></i>
            </a>
        </div>
    <?php else: ?>
        <a href="/PAP-Goncalo/assets/html/login.php" class="login-button" title="Login">Entrar</a>
    <?php endif; ?>
</header>