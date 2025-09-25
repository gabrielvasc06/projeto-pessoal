<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servidor = "localhost:8888";
$usuario = "root";
$senha = "root";  // Altere se necessário
$banco = "check";  // Seu nome de banco

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
} else {
    echo "Conexão OK! Banco: " . $banco;

    
    $result = $conn->query("SHOW TABLES LIKE 'pessoa'");
    if ($result->num_rows > 0) {
        echo "<br>Tabela 'pessoa' existe!";
    } else {
        echo "<br>Tabela 'pessoa' NÃO existe. Crie-a no phpMyAdmin.";
    }
}

$conn->close();
?>