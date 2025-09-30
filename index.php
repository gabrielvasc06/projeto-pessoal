<?php
session_start();

// Conexão com o banco
$host = "localhost";
$user = "root";
$password = "root";
$port = 8889;
$dbname  = "check";

$conn = new mysqli($host, $user, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // LOGIN
    if (isset($_POST["login"])) {
        $email = trim($_POST["email"]);
        $senha = trim($_POST["senha"]);

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();

            if (password_verify($senha, $usuario["senha"])) {
                $_SESSION["usuario"] = $usuario["nome"];
                header("Location: inicial.php");
                exit();
            } else {
                $erro = "Senha incorreta.";
            }
        } else {
            $erro = "Usuário não encontrado.";
        }
    }

    // CADASTRO
    if (isset($_POST["cadastro"])) {
        $nome = trim($_POST["nome"]);
        $email = trim($_POST["email"]);
        $senha = password_hash(trim($_POST["senha"]), PASSWORD_DEFAULT);

        // Verificar se já existe usuário
        $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            $erro = "Já existe uma conta com esse e-mail.";
        } else {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nome, $email, $senha);

            if ($stmt->execute()) {
                $sucesso = "Usuário cadastrado com sucesso! Agora faça login.";
            } else {
                $erro = "Erro ao cadastrar. Tente novamente.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LOGIN - SYSTEM </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 25rem; height: 27rem; ">
    <h2 class="text-center mb-3 ">Sistema de Cadastro</h2>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success"><?= $sucesso ?></div>
    <?php endif; ?>

    <!-- Abas -->
    <ul class="nav nav-tabs" id="tabForm" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
                    type="button" role="tab"> <strong> Login </strong></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cadastro-tab" data-bs-toggle="tab" data-bs-target="#cadastro"
                    type="button" role="tab">Cadastro</button>
        </li>
    </ul>

    <!-- Conteúdo das abas -->
    <div class="tab-content mt-3">
        <!-- Form Login -->
        <div class="tab-pane fade show active" id="login" role="tabpanel">
            <form method="post">
                <div class="mb-3">
                    <label> <strong> Email </strong></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label> <strong> Senha </strong></label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn btn-black border border-success w-100 "> Entrar </button>
            </form>
        </div>

        <!-- Form Cadastro -->
        <div class="tab-pane fade" id="cadastro" role="tabpanel">
            <form method="post">
                <div class="mb-3">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <button type="submit" name="cadastro" class="btn btn-success w-100">Cadastrar</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
