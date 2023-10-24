<?php
session_start();
include('./db_conexao/db_connect.php'); // Inclua o arquivo de conexão

if (!isset($_SESSION["user_id"])) {
    // Se o usuário não estiver logado, redirecionar para a página de login
    header("Location: ./login/login.php");
    exit();
}

// Verifique se um ID de ticket válido foi passado via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $ticketId = $_GET['id'];

    // Atualize o status do ticket para "Fechado"
    $sql = "UPDATE tickets SET status = 'Fechado', status2 = 'Fechado' WHERE id = $ticketId";

    if ($conn->query($sql) === TRUE) {
        // Redirecione para admin.php após o fechamento bem-sucedido
        header("Location: admin.php");
        exit();
    } else {
        echo "Erro ao fechar o ticket: " . $conn->error;
    }

    // Feche a conexão com o banco de dados
    $conn->close();
} else {
    echo "ID de ticket inválido";
}
?>