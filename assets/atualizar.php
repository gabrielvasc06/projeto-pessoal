<?php
// /assets/atualizar.php

// ATIVA OS ERROS (remova em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// INICIA A SESSÃO ANTES DE QUALQUER SAÍDA
session_start();

require_once __DIR__ . '/conexao.php';

// 1. VERIFICA O MÉTODO DA REQUISIÇÃO
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro'] = 'Método de requisição inválido.';
    header('Location: ../listagem.php');
    exit;
}

// 2. VERIFICA O TOKEN CSRF
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['erro'] = 'Token de segurança inválido ou expirado.';
    header('Location: ../listagem.php');
    exit;
}

// 3. COLETA E VALIDA OS DADOS
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$nome_completo = trim(filter_input(INPUT_POST, 'nome_completo', FILTER_SANITIZE_STRING));
// Use FILTER_SANITIZE_STRING ou similar para outros campos
$cep = trim($_POST['cep'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$bairro = trim($_POST['bairro'] ?? '');
$estado = trim($_POST['estado'] ?? '');
$complemento = trim($_POST['complemento'] ?? '');
$numero = trim($_POST['numero'] ?? '');

// Validação mínima
if (!$id || empty($email) || empty($nome_completo)) {
    $_SESSION['erro_form'] = 'Campos obrigatórios (ID, email, nome) não podem estar vazios.';
    header('Location: ./editar.php?id=' . $id); // Volta para o formulário de edição
    exit;
}

// 4. PREPARA E EXECUTA A QUERY SQL
$sql = "UPDATE pessoa SET 
        email = ?, nome_completo = ?, cep = ?, endereco = ?, 
        cidade = ?, bairro = ?, estado = ?, complemento = ?, numero = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    // Em produção, logar o erro em vez de exibi-lo
    $_SESSION['erro'] = 'Erro ao preparar a query: ' . $conn->error;
    header('Location: ../listagem.php');
    exit;
}

// O último tipo é 'i' para o ID (inteiro)
$stmt->bind_param("sssssssssi", $email, $nome_completo, $cep, $endereco, $cidade, $bairro, $estado, $complemento, $numero, $id);

// 5. PROCESSA O RESULTADO
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $_SESSION['sucesso'] = 'Cadastro atualizado com sucesso!';
    } else {
        $_SESSION['aviso'] = 'Nenhum dado foi alterado (as informações já estavam atualizadas).';
    }
} else {
    // Em produção, logar o erro
    $_SESSION['erro'] = 'Erro ao executar a atualização: ' . $stmt->error;
}

// 6. FECHA TUDO E REDIRECIONA
$stmt->close();
$conn->close();

header('Location: ../listagem.php');
exit;
?>