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
        .btn-row { padding: 5px 10px; margin: 2px; border: none; border-radius: 4px; cursor: pointer; color: white; font-size: 0.9rem; transition: background-color 0.2s; }
        .btn-row.editar { background-color: #28a745; }
        .btn-row.editar:hover { background-color: #218838; }
        .btn-row.excluir { background-color: #dc3545; }
        .btn-row.excluir:hover { background-color: #c82333; }
        /* Estilo para linha de "no data" na tabela */
        .no-data-row td { text-align: center; font-style: italic; color: #666; padding: 50px; }
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
                    <th class="funcionalidades-header">FUNCIONALIDADES</th>
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
                        // Botões SEM onclick (usaremos event delegation). Adicione data-id para consistência
                        echo '<button class="btn-row editar" data-id="' . $row["id"] . '" data-nome="' . htmlspecialchars($row["nome_completo"]) . '">Editar</button> ';
                        echo '<button class="btn-row excluir" data-id="' . $row["id"] . '">Excluir</button>';
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
        <a href="index.php" class="btn-voltar">Voltar ao Início</a>
    </div>

    <script>
    const csrfToken = '<?php echo $_SESSION["csrf_token"]; ?>';  // Gera no PHP e passa para JS

    // AJUSTE AQUI: Como excluir.php está na RAIZ e listagem.php em /rjz/, use '../excluir.php' para subir um nível
    const urlExcluir = '../excluir.php';  // <-- Isso resolve o 404. Se a subpasta for mais profunda, use '../../excluir.php'

    // Função para excluir um registro específico (chamada pelo event listener)
    function excluirRegistro(id) {
        if (!confirm('Deseja excluir este registro? Esta ação não pode ser desfeita.')) {
            return;
        }

        // Debug: Log no console (veja no F12 > Console para diagnosticar)
        console.log('=== DEBUG EXCLUSÃO ===');
        console.log('ID do registro:', id);
        console.log('URL da requisição:', urlExcluir);
        console.log('URL base da página:', window.location.href);
        console.log('CSRF Token:', csrfToken ? 'OK (presente)' : 'ERRO - Token vazio!');

        // Crie dados para POST (use URLSearchParams para simplicidade)
        const data = new URLSearchParams();
        data.append('id', id);
        data.append('csrf_token', csrfToken);

        // Envie AJAX para excluir.php
        fetch(urlExcluir, {
            method: 'POST',
            body: data,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',  // Para URLSearchParams
            }
        })
        .then(response => {
            // Debug: Log da resposta HTTP
            console.log('Status HTTP recebido:', response.status);
            console.log('Resposta OK?', response.ok);
            console.log('Content-Type da resposta:', response.headers.get('Content-Type'));  // Deve ser 'application/json'

            if (!response.ok) {
                // Se erro HTTP (ex.: 404, 403, 500), pegue o texto para ver o erro exato (HTML ou JSON)
                return response.text().then(text => {
                    console.error('Resposta de erro completa (pode ser HTML de PHP):', text);  // <-- AQUI VOCÊ VE O ERRO EXATO!
                    throw new Error(`Erro HTTP ${response.status}: ${response.statusText}\n\nConteúdo da resposta (primeiros 300 chars):\n${text.substring(0, 300)}...`);
                });
            }

            // Se OK, tente parsear como JSON. Se falhar (ex.: HTML de erro), pegue o texto
            return response.text().then(text => {
                if (text.trim().startsWith('{')) {  // Verifica se parece JSON
                    return JSON.parse(text);
                } else {
                    console.error('Resposta não é JSON válido (pode ser HTML de erro PHP):', text);
                    throw new Error(`Resposta inválida (não é JSON):\n${text.substring(0, 300)}...`);
                }
            });
        })
        .then(data => {
            // Se chegou aqui, data é o JSON parseado
            console.log('Resposta JSON parseada com sucesso:', data);

            if (data.success) {
                // Remove a linha específica da tabela
                const row = document.getElementById('row-' + id);
                if (row) {
                    row.remove();
                    console.log('Linha removida do DOM (ID: row-' + id + ').');
                } else {
                    console.warn('Linha não encontrada no DOM (ID: row-' + id + ').');
                }

                // Verifica se a tabela ficou vazia e adiciona mensagem
                const tbody = document.getElementById('tbody');
                if (tbody && tbody.children.length === 0) {
                    const noDataRow = document.createElement('tr');
                    noDataRow.className = 'no-data-row';
                    noDataRow.innerHTML = '<td colspan="12">Nenhum cadastro encontrado.</td>';
                    tbody.appendChild(noDataRow);
                    console.log('Adicionada linha de mensagem "no data" na tabela.');
                }

                alert(data.message || 'Registro excluído com sucesso!');
                console.log('=== EXCLUSÃO BEM-SUCEDIDA ===');
            } else {
                console.error('Erro no backend (success: false):', data.message);
                alert('Erro na exclusão: ' + (data.message || 'Falha desconhecida. Verifique o console.'));
            }
        })
        .catch(error => {
            console.error('Erro na requisição AJAX:', error);
            alert('Erro de conexão ou processamento:\n\n' + error.message + '\n\nAbra F12 > Console para ver detalhes completos e o erro do servidor.');
        });
    }

    // Event delegation: Um listener para todos os cliques na página (eficiente para botões dinâmicos)
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Página carregada. Event listeners adicionados.');  // Debug inicial

        document.addEventListener('click', function(e) {
            // Ação Excluir: Verifica se o alvo é um botão .excluir
            if (e.target.matches('.excluir')) {
                const id = e.target.getAttribute('data-id');
                if (id) {
                    console.log('Botão Excluir clicado para ID:', id);  // Debug
                    excluirRegistro(id);  // Chama a função com o ID específico
                } else {
                    console.error('Botão Excluir sem data-id!');
                    alert('ID do registro não encontrado no botão.');
                }
                e.preventDefault();  // Evita comportamentos padrão do botão
                return false;
            }

            // Ação Editar: Redireciona para editar.php com ID
            if (e.target.matches('.editar')) {
                const id = e.target.getAttribute('data-id');
                const nome = e.target.getAttribute('data-nome') || 'o registro';
                if (confirm('Deseja editar ' + nome + '?') && id) {
                    console.log('Redirecionando para editar.php?id=' + id);  // Debug
                    window.location.href = 'editar.php?id=' + encodeURIComponent(id);
                }
                e.preventDefault();
                return false;
            }
        });

        // Inicializa "no data" se a tabela estiver vazia (para casos iniciais)
        const tbody = document.getElementById('tbody');
        const noDataDiv = document.getElementById('no-data');
        const tabela = document.getElementById('tabela-dados');
        if (tbody && tbody.children.length === 0) {
            if (noDataDiv) {
                noDataDiv.style.display = 'block';
            }
            if (tabela) {
                tabela.style.display = 'none';  // Opcional: esconde tabela vazia
            }
            console.log('Tabela vazia: Mensagem "no data" ativada.');
        } else {
            if (noDataDiv) {
                noDataDiv.style.display = 'none';
            }
            console.log('Tabela com dados: Mensagem "no data" escondida.');
        }
    });
</script>