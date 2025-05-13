<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vehicle Details</title>
  <link rel="stylesheet" href="../css/car_details.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container">
  <!-- Car + Info + Form -->
  <div class="header-section">
    <div class="gallery">
      <div class="carousel">
        <button class="prev" onclick="showSlide(-1)">❮</button>
        <img src="/PAP-Goncalo/assets/images/carros/Audi_A3.jpg" class="carousel-image active" alt="Audi A3" onclick="openZoom()">
        <img src="/PAP-Goncalo/assets/images/carros/BMW_Serie3.jpg" class="carousel-image" alt="BMW Série 3" onclick="openZoom()">
        <img src="/PAP-Goncalo/assets/images/carros/VW_Golf.jpg" class="carousel-image" alt="VW Golf" onclick="openZoom()">
        <button class="next" onclick="showSlide(1)">❯</button>
      </div>
      <div class="thumbnails">
        <img src="/PAP-Goncalo/assets/images/carros/Audi_A3.jpg" onclick="selectImage(0)" alt="Mini Audi">
        <img src="/PAP-Goncalo/assets/images/carros/BMW_Serie3.jpg" onclick="selectImage(1)" alt="Mini BMW">
        <img src="/PAP-Goncalo/assets/images/carros/VW_Golf.jpg" onclick="selectImage(2)" alt="Mini Golf">
      </div>
    </div>

    <div class="details">
      <div class="title-price">
        <h1>Audi A3 1.6 TDI</h1>
        <p class="price">15.990 €</p>
      </div>
      <p class="year-kms">2018 • 120.000 km • Diesel</p>

      <div class="form-box">
        <p class="contact-text">Tem interesse? Entre em contacto!</p>
        <form class="contact-form">
          <label for="name">Nome</label>
          <input type="text" id="name" placeholder="Nome" required>

          <label for="email">Email</label>
          <input type="email" id="email" placeholder="Email" required>

          <label for="message">Mensagem</label>
          <textarea id="message" rows="4" placeholder="Escreve aqui a mensagem" required></textarea>
          <button type="submit" class="btn-submit">Enviar Mensagem</button>
          <a href="https://wa.me/351912345678" class="btn-whatsapp" target="_blank">Contacto via WhatsApp</a>
        </form>
      </div>
    </div>
  </div>

  <!-- Additional Info -->
  <div class="additional-info">
    <h2>Caracteristicas</h2>
    <ul class="car-specs-list">
      <li>
        <i class="fas fa-tachometer-alt"></i>
        <div class="spec-content">
          <span class="spec-title">Quilometragem</span>
          <span class="spec-value">87,000 km</span>
        </div>
      </li>
      <li>
        <i class="fas fa-gas-pump"></i>
        <div class="spec-content">
          <span class="spec-title">Combustível</span>
          <span class="spec-value">Elétrico</span>
        </div>
      </li>
      <li>
        <i class="fas fa-calendar-alt"></i>
        <div class="spec-content">
          <span class="spec-title">Mês/Ano</span>
          <span class="spec-value">Fev/2019</span>
        </div>
      </li>
      <li>
        <i class="fas fa-bolt"></i>
        <div class="spec-content">
          <span class="spec-title">Potência</span>
          <span class="spec-value">60 hp</span>
        </div>
      </li>
      <li>
        <i class="fas fa-cogs"></i>
        <div class="spec-content">
          <span class="spec-title">Transmissão</span>
          <span class="spec-value">Automática</span>
        </div>
      </li>
      <li>
        <i class="fas fa-users"></i>
        <div class="spec-content">
          <span class="spec-title">Lugares</span>
          <span class="spec-value">2</span>
        </div>
      </li>
      <li>
        <i class="fas fa-car-side"></i>
        <div class="spec-content">
          <span class="spec-title">Tipo</span>
          <span class="spec-value">Comercial Leve</span>
        </div>
      </li>
      <li>
        <i class="fas fa-door-open"></i>
        <div class="spec-content">
          <span class="spec-title">Portas</span>
          <span class="spec-value">5</span>
        </div>
      </li>
      <li>
        <i class="fas fa-boxes"></i>
        <div class="spec-content">
          <span class="spec-title">Fornecedor</span>
          <span class="spec-value">Gestora de Frota</span>
        </div>
      </li>
      <li>
        <i class="fas fa-palette"></i>
        <div class="spec-content">
          <span class="spec-title">Cor</span>
          <span class="spec-value">Branco</span>
        </div>
      </li>
      <li>
        <i class="fas fa-flag"></i>
        <div class="spec-content">
          <span class="spec-title">Origem</span>
          <span class="spec-value">Nacional</span>
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

<script>
  const images = document.querySelectorAll('.carousel-image');
  let current = 0;

  function showSlide(direction) {
    const newIndex = (current + direction + images.length) % images.length;
    images.forEach((img, i) => img.classList.toggle('active', i === newIndex));
    current = newIndex;
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