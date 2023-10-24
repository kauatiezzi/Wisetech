<?php
// Configurações do banco de dados
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'cliendev';

// Conexão com o banco de dados
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
?>