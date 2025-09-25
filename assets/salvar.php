<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../assets/conexao.php';  // Inclui a conexão (ajuste o caminho se necessário)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega os dados do formulário
    $email = $_POST['email'] ?? '';
    $nome_completo = $_POST['nome_completo'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $cep = $_POST['cep'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $complemento = $_POST['complemento'] ?? '';
    $numero = $_POST['numero'] ?? '';

    // Validação básica (opcional, mas recomendado)
    if (empty($email) || empty($nome_completo) || empty($data_nascimento)) {
        die("Erro: Campos obrigatórios não preenchidos!");
    }

    // Insere no BD (prepara a query para evitar SQL Injection)
    $sql = "INSERT INTO pessoa (email, nome_completo, data_nascimento, cep, endereco, cidade, bairro, estado, complemento, numero) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $email, $nome_completo, $data_nascimento, $cep, $endereco, $cidade, $bairro, $estado, $complemento, $numero);

    if ($stmt->execute()) {
        // Sucesso: Redireciona para listagem.php
        echo "Dados salvos com sucesso!";
        header("Location: ../listagem.php");
        exit();  // Para o script aqui
    } else {
        die("Erro ao salvar: " . $conn->error);
    }

    $stmt->close();
}

$conn->close();

?>
