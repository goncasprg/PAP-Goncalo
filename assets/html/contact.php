<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PAP-Goncalo/assets/css/contact.css">
    <title>Contactar - CarChoice</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="contact-container">
        <div class="contact-text">
            <h1>Fale connosco!</h1>
            <p>Tem alguma dúvida sobre os nossos veículos ou serviços? Estamos aqui para ajudar! Entre em contacto connosco e a nossa equipa responderá o mais rápido possível.</p>
            <br>
            <p><strong>Email:</strong> suporte@carchoice.com</p>
            <p><strong>Telefone:</strong> (+351) 966 840 321</p>
        </div>

        <div class="contact-form">
            <h2>Entre em contato</h2>
            <p>Podes entrar em contacto em qualquer momento</p>

            <form id="contact-form">
                <div class="name-row">
                    <input type="text" name="first_name" placeholder="Primeiro Nome" required>
                    <input type="text" name="last_name" placeholder="Último Nome" required>
                </div>
                <input type="email" name="email" placeholder="O seu email" required>
                <input type="tel" name="phone" placeholder="Número de telefone" required>
                <textarea name="message" placeholder="Como podemos ajudar?" required></textarea>
                <button type="submit">Enviar</button>
                <p class="terms">Ao entrar em contato, você concorda com nossos <a href="#">Termos de Serviço</a> e <a href="#">Política de Privacidade</a>.</p>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("contact-form");

            form.addEventListener("submit", function (event) {
                event.preventDefault();

                const formData = new FormData(form);

                fetch("https://formspree.io/f/meoepkze", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "Accept": "application/json"
                    }
                }).then(response => {
                    if (response.ok) {
                        alert("Mensagem enviada com sucesso!");
                        window.location.href = "../../index.php";
                    } else {
                        alert("Erro ao enviar a mensagem. Tente novamente.");
                    }
                }).catch(error => {
                    alert("Erro ao conectar com o servidor. Tente novamente.");
                });
            });
        });
    </script>
</body>
</html>
