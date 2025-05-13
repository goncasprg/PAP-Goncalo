<?php
include __DIR__ . '/../php/db.php'; // Caminho corrigido
session_start();

// Verificar se o ID do carro foi passado na URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php"); // Ajuste o redirecionamento para a raiz
    exit();
}

$car_id = (int)$_GET['id'];

// Buscar informações do carro
$sql = "SELECT * FROM cars WHERE id = :id";
$stmt = getPDO()->prepare($sql);
$stmt->execute(['id' => $car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    header("Location: ../index.php");
    exit();
}

// Buscar imagens do carro
$sql_images = "SELECT image_url FROM car_images WHERE car_id = :car_id";
$stmt_images = getPDO()->prepare($sql_images);
$stmt_images->execute(['car_id' => $car_id]);
$images = $stmt_images->fetchAll(PDO::FETCH_COLUMN);

// Adicionar prefixo /PAP-Goncalo/ ao image_url
$images = array_map(function ($image) {
    return $image ? "/PAP-Goncalo/" . $image : "/PAP-Goncalo/assets/images/carros/default-car.jpg";
}, $images);

if (empty($images)) {
    $images = ["/PAP-Goncalo/assets/images/carros/default-car.jpg"];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vehicle Details - <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></title>
  <link rel="stylesheet" href="../css/car_details.css">
  <link rel="stylesheet" href="../css/footer.css"> <!-- Adicionado CSS do footer -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../../assets/css/header.css">
</head>
<body>
  <!-- Header -->
  <?php include("../html/header.php"); ?>

<div class="container">
  <!-- Car + Info + Form -->
  <div class="header-section">
    <div class="gallery">
      <div class="carousel">
        <button class="prev" onclick="showSlide(-1)">❮</button>
        <?php
        foreach ($images as $index => $image) {
            $active = $index === 0 ? 'active' : '';
            echo "<img src='" . htmlspecialchars($image) . "' class='carousel-image $active' alt='" . htmlspecialchars($car['brand'] . ' ' . $car['model']) . "' onclick='openZoom()'>";
        }
        ?>
        <button class="next" onclick="showSlide(1)">❯</button>
      </div>
      <div class="thumbnails">
        <?php
        foreach ($images as $index => $image) {
            echo "<img src='" . htmlspecialchars($image) . "' onclick='selectImage($index)' alt='Mini " . htmlspecialchars($car['brand']) . "'>";
        }
        ?>
      </div>
    </div>

    <div class="details">
      <div class="title-price">
        <h1><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model'] . ' ' . $car['engine_capacity']); ?></h1>
        <p class="price"><?php echo number_format($car['price'], 2, ',', '.') . ' €'; ?></p>
      </div>
      <p class="year-kms"><?php echo htmlspecialchars($car['registration_year'] . ' • ' . number_format($car['mileage'], 0, ',', '.') . ' km • ' . $car['fuel_type']); ?></p>

      <div class="form-box">
        <p class="contact-text">Tem interesse? Entre em contacto!</p>
        <form class="contact-form" action="../assets/php/contact_form.php" method="POST">
          <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
          <label for="name">Nome</label>
          <input type="text" id="name" name="name" placeholder="Nome" required>
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Email" required>
          <label for="message">Mensagem</label>
          <textarea id="message" name="message" rows="4" placeholder="Escreve aqui a mensagem" required></textarea>
          <button type="submit" class="btn-submit">Enviar Mensagem</button>
          <a href="https://wa.me/351912345678" class="btn-whatsapp" target="_blank">Contacto via WhatsApp</a>
        </form>
      </div>
    </div>
  </div>

  <!-- Additional Info -->
  <div class="additional-info">
    <h2>Características</h2>
    <ul class="car-specs-list">
      <li>
        <i class="fas fa-tachometer-alt"></i>
        <div class="spec-content">
          <span class="spec-title">Quilometragem</span>
          <span class="spec-value"><?php echo number_format($car['mileage'], 0, ',', '.') . ' km'; ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-gas-pump"></i>
        <div class="spec-content">
          <span class="spec-title">Combustível</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['fuel_type']); ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-calendar-alt"></i>
        <div class="spec-content">
          <span class="spec-title">Ano</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['registration_year']); ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-bolt"></i>
        <div class="spec-content">
          <span class="spec-title">Potência</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['power']); ?> hp</span>
        </div>
      </li>
      <li>
        <i class="fas fa-cogs"></i>
        <div class="spec-content">
          <span class="spec-title">Transmissão</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['transmission']); ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-users"></i>
        <div class="spec-content">
          <span class="spec-title">Lugares</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['seats']); ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-door-open"></i>
        <div class="spec-content">
          <span class="spec-title">Portas</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['doors']); ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-palette"></i>
        <div class="spec-content">
          <span class="spec-title">Cor</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['color']); ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-tachometer-alt"></i>
        <div class="spec-content">
          <span class="spec-title">Velocidade Máxima</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['top_speed']); ?> km/h</span>
        </div>
      </li>
      <li>
        <i class="fas fa-tachometer-alt"></i>
        <div class="spec-content">
          <span class="spec-title">Aceleração</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['acceleration']); ?> s</span>
        </div>
      </li>
      <li>
        <i class="fas fa-gas-pump"></i>
        <div class="spec-content">
          <span class="spec-title">Consumo</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['fuel_consumption']); ?> L/100km</span>
        </div>
      </li>
      <li>
        <i class="fas fa-leaf"></i>
        <div class="spec-content">
          <span class="spec-title">Emissões CO2</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['co2_emissions']); ?> g/km</span>
        </div>
      </li>
      <li>
        <i class="fas fa-gas-pump"></i>
        <div class="spec-content">
          <span class="spec-title">Capacidade do Tanque</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['fuel_tank_capacity']); ?> L</span>
        </div>
      </li>
      <li>
        <i class="fas fa-ruler"></i>
        <div class="spec-content">
          <span class="spec-title">Dimensões</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['dimensions']); ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-suitcase"></i>
        <div class="spec-content">
          <span class="spec-title">Capacidade da Bagageira</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['trunk_capacity']); ?> L</span>
        </div>
      </li>
      <li>
        <i class="fas fa-shield-alt"></i>
        <div class="spec-content">
          <span class="spec-title">Garantia</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['warranty']); ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-users"></i>
        <div class="spec-content">
          <span class="spec-title">Donos Anteriores</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['previous_owners']); ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-tools"></i>
        <div class="spec-content">
          <span class="spec-title">Histórico de Manutenção</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['service_history']); ?></span>
        </div>
      </li>
      <li>
        <i class="fas fa-check"></i>
        <div class="spec-content">
          <span class="spec-title">Condição</span>
          <span class="spec-value"><?php echo htmlspecialchars($car['condition']); ?></span>
        </div>
      </li>
    </ul>
  </div>
