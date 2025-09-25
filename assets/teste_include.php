   <?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   
   echo "Antes do include...<br>";
   
   // Include relativo: de assets/ para raiz
   include "../conexao.php";
   
   echo "Include OK! Conexão carregada.<br>";
   
   if (isset($conn)) {
       echo "Variável \$conn existe.<br>";
       echo "Conexão com BD OK!";
   } else {
       echo "Erro: \$conn não foi definida em conexao.php.<br>";
   }
   ?>
   