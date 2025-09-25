<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/cep.js" defer></script>
    <title>Formulário de Cadastro</title>
    <style>
       
        body {
  font-family: Arial, sans-serif;
  background-color: #000000;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
  padding: 115px;
}

.form-container {
  background-color: #fff;
  padding: 30px 40px;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  width: 100%;
  max-width: 420px;
}

h2 {
  text-align: center;
  color: #000000;
  margin-bottom: 25px;
  font-size: 1.4rem;
}

.form-group {
  margin-bottom: 15px;
}

.form-group input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 1rem;
  color: #000000ff;
}

.form-group input:focus {
  outline: none;
  border-color: #0059ffff;
  box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.25);
}

.terms-container {
  display: flex;
  align-items: center;
  margin-bottom: 25px;
  font-size: 0.9rem;
}

.terms-container input[type="checkbox"] {
  margin-right: 8px;
}

.terms-container a {
  color: #007bff;
  text-decoration: none;
}

.terms-container a:hover {
  text-decoration: underline;
}

.button-group {
  display: flex;
  justify-content: space-between;
  gap: 20px;
}

.button-group button {
  width: 50%;
  padding: 12px;
  font-size: 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: background-color 0.3s ease;
}

.button-group .btn-back {
  background-color: #1c64c2ff;
  color: #fff;
  border-radius: 20px;
}

.button-group .btn-back:hover {
  background-color: #0011ffff;
}

.button-group .btn-submit {
  background-color: #000000ff;
  color: #ffffffff;
  border-radius: 20px;
}

.button-group .btn-submit:hover {
  background-color: #0f00e0ff;
}

.btn-back::before {
  content: "⬅️";
}

.btn-submit::before {
  content: "➡️";
}

.date-input::after {
  content: "";
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  pointer-events: none;
}

    
    </style>
</head>
<body>
    <div class="form-container"  >
        <h2>CADASTRO DE INFORMAÇÕES:</h2>
        <form action="./assets/salvar.php" method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Digite o e-mail" required>
            </div>
            <div class="form-group">
                <input type="text" id="nome_completo" name="nome_completo" placeholder="Nome Completo" required>
            </div>
            <div class="form-group" style="position: relative;">
                <input type="date" id="data_nascimento" name="data_nascimento" placeholder="dd/mm/aaaa" required class="date-input">
            </div>
            <div class="form-group">
                <input type="text" id="cep" name="cep" placeholder="Informe o CEP de sua residência" required>
            </div>
            <div class="form-group">
                <input type="text" id="endereco" name="endereco" placeholder="Endereço" required>
            </div>
            <div class="form-group">
                <input type="text" id="cidade" name="cidade" placeholder="Cidade" required>
            </div>
            <div class="form-group">
                <input type="text" id="bairro" name="bairro" placeholder="Bairro" required>
            </div>
            <div class="form-group">
                <input type="text" id="estado" name="estado" placeholder="Estado" required>
            </div>
            <div class="form-group">
                <input type="text" id="complemento" name="complemento" placeholder="Apartamento, Bloco, Lote, etc" required>
            </div>
            <div class="form-group">
                <input type="text" id="numero" name="numero" placeholder="N°" required>
            </div>
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 8px;">
                <span style="white-space: nowrap;">
                Aceito os <a href="#">termos</a> <input type="checkbox" style="width: 20px"; >
                </span>
                </label>


            </div>
            <div class="button-group">
                <a class="btn-back" href="index.php" style="width: 50%; display: flex; justify-content: center; align-items: center; text-decoration: none; padding: 11px; border-radius: 20px; background-color: #000000ff; color: #fff;"> Voltar </a>
                <button type="submit" class="btn-submit"> Enviar </button>
            </div>
        </form>
    </div>
</body>
</html>