</div>

<div class="zoom-overlay" id="zoomOverlay">
  <span class="close-btn" onclick="closeZoom()">×</span>
  <button class="prev" onclick="zoomSlide(-1)">❮</button>
  <img src="" alt="Zoomed Image" id="zoomedImage">
  <button class="next" onclick="zoomSlide(1)">❯</button>
</div>

<!-- Footer -->
<!-- <?php include("../html/footer.php"); ?> -->

<script>
  const images = document.querySelectorAll('.carousel-image');
  let current = 0;

  function showSlide(direction) {
    const newIndex = (current + direction + images.length) % images.length;
    images.forEach((img, i) => img.classList.toggle('active', i === newIndex));
    current = newIndex;
    document.getElementById('zoomedImage').src = images[current].src; // Atualiza a imagem no zoom
  }

  function selectImage(index) {
    showSlide(index - current);
    document.getElementById('zoomedImage').src = images[current].src;
    if (!document.getElementById('zoomOverlay').classList.contains('active')) {
      openZoom();
    }
  }

  function openZoom() {
    const overlay = document.getElementById('zoomOverlay');
    overlay.classList.add('active');
    document.getElementById('zoomedImage').src = images[current].src;
  }

  function closeZoom() {
    document.getElementById('zoomOverlay').classList.remove('active');
  }

  function zoomSlide(direction) {
    showSlide(direction);
    document.getElementById('zoomedImage').src = images[current].src;
  }

  document.querySelectorAll('.thumbnails img').forEach((thumb, index) => {
    thumb.addEventListener('click', () => selectImage(index));
  });
</script>
</body>
</html>