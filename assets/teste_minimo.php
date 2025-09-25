<?php
// Ativar erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "1. Início do script OK<br>";

// Teste session
session_start();
echo "2. Session_start OK. Token: " . (isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : 'Não definido') . "<br>";

// Teste require conexao.php
require_once __DIR__ . '/conexao.php';
echo "3. Require conexao.php OK<br>";

// Teste se $conn existe
if (isset($conn)) {
    echo "4. Variável \$conn existe. Erro de conexão: " . ($conn->connect_error ?? 'Nenhum') . "<br>";
} else {
    echo "ERRO: \$conn não definida em conexao.php!<br>";
}

// Teste POST simulado (para ver se bind funciona)
if (isset($_POST['id'])) {
    echo "5. POST recebido: ID = " . $_POST['id'] . "<br>";
} else {
    echo "5. Nenhum POST (normal em teste direto)<br>";
}

echo "6. Script terminou sem erro fatal!<br>";
?>