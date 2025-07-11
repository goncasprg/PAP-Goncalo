<?php
session_start();
require_once '../assets/php/db.php';
//require_once 'check_admin.php';

// Verifica se o usuário é um administrador
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

// Buscar os utilizadores na base de dados
$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="/PAP-Goncalo/admin/assets/css/sidebar.css">
    <link rel="stylesheet" href="/PAP-Goncalo/admin/assets/css/admin.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="container">
        <header>
            <h1>Gestão de Utilizadores</h1>
        </header>

        <section class="dashboard">
            <h2>Lista de Utilizadores</h2>
            <?php if (empty($users)): ?>
                <p>Nenhum utilizador encontrado.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Role</th>
                            <th>Criado em</th>
                            <th>Atualizado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Count admins only once
                        $adminCount = 0;
                        foreach ($users as $u) {
                            if ($u['role'] === 'admin') $adminCount++;
                        }
                        foreach ($users as $user): 
                            $isOnlyAdmin = ($user['role'] === 'admin' && $adminCount === 1);
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['first_name']) ?> <?= htmlspecialchars($user['last_name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['phone']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td><?= htmlspecialchars($user['created_at']) ?></td>
                                <td><?= htmlspecialchars($user['updated_at']) ?></td>
                                <td>
                                    <form action="edit_user.php" method="get" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                                        <button type="submit" class="edit-btn">Editar</button>
                                    </form>
                                    <form action="delete_user.php" method="get" style="display:inline;" class="delete-form">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                                        <button type="button" class="delete-btn" 
                                            <?php if ($isOnlyAdmin): ?>
                                                onclick="showDeleteModal(null, 'Não é possível remover o único administrador do sistema. Adicione outro administrador antes de remover este.')"
                                            <?php else: ?>
                                                onclick="showDeleteModal(this.form, 'Tem certeza que deseja remover este utilizador?')"
                                            <?php endif; ?>
                                        >Remover</button>
                                    </form>
    <div id="modal-backdrop" style="display:none;"></div>
    <div id="delete-modal" style="display:none;">
        <div id="delete-modal-content">
            <p id="delete-modal-message" style="margin-top:10px;"></p>
            <div id="ok-modal-actions" style="margin-top:18px;display:none;justify-content:center;">
                <button id="ok-modal-btn" style="background:#eee;color:#222;padding:8px 22px;border:none;border-radius:6px;font-weight:700;cursor:pointer;">OK</button>
            </div>
            <div id="delete-modal-actions" style="margin-top:18px;display:flex;gap:16px;justify-content:center;">
                <button id="confirm-delete-btn" style="background:#d32f2f;color:#fff;padding:8px 22px;border:none;border-radius:6px;font-weight:700;cursor:pointer;">Remover</button>
                <button id="cancel-delete-btn" style="background:#eee;color:#222;padding:8px 22px;border:none;border-radius:6px;font-weight:700;cursor:pointer;">Cancelar</button>
            </div>
        </div>
    </div>
    <style>
    #modal-backdrop {
        position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.25);z-index:1000;backdrop-filter: blur(2px);}
    #delete-modal {
        position:fixed;top:0;left:0;width:100vw;height:100vh;display:flex;align-items:center;justify-content:center;z-index:1001;}
    #delete-modal-content {
        position:relative;
        background:#fff;padding:32px 28px 24px 28px;border-radius:12px;box-shadow:0 8px 32px #0003;min-width:320px;max-width:90vw;text-align:center;}
    #close-modal-btn:hover { color: #d32f2f; }
    </style>
    <script>
let deleteFormToSubmit = null;
function showDeleteModal(form, message) {
    deleteFormToSubmit = form;
    const msgElem = document.getElementById('delete-modal-message');
    const okActions = document.getElementById('ok-modal-actions');
    if (!form) {
        msgElem.innerHTML = '<span style="color:#d32f2f;font-weight:bold;font-size:1.1em;">&#9888;&#65039; ' + message + '</span>';
        document.getElementById('delete-modal-actions').style.display = 'none';
        okActions.style.display = 'flex';
    } else {
        msgElem.textContent = message;
        document.getElementById('delete-modal-actions').style.display = 'flex';
        okActions.style.display = 'none';
    }
    document.getElementById('modal-backdrop').style.display = 'block';
    document.getElementById('delete-modal').style.display = 'flex';
}
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('confirm-delete-btn').onclick = function() {
        if (deleteFormToSubmit) deleteFormToSubmit.submit();
        document.getElementById('modal-backdrop').style.display = 'none';
        document.getElementById('delete-modal').style.display = 'none';
    };
    document.getElementById('cancel-delete-btn').onclick = function() {
        document.getElementById('modal-backdrop').style.display = 'none';
        document.getElementById('delete-modal').style.display = 'none';
        deleteFormToSubmit = null;
    };
    document.getElementById('ok-modal-btn').onclick = function() {
        document.getElementById('modal-backdrop').style.display = 'none';
        document.getElementById('delete-modal').style.display = 'none';
        deleteFormToSubmit = null;
    };
});
    </script>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </div>

    <script src="/PAP-Goncalo/admin/assets/js/sidebar.js"></script>
</body>
</html>