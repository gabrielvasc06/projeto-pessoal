<?php
include "conexao.php";
$id = $_GET['id'];
$sql = "SELECT * FROM pessoa WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<form action="atualizar.php" method="POST">
  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
  email: <input type="text" name="email" value="<?php echo $row['email']; ?>"><br>
  nome_completo: <input type="text" name="nome_completo" value="<?php echo $row['nome_completo']; ?>"><br>
  cep: <input type="text" name="cep" value="<?php echo $row['cep']; ?>"><br>
  endereco: <input type="text" name="endereco" value="<?php echo $row['endereco']; ?>"><br>
  cidade: <input type="text" name="cidade" value="<?php echo $row['cidade']; ?>"><br>
  bairro: <input type="text" name="bairro" value="<?php echo $row['bairro']; ?>"><br>
  estado: <input type="text" name="estado" value="<?php echo $row['estado']; ?>"><br>
  complemento: <input type="text" name="complemento" value="<?php echo $row['complemento']; ?>"><br>
  numero: <input type="text" name="numero" value="<?php echo $row['numero']; ?>"><br>
  <button type="submit">Atualizar</button>
</form>
