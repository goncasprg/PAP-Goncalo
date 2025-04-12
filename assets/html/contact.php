<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../css/contact.css">
</head>

<body>

    <div class="contact-container">
        <!-- Texto à esquerda -->
        <div class="contact-text">
            <h1>Fale connosco!</h1>
            <p>Tem alguma dúvida sobre os nossos veículos ou serviços? Estamos aqui para ajudar! Entre em contacto connosco e a nossa equipa responderá o mais rápido possível.</p>
            <p><strong>Email:</strong> pirukacheiroso@gmail.com</p>
            <p><strong>Phone:</strong>  (+351) 966 840 321</p>
        </div>

        <div class="contact-form">
            <h2>Entre em contato</h2>
            <p>Podes entrar em contacto em qualquer momento</p>

            <form action="process_contact.php" method="POST">
                <div class="name-row">
                    <input type="text" name="first_name" placeholder="Primeiro Nome" required>
                    <input type="text" name="last_name" placeholder="Último Nome" required>
                </div>
                <input type="email" name="email" placeholder="Seu email" required>
                <input type="tel" name="phone" placeholder="Número de telefone" required>
                <textarea name="message" placeholder="Como podemos ajudar?" required></textarea>
                <button type="submit">Enviar</button>
                <p class="terms">Ao entrar em contato, você concorda com nossos <a href="#">Termos de Serviço</a> e <a
                        href="#">Política de Privacidade</a>.</p>
            </form>
        </div>
    </div>

</body>

</html>