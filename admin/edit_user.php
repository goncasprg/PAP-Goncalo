<?php
require_once '../assets/php/db.php';
require_once 'protect.php';


$pdo = getPDO();
if (!isset($_GET["id"])) {
    die("ID do utilizador não especificado.");
}

$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilizador não encontrado.");
}


// Check if this is the only admin
$isOnlyAdmin = false;
if ($user['role'] === 'admin') {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'admin'");
    $stmt->execute();
    $adminCount = $stmt->fetchColumn();
    if ($adminCount == 1) {
        $isOnlyAdmin = true;
    }
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields = ["first_name", "last_name", "email", "phone", "role"];
    $values = [];
    foreach ($fields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            $errors[] = "O campo \"$field\" é obrigatório.";
        } else {
            $values[] = $_POST[$field];
        }
    }
    if (empty($errors)) {
        $values[] = $id;
        $stmt = $pdo->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=?, role=? WHERE id=?");
        $stmt->execute($values);
        header("Location: users.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Utilizador</title>
    <link rel="stylesheet" href="assets/css/edit_car.css">
</head>

<body>
    <h1>Editar Utilizador</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; font-weight: bold;">
            <p>⚠️ Preencha todos os campos obrigatórios antes de continuar:</p>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="edit_user.php?id=<?= $id ?>" method="post">
        <input type="text" name="first_name" placeholder="Primeiro Nome" value="<?= htmlspecialchars($user['first_name']) ?>" required>
        <input type="text" name="last_name" placeholder="Último Nome" value="<?= htmlspecialchars($user['last_name']) ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <input type="text" name="phone" placeholder="Telefone" value="<?= htmlspecialchars($user['phone']) ?>" required>
        <select name="role" required>
            <option value="client" <?= $user['role'] == 'client' ? 'selected' : '' ?> <?= ($isOnlyAdmin && $user['role'] == 'admin') ? 'disabled' : '' ?>>Cliente</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <?php if ($isOnlyAdmin && $user['role'] == 'admin'): ?>
            <div style="color: #d32f2f; font-weight: bold; margin: 10px 0 0 0;">⚠️ Não é possível remover o único administrador do sistema.</div>
        <?php endif; ?>
        <button type="submit">Salvar Alterações</button>
        <a href="users.php" class="btn-cancel">Cancelar</a>
    </form>
</body>

</html>