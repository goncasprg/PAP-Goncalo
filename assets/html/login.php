<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login & Registo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
    <script defer src="../js/login.js"></script>
    <script defer src="../login.js"></script>
</head>

<body>
    <div class="container">
        <form id="login-form" class="my-form" action="../php/login.php" method="POST">
            <div class="login-welcome-row">
                <a href="#" title="Logo">
                    <img src="../images/carchoicewht.png" alt="Logo" class="logo">
                </a>
                <h1>Iniciar Sessão</h1>
                <p>Insira os seus dados para entrar</p>
            </div>
            <div class="input__wrapper">
                <input type="email" id="login-email" name="email" class="input__field" required autocomplete="off">
                <label for="login-email" class="input__label">Email</label>
            </div>
            <div class="input__wrapper">
                <input id="login-password" type="password" name="password" class="input__field" required autocomplete="off">
                <label for="login-password" class="input__label">Palavra-passe</label>
            </div>
            <button type="submit" class="my-form__button">Entrar</button>
            <div class="my-form__actions">
                <span>Não tem uma conta?</span>
                <a href="#" id="show-register">Registar</a>
            </div>
    </form>


        <form id="register-form" class="my-form" action="../php/register.php" method="POST">
            <div class="login-welcome-row">
                <a href="#" title="Logo">
                    <img src="../images/carchoicewht.png" alt="Logo" class="logo">
                </a>
                <h1>Cria a tua conta</h1>
                <p>Preencha os campos abaixo para se registar</p>
            </div>
            <div class="input__wrapper">
                <input type="text" id="name" name="name" class="input__field" required autocomplete="off">
                <label for="name" class="input__label">Nome</label>
            </div>
            <div class="input__wrapper">
                <input type="email" id="register-email" name="email" class="input__field" required autocomplete="off">
                <label for="register-email" class="input__label">Email</label>
            </div>
            <div class="input__wrapper">
                <input id="register-password" type="password" name="password" class="input__field" required autocomplete="off">
                <label for="register-password" class="input__label">Palavra-passe</label>
            </div>
            <div class="input__wrapper">
                <input id="confirm-password" type="password" name="confirm_password" class="input__field" required autocomplete="off">
                <label for="confirm-password" class="input__label">Confirmar palavra-passe</label>
            </div>
            <div class="input__wrapper">
                <input type="text" id="phone" name="phone" class="input__field" required autocomplete="off">
                <label for="phone" class="input__label">Telefone</label>
            </div>
            <button type="submit" class="my-form__button">Registar</button>
            <div class="my-form__actions">
                <span>Já tem uma conta?</span>
                <a href="#" id="show-login">Entrar</a>
            </div>
</form>

    </div>
    <script src="../js/script.js"></script>
</body>
</html>