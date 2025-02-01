<?php 
    require_once 'db.php';

    function createTable($table, $fields) {
        global $pdo;
        $sql = "CREATE TABLE IF NOT EXISTS $table ($fields)";
        $pdo->exec($sql);
        echo "Tabela $table criada com sucesso!";
    }
    createTable('cars', 'utilizador VARCHAR(16)');
    
?>