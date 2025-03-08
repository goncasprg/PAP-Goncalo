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
            <h1>Contact Us</h1>
            <p>Email, call, or complete the form to learn how Snappy can solve your messaging problem.</p>
            <p><strong>Email:</strong> info@snappy.io</p>
            <p><strong>Phone:</strong> 321-221-231</p>
            <a href="#">Customer Support</a>
        </div>

        <div class="contact-form">
            <h2>Entre em contato</h2>
            <p>Pode nos contatar a qualquer momento.</p>

            <form action="process_contact.php" method="POST">
                <div class="form-group">
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