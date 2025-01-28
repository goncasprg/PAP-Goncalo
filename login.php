<?php
session_start();
include '../assets/php/db.php'; // Caminho ajustado para o arquivo de conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Procurar utilizador pelo email
        $stmt = $pdo->prepare("SELECT id, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar se o utilizador foi encontrado e a senha está correta
        if ($user && password_verify($password, $user['password'])) { // Usando password_verify
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            // Redirecionar conforme o role
            if ($user['role'] === 'admin') {
                header("Location: ../reservations/index.php");
                exit;
            }
        } else {
            // Se as credenciais não forem válidas
            echo "<script>
                alert('Acesso negado!');
                window.location.href = 'index.php';
            </script>";
            exit;
        }

    } catch (PDOException $e) {
        // Caso ocorra erro no banco, exibe um alerta genérico
        echo "<script>
            alert('Erro ao fazer login. Tente novamente mais tarde.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="senha">Password</label>
        <input type="password" name="senha" id="senha">
        <input type="submit" value="Entrar">
    </form>
</body>
</html>