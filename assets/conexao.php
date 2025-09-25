<?php

$host = "localhost";
$username = "root"; 
$password = "root"; 
$port = 8889;
$dbname   = "check";

$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}


$conn->set_charset("utf8");
?>
