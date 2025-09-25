<?php
// /assets/editar.php

session_start();
require_once __DIR__ . '/conexao.php';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['erro'] = 'ID inválido.';
    header('Location: ../listagem.php');
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM pessoa WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['erro'] = 'Registro não encontrado.';
    header('Location: ../listagem.php');
    exit;
}

$row = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #000000; padding: 20px; color: #000; }
        .form-container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 500px; margin: 0 auto; }
        h2 { text-align: center; margin-bottom: 20px; }
        input[type="text"] { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-voltar, .btn-atualizar { padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; color: white; border: none; cursor: pointer; }
        .btn-voltar { background-color: #6c757d; margin-right: 10px; }
        .btn-voltar:hover { background-color: #5a6268; color: white; }
        .btn-atualizar { background-color: #007bff; }
        .btn-atualizar:hover { background-color: #0056b3; }
        .alert { margin-bottom: 20px; padding: 15px; border-radius: 4px; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Editar Cadastro</h2>
        
        <?php if (isset($_SESSION['erro_form'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['erro_form']; unset($_SESSION['erro_form']); ?></div>
        <?php endif; ?>

        <form action="./atualizar.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            
            Email: <input type="text" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br>
            Nome Completo: <input type="text" name="nome_completo" value="<?php echo htmlspecialchars($row['nome_completo']); ?>" required><br>
            CEP: <input type="text" name="cep" value="<?php echo htmlspecialchars($row['cep']); ?>"><br>
            Endereço: <input type="text" name="endereco" value="<?php echo htmlspecialchars($row['endereco']); ?>"><br>
            Cidade: <input type="text" name="cidade" value="<?php echo htmlspecialchars($row['cidade']); ?>"><br>
            Bairro: <input type="text" name="bairro" value="<?php echo htmlspecialchars($row['bairro']); ?>"><br>
            Estado: <input type="text" name="estado" value="<?php echo htmlspecialchars($row['estado']); ?>"><br>
            Complemento: <input type="text" name="complemento" value="<?php echo htmlspecialchars($row['complemento']); ?>"><br>
            Número: <input type="text" name="numero" value="<?php echo htmlspecialchars($row['numero']); ?>"><br>
            
            <a href="../listagem.php" class="btn-voltar">Voltar</a>
            <button type="submit" class="btn-atualizar">Atualizar</button>
        </form>
    </div>
</body>
</html>