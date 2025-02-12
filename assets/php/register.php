<?php
require_once 'db.php'; // Conectar à base de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? null;
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;
    $confirm_password = $_POST["confirm_password"] ?? null;
    $phone = $_POST["phone"] ?? null;

    // Verificar se todos os campos estão preenchidos
    if (!$name || !$email || !$password || !$confirm_password || !$phone) {
        die("Erro: Todos os campos são obrigatórios.");
    }

    // Verificar se as senhas coincidem
    if ($password !== $confirm_password) {
        die("Erro: As palavras-passe não coincidem.");
    }

    // Hash da senha
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo = getPDO(); // Obtém a conexão PDO

        // Preparar e executar a inserção no banco de dados
        $stmt = $pdo->prepare("INSERT INTO users (first_name, email, password, phone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password, $phone]);

        echo "Registro concluído com sucesso!";
    } catch (PDOException $e) {
        die("Erro ao registrar: " . $e->getMessage());
    }
}
?>
