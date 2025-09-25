<?php
include "conexao.php";

$id             = $_POST['id'];
$email          = $_POST['email'];
$nome_completo  = $_POST['nome_completo'];
$data_nascimento= $_POST['data_nascimento'];
$cep            = $_POST['cep'];
$endereco       = $_POST['endereco'];
$cidade         = $_POST['cidade'];
$bairro         = $_POST['bairro'];
$estado         = $_POST['estado'];
$complemento    = $_POST['complemento'];
$numero         = $_POST['numero'];

$sql = "UPDATE pessoa SET 
        email='$email',
        nome_completo='$nome_completo',
        data_nascimento='$data_nascimento',
        cep='$cep',
        endereco='$endereco',
        cidade='$cidade',
        bairro='$bairro',
        estado='$estado',
        complemento='$complemento',
        numero='$numero'
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: listagem.php");
} else {
    echo "Erro: " . $conn->error;
}
$conn->close();
?>

