<?php
session_start();
require_once '../assets/php/db.php';
//require_once 'check_admin.php';

// Verifica se o usuário é um administrador
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

// Buscar os comentários (reviews) na base de dados
$pdo = getPDO();
$stmt = $pdo->query("SELECT r.id, r.user_id, u.first_name, u.last_name, r.rating, r.comment, r.created_at FROM stand_reviews r LEFT JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <h1>Gestão de avaliações</h1>
        </header>

        <section class="dashboard">
            <h2>Lista de avaliações</h2>
            <?php if (empty($reviews)): ?>
                <p>Nenhuma avaliação encontrada.</p>
            <?php else: ?>
                <style>
                .comment-cell {
                    max-width: 340px;
                    white-space: pre-line;
                    word-break: break-word;
                    overflow-wrap: break-word;
                }
                @media (max-width: 700px) {
                  .comment-cell { max-width: 160px; }
                }
                </style>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Utilizador</th>
                            <th>Avaliação</th>
                            <th>Comentário</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                            <tr>
                                <td><?= htmlspecialchars($review['id']) ?></td>
                                <td><?= htmlspecialchars(($review['first_name'] ?? '') . ' ' . ($review['last_name'] ?? '')) ?></td>
                                <td><?= htmlspecialchars($review['rating']) ?></td>
                                <td class="comment-cell"><?= nl2br(htmlspecialchars($review['comment'])) ?></td>
                                <td><?= htmlspecialchars($review['created_at']) ?></td>
                                <td>
                                    <form action="delete_comentario.php" method="post" style="display:inline;" class="delete-form">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($review['id']) ?>">
                                        <button type="button" class="delete-btn" onclick="showDeleteModal(this.form, 'Tem certeza que deseja remover esta avaliação?')">Remover</button>
                                    </form>
    <div id="modal-backdrop" style="display:none;"></div>
    <div id="delete-modal" style="display:none;">
        <div id="delete-modal-content">
            <p id="delete-modal-message"></p>
            <div style="margin-top:18px;display:flex;gap:16px;justify-content:center;">
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
        background:#fff;padding:32px 28px 24px 28px;border-radius:12px;box-shadow:0 8px 32px #0003;min-width:320px;max-width:90vw;text-align:center;}
    </style>
    <script>
    let deleteFormToSubmit = null;
    function showDeleteModal(form, message) {
        deleteFormToSubmit = form;
        document.getElementById('delete-modal-message').textContent = message;
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