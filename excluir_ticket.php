<?php
session_start();
include('./db_conexao/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $ticket_id = $_POST["id"];

    // Verifique se o usuário tem permissão para excluir o ticket
    $sql_ticket = "SELECT criado_por FROM tickets WHERE id = ?";
    $stmt_ticket = $conn->prepare($sql_ticket);
    $stmt_ticket->bind_param("i", $ticket_id);

    if ($stmt_ticket->execute()) {
        $result_ticket = $stmt_ticket->get_result();

        if ($result_ticket->num_rows > 0) {
            $row_ticket = $result_ticket->fetch_assoc();

            // Verifique se o usuário tem permissão para excluir o ticket
            if (intval($_SESSION["user_id"]) === intval($row_ticket["criado_por"]) || $_SESSION["user_type"] === "B") {
                // Prossiga com a exclusão
                $sql_delete = "DELETE FROM tickets WHERE id = ?";
                $stmt_delete = $conn->prepare($sql_delete);
                $stmt_delete->bind_param("i", $ticket_id);

                if ($stmt_delete->execute()) {
                    $_SESSION['ticket_excluido'] = true;
                    header("Location: ./admin.php");
                    exit();
                } else {
                    echo "Erro ao excluir o ticket.";
                }
            } else {
                echo "Você não tem permissão para excluir este ticket.";
            }
        } else {
            echo "Ticket não encontrado.";
        }
    } else {
        echo "Erro ao buscar informações do ticket.";
    }
} else {
    echo "Requisição inválida.";
}
?>