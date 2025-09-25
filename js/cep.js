document.addEventListener("DOMContentLoaded", () => {
  const cepInput = document.getElementById("cep");

  cepInput.addEventListener("blur", () => { // evento ao sair do campo
    let cep = cepInput.value.replace(/\D/g, "");

    if (cep.length === 8) {
      fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
          if (!data.erro) {
            document.getElementById("endereco").value = data.logradouro;
            document.getElementById("cidade").value = data.localidade;
            document.getElementById("bairro").value = data.bairro;
            document.getElementById("estado").value = data.uf;
          } else {
            alert("CEP não encontrado!");
          }
        })
        .catch(() => alert("Erro ao buscar CEP!"));
    }
  });
});

