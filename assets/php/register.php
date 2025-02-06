<?php 
    session_start();
    include './db.php'; // Caminho ajustado para o arquivo de conexão com o banco de dados

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];

        // Verificar se as senhas são iguais
        if ($password !== $confirmPassword) {
            echo "<script>
                alert('As senhas não coincidem!');
                window.location.href = 'index.php';
            </script>";
            exit;
        }

        try {
            // Verificar se o email já está em uso
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                echo "<script>
                    alert('Este email já está em uso!');
                    window.location.href = 'index.php';
                </script>";
                exit;
            }

            // Criar novo utilizador
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]); // Usando password_hash

            // Redirecionar para a página de login
            echo "<script>
                alert('Conta criada com sucesso!');
                window.location.href = 'index.php';
            </script>";
            exit;

        } catch (PDOException $e) {
            // Caso ocorra erro no banco, exibe um alerta genérico
            echo "<script>
                alert('Erro ao criar conta. Tente novamente mais tarde.');
                window.location.href = 'index.php';
            </script>";
            exit;
        }
    }
?>