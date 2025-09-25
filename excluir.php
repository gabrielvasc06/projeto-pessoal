<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>



   <?php
   // excluir.php (na raiz)
   session_start();
   require_once __DIR__ . "../assets/conexao.php";  // <-- AQUI: Ajuste para o caminho completo relativo à raiz

   // Ative erros para debug (REMOVA depois que funcionar)
   error_reporting(E_ALL);
   ini_set('display_errors', 1);

   header('Content-Type: application/json; charset=utf-8');

   if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
       http_response_code(405);
       echo json_encode(['success' => false, 'message' => 'Método não permitido']);
       exit;
   }

   // CSRF
   $csrf = $_POST['csrf_token'] ?? '';
   if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
       http_response_code(403);
       echo json_encode(['success' => false, 'message' => 'Token CSRF inválido']);
       exit;
   }

   // Valida ID (inteiro)
   $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
   if ($id === false || $id === null) {
       http_response_code(400);
       echo json_encode(['success' => false, 'message' => 'ID inválido']);
       exit;
   }

   // Prepared statement para evitar SQL injection
   $stmt = $conn->prepare("DELETE FROM pessoa WHERE id = ?");
   if ($stmt === false) {
       http_response_code(500);
       echo json_encode(['success' => false, 'message' => 'Erro no servidor: ' . $conn->error]);
       exit;
   }

   $stmt->bind_param('i', $id);
   $stmt->execute();

   if ($stmt->affected_rows > 0) {
       echo json_encode(['success' => true, 'message' => 'Registro excluído com sucesso.']);
   } else {
       http_response_code(404);
       echo json_encode(['success' => false, 'message' => 'Registro não encontrado ou já excluído.']);
   }

   $stmt->close();
   $conn->close();
   ?>
   