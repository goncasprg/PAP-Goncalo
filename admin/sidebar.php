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
        <a href="../assets/php/logout.php" class="logout-btn" title="Logout"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(180)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9.00195 7C9.01406 4.82497 9.11051 3.64706 9.87889 2.87868C10.7576 2 12.1718 2 15.0002 2L16.0002 2C18.8286 2 20.2429 2 21.1215 2.87868C22.0002 3.75736 22.0002 5.17157 22.0002 8L22.0002 16C22.0002 18.8284 22.0002 20.2426 21.1215 21.1213C20.2429 22 18.8286 22 16.0002 22H15.0002C12.1718 22 10.7576 22 9.87889 21.1213C9.11051 20.3529 9.01406 19.175 9.00195 17" stroke-width="3" stroke-linecap="round"></path> <path d="M15 12L2 12M2 12L5.5 9M2 12L5.5 15" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></a>
      </div>
    </div>
  </nav>
  <script src="../admin/assets/js/sidebar.js"></script>
</body>

</html>