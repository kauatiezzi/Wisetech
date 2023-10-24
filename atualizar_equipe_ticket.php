<?php
session_start();
include('./db_conexao/db_connect.php'); // Inclua o arquivo de conexão

if (!isset($_SESSION["user_id"])) {
    // Se o usuário não estiver logado, redirecionar para a página de login
    header("Location: ./login/login.php");
    exit();
}

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se o ID do ticket e a nova equipe foram enviados
    if (isset($_POST["ticket_id"]) && isset($_POST["nova_equipe"])) {
        $ticketId = $_POST["ticket_id"];
        $novaEquipe = $_POST["nova_equipe"];

        // Atualize o campo "Equipe" do ticket no banco de dados
        $sql = "UPDATE tickets SET equipe_responsavel = '$novaEquipe' WHERE id = $ticketId";

        if ($conn->query($sql) === TRUE) {
            // Redirecione para admin.php após a atualização bem-sucedida
            header("Location: admin.php");
            exit();
        } else {
            echo "Erro ao atualizar a equipe do ticket: " . $conn->error;
        }

        // Feche a conexão com o banco de dados
        $conn->close();
    } else {
        echo "ID do ticket ou nova equipe não foram fornecidos.";
    }
} else {
    echo "Acesso inválido a esta página.";
}
?>