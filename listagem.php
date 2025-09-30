<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
session_start();
require_once __DIR__ . '../assets/conexao.php';  // Ajuste o caminho se necessário

// Gere o CSRF token se não existir (igual ao excluir.php)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Dados com Funcionalidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07v4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #000000; }
        .container-tabela { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow-x: auto; max-width: 1200px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 12px 15px; border-bottom: 1px solid #ddd; white-space: nowrap; }
        th { background-color: #f8f8f8; font-weight: bold; color: #333; text-transform: uppercase; }
        tr:hover { background-color: #f5f5f5; }
        .no-data { text-align: center; padding: 50px 0; color: #000000; font-size: 1.2rem; display: none; } /* Esconde por padrão */
        .funcionalidades-header { text-align: center; }
        .funcionalidades-buttons { display: flex; justify-content: center; gap: 10px; margin-top: 20px; }
        .funcionalidades-buttons button { border: none; padding: 10px; border-radius: 6px; cursor: pointer; color: white; font-size: 1rem; transition: transform 0.2s, box-shadow 0.2s; }
        .funcionalidades-buttons button:hover { transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .btn-editar { background-color: #28a745; }
        .btn-atualizar { background-color: #007bff; }
        .btn-excluir { background-color: #dc3545; }
        .btn-voltar { background-color: #6c757d; margin-top: 20px; display: inline-block; padding: 10px 20px; color: white; text-decoration: none; border-radius: 6px; }
        .btn-voltar:hover { color: white; background-color: #5a6268; }
        .btn-row { padding: 5px 10px; margin: 2px; border: none; border-radius: 4px; cursor: pointer; color: white; font-size: 0.9rem; transition: background-color 0.2s; display: inline-flex; align-items: center; justify-content: center; width: 35px; height: 35px; }
        .btn-row.editar { background-color: #28a745; }
        .btn-row.editar:hover { background-color: #218838; }
        .btn-row.excluir { background-color: #dc3545; }
        .btn-row.excluir:hover { background-color: #c82333; }
        /* Estilo para linha de "no data" na tabela */
        .no-data-row td { text-align: center; font-style: italic; color: #666; padding: 50px; }
        .btn-row i { font-size: 1rem; margin: 0; }
        .actions-column { width: 100px; text-align: center; }
    </style>
</head>
<body>
    <div class="container-tabela">
        <h2 style="text-align: center; color: #000;">Listagem de Cadastros</h2>
        <div id="no-data" class="no-data">Nenhum cadastro encontrado.</div>
        <table id="tabela-dados">
            <thead>
                <tr>
                    <th>CÓD</th>
                    <th>EMAIL</th>
                    <th>NOME COMPLETO</th>
                    <th>DATA NASCIMENTO</th>
                    <th>CEP</th>
                    <th>ENDERECO</th>
                    <th>CIDADE</th>
                    <th>BAIRRO</th>
                    <th>ESTADO</th>
                    <th>COMPLEMENTO</th>
                    <th>N°</th>
                    <th class="funcionalidades-header actions-column">FUNCIONALIDADES</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php
                $sql = "SELECT * FROM pessoa ORDER BY id DESC";  // Ordena pelo mais recente
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Adicione id e data-id na <tr> para remoção fácil
                        echo "<tr id='row-" . $row["id"] . "' data-id='" . $row["id"] . "'>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nome_completo"]) . "</td>";
                        // Formata a data de nascimento para dd/mm/yyyy (assumindo que está armazenada como YYYY-MM-DD)
                        $dataFormatada = !empty($row["data_nascimento"]) ? date('d/m/Y', strtotime($row["data_nascimento"])) : '';
                        echo "<td>" . $dataFormatada . "</td>";
                        echo "<td>" . htmlspecialchars($row["cep"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["endereco"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["cidade"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["bairro"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["estado"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["complemento"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["numero"]) . "</td>";
                        echo "<td>";
                        // Botões COM ÍCONES DO BOOTSTRAP (adicionados sem alterar o resto do código)
                        echo '<button class="btn-row editar" data-id="' . $row["id"] . '" data-nome="' . htmlspecialchars($row["nome_completo"]) . '" title="Editar"><i class="bi bi-pencil"></i></button> ';
                        echo '<button class="btn-row excluir" data-id="' . $row["id"] . '" title="Excluir"><i class="bi bi-trash"></i></button>';
                        echo "</td>";
                        echo "</tr>";
                    }
                    // Esconde o div de "no data" se houver registros (via JS abaixo)
                } else {
                    // Se não houver registros, insira uma linha na tabela ou mostre o div
                    echo '<tr class="no-data-row"><td colspan="12">Nenhum cadastro encontrado.</td></tr>';
                }
                $conn->close();  // Boa prática: feche a conexão
                ?>
            </tbody>
        </table>
        
        <!-- Botão para voltar -->
        <a href="inicial.php" class="btn-voltar">Voltar ao Início</a>
    </div>

    <script>
const csrfToken = '<?php echo $_SESSION["csrf_token"]; ?>';  // Gera no PHP e passa para JS

// CORRIGIDO: Path para excluir.php na raiz (sem '../' se listagem na raiz)
const urlExcluir = 'excluir.php';  // <-- AJUSTE: Se excluir.php estiver em /assets/, mude para 'assets/excluir.php'

// Função para excluir um registro específico (chamada pelo event listener)
function excluirRegistro(id) {
    if (!confirm('Deseja excluir este registro? Esta ação não pode ser desfeita.')) {
        return;
    }

    // Debug: Log no console
    console.log('=== DEBUG EXCLUSÃO ===');
    console.log('ID do registro:', id);
    console.log('URL da requisição:', urlExcluir);
    console.log('CSRF Token:', csrfToken ? 'OK' : 'ERRO - Token vazio!');

    // Crie dados para POST
    const data = new URLSearchParams();
    data.append('id', id);
    data.append('csrf_token', csrfToken);

    // Envie AJAX para excluir.php
    fetch(urlExcluir, {
        method: 'POST',
        body: data,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
    .then(response => {
        console.log('Status HTTP:', response.status);  // Debug
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Erro na resposta:', text);
                throw new Error('Erro HTTP ' + response.status + ': ' + text.substring(0, 100));
            });
        }
        return response.json();  // Assuma que excluir.php retorna JSON {success: true, message: '...'}
    })
    .then(data => {
        console.log('Resposta JSON:', data);
        if (data && data.success) {
            // Remove a linha da tabela
            const row = document.getElementById('row-' + id);
            if (row) {
                row.remove();
                console.log('Linha removida (ID: ' + id + ')');
            }
            // Se tabela vazia, adicione mensagem
            const tbody = document.getElementById('tbody');
            if (tbody && tbody.children.length === 0) {
                tbody.innerHTML = '<tr class="no-data-row"><td colspan="12">Nenhum cadastro encontrado.</td></tr>';
            }
            alert(data.message || 'Registro excluído com sucesso!');
        } else {
            alert('Erro na exclusão: ' + (data ? data.message : 'Falha desconhecida'));
        }
    })
    .catch(error => {
        console.error('Erro no fetch:', error);
        alert('Erro de conexão: ' + error.message + '\nVerifique o console (F12).');
    });
}

// Event delegation para cliques (eficiente)
document.addEventListener('DOMContentLoaded', function() {
    console.log('Página carregada. Aguardando cliques...');  // Debug inicial

    document.addEventListener('click', function(e) {
        // Debug: Log todo clique em botão (para testar se detecta)
        if (e.target.closest('.btn-row')) {
            console.log('Clique detectado em botão:', e.target.className, 'ID:', e.target.getAttribute('data-id'));
        }

        // Ação Excluir
        if (e.target.matches('.excluir') || e.target.closest('.excluir')) {
            const button = e.target.matches('.excluir') ? e.target : e.target.closest('.excluir');
            const id = button.getAttribute('data-id');
            console.log('Botão Excluir clicado, ID:', id);  // Debug
            if (id) {
                excluirRegistro(id);
            } else {
                console.error('Sem data-id no botão excluir!');
                alert('Erro: ID não encontrado.');
            }
            e.preventDefault();
            return false;
        }

        // Ação Editar: CORRIGIDO - Path relativo à raiz para /assets/
        if (e.target.matches('.editar') || e.target.closest('.editar')) {
            const button = e.target.matches('.editar') ? e.target : e.target.closest('.editar');
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome') || 'o registro';
            console.log('Botão Editar clicado, ID:', id, 'Nome:', nome);  // Debug
            if (confirm('Deseja editar ' + nome + '?') && id) {
                const urlEditar = 'assets/editar.php?id=' + encodeURIComponent(id);  // Path corrigido para /assets/
                console.log('Redirecionando para:', urlEditar);  // Debug
                window.location.href = urlEditar;
            }
            e.preventDefault();
            return false;
        }
    });

    // Inicializa "no data" se vazio
    const tbody = document.getElementById('tbody');
    const noDataDiv = document.getElementById('no-data');
    if (tbody && tbody.children.length === 0) {
        noDataDiv.style.display = 'block';
    } else {
        noDataDiv.style.display = 'none';
    }
});
</script>


