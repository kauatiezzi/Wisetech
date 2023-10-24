<?php
session_start();
include('./db_conexao/db_connect.php'); // Inclua o arquivo de conexão

if (!isset($_SESSION["user_id"])) {
    // Se o usuário não estiver logado, redirecionar para a página de login
    header("Location: ./login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticket_id = $_POST["ticket_id"];
    $sender = $_POST["sender"];
    $cargo = $_POST["cargo"];
    $message = $_POST["message"];

    $sql = "INSERT INTO chat_messages (ticket_id, sender, cargo, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $ticket_id, $sender, $cargo, $message);

    if ($stmt->execute()) {
        // Verifique a permissão do usuário
        $userType = $_SESSION["user_type"];
        if ($userType === 'B') {
            // Se o usuário tiver permissão B, atualize o status do ticket para "Aguardando resposta"
            $sqlUpdateStatus = "UPDATE tickets SET status = 'Aguardando Resposta' WHERE id = ?";
            $stmtUpdateStatus = $conn->prepare($sqlUpdateStatus);
            $stmtUpdateStatus->bind_param("i", $ticket_id);
            $stmtUpdateStatus->execute();

            if ($stmtUpdateStatus->affected_rows > 0) {
                // O status do ticket foi atualizado com sucesso
            } else {
                echo "Erro ao atualizar o status do ticket.";
                exit();
            }
        } elseif ($userType === 'TI') {
            // Se o usuário tiver permissão B, atualize o status do ticket para "Aguardando resposta"
            $sqlUpdateStatus = "UPDATE tickets SET status = 'Aguardando Resposta' WHERE id = ?";
            $stmtUpdateStatus = $conn->prepare($sqlUpdateStatus);
            $stmtUpdateStatus->bind_param("i", $ticket_id);
            $stmtUpdateStatus->execute();

            if ($stmtUpdateStatus->affected_rows > 0) {
                // O status do ticket foi atualizado com sucesso
            } else {
                echo "Erro ao atualizar o status do ticket.";
                exit();
            }
        } elseif ($userType === 'Financeiro') {
            // Se o usuário tiver permissão B, atualize o status do ticket para "Aguardando resposta"
            $sqlUpdateStatus = "UPDATE tickets SET status = 'Aguardando Resposta' WHERE id = ?";
            $stmtUpdateStatus = $conn->prepare($sqlUpdateStatus);
            $stmtUpdateStatus->bind_param("i", $ticket_id);
            $stmtUpdateStatus->execute();

            if ($stmtUpdateStatus->affected_rows > 0) {
                // O status do ticket foi atualizado com sucesso
            } else {
                echo "Erro ao atualizar o status do ticket.";
                exit();
            }
        } elseif ($userType === 'Manutencao') {
            // Se o usuário tiver permissão B, atualize o status do ticket para "Aguardando resposta"
            $sqlUpdateStatus = "UPDATE tickets SET status = 'Aguardando Resposta' WHERE id = ?";
            $stmtUpdateStatus = $conn->prepare($sqlUpdateStatus);
            $stmtUpdateStatus->bind_param("i", $ticket_id);
            $stmtUpdateStatus->execute();

            if ($stmtUpdateStatus->affected_rows > 0) {
                // O status do ticket foi atualizado com sucesso
            } else {
                echo "Erro ao atualizar o status do ticket.";
                exit();
            }
        } elseif ($userType === 'A') {
            // Se o usuário tiver permissão A e o ticket estiver "Aguardando resposta", atualize o status para "Respondido"
            $sqlCheckStatus = "SELECT status FROM tickets WHERE id = ?";
            $stmtCheckStatus = $conn->prepare($sqlCheckStatus);
            $stmtCheckStatus->bind_param("i", $ticket_id);
            $stmtCheckStatus->execute();
            $resultCheckStatus = $stmtCheckStatus->get_result();

            if ($resultCheckStatus->num_rows > 0) {
                $row = $resultCheckStatus->fetch_assoc();
                if ($row['status'] === 'Aguardando Resposta') {
                    $sqlUpdateStatus = "UPDATE tickets SET status = 'Respondido' WHERE id = ?";
                    $stmtUpdateStatus = $conn->prepare($sqlUpdateStatus);
                    $stmtUpdateStatus->bind_param("i", $ticket_id);
                    $stmtUpdateStatus->execute();

                    if ($stmtUpdateStatus->affected_rows > 0) {
                        // O status do ticket foi atualizado para "Respondido" com sucesso
                    } else {
                        echo "Erro ao atualizar o status do ticket para 'Respondido'.";
                        exit();
                    }
                }
            }
        }

        // Mensagem enviada com sucesso
        header("Location: detalhes_ticket.php?id=" . $ticket_id);
        exit();
    } else {
        echo "Erro ao enviar a mensagem.";
    }
}
?>