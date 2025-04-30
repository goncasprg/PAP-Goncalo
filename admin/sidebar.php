<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../admin/assets/css/sidebar.css">
</head>

<body>
  <nav>
    <div class="sidebar-top">
      <a href="#" class="logo__wrapper">
        <img src="../admin/assets/images/logo.svg" alt="Logo" class="logo">
        <h1 class="hide">CarChoice</h1>
      </a>
      <div class="expand-btn">
        <img src="../admin/assets/images/chevron.svg" alt="Chevron">
      </div>
    </div>
    <div class="sidebar-links">
      <ul>
        <li>
          <a href="#dashboard" title="Dashboard" class="tooltip">
            <img src="../admin/assets/images/car_icon.png" alt="Gestão de Viaturas">
            <span class="link hide">Gestão de Viaturas</span>
            <span class="tooltip__content">Gestão de Viaturas</span>
          </a>
        </li>
        <li>
          <a href="#project" title="Project" class="tooltip">
            <img src="../admin/assets/images/analytics.svg" alt="Analytics">
            <span class="link hide">Veículos</span>
            <span class="tooltip__content">Veículos</span>
          </a>
        </li>
        <li>
          <a href="#performance" title="Performance" class="tooltip">
            <img src="../admin/assets/images/performance.svg" alt="Performance">
            <span class="link hide">Anúncios Pendentes</span>
            <span class="tooltip__content">Performance</span>
          </a>
        </li>
        <li>
        </li>
      </ul>
    </div>
    <div class="sidebar-bottom">
      <div class="sidebar-links">
        <ul>
          <li>
            <a href="#help" title="Help" class="tooltip">
              <img src="../admin/assets/images/help.svg" alt="Help">
              <span class="link hide">Help</span>
              <span class="tooltip__content">Help</span>
            </a>
          </li>
          <li>
            <a href="#settings" title="Settings" class="tooltip">
              <img src="../admin/assets/images/settings.svg" alt="Settings">
              <span class="link hide">Settings</span>
              <span class="tooltip__content">Settings</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="sidebar__profile">

        <div class="avatar__name hide">
          <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</span>
          <span><?php echo htmlspecialchars($_SESSION["user_email"]); ?></span>
        </div>
      </div>
    </div>
  </nav>
  <script src="../admin/assets/js/sidebar.js"></script>
</body>

</html>