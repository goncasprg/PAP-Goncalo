<?php
require_once '../assets/php/db.php';

header('Content-Type: application/json');

$sql = "SELECT id, marca, modelo, descricao, ano, km, transmissao, preco, imagem FROM veiculos";
$result = $conn->query($sql);

$veiculos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $veiculos[] = $row;
    }
}

echo json_encode($veiculos);

$conn->close();
?>
