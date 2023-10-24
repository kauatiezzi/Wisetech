<?php
session_start();
include('./db_conexao/db_connect.php'); // Inclua o arquivo de conexão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere o ID do usuário da sessão
    $user_id = $_SESSION["user_id"];

    // Consulta SQL para buscar o nome do usuário com base no ID
    $sql_user = "SELECT nome FROM login_user WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);

    // Execute a consulta SQL do usuário
    if ($stmt_user->execute()) {
        $result_user = $stmt_user->get_result();

        // Verifique se o resultado foi obtido
        if ($result_user->num_rows > 0) {
            $row_user = $result_user->fetch_assoc();
            $nome = $row_user['nome'];

            // Agora que você tem o nome do usuário, insira-o na tabela tickets
            $titulo = $_POST["titulo"];
            $descricao = $_POST["descricao"];
            $setor = $_POST["setor"];
            $categoria = $_POST["categoria"];
            $localizacao = $_POST["localizacao"];

            $sql_ticket = "INSERT INTO tickets (titulo, descricao, setor, categoria, nome, localizacao, criado_por) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_ticket = $conn->prepare($sql_ticket);
            $stmt_ticket->bind_param("ssssssi", $titulo, $descricao, $setor, $categoria, $nome, $localizacao, $user_id);

            // Execute a consulta SQL do ticket
            if ($stmt_ticket->execute()) {
                header("Location: ./admin.php");
                exit();
            } else {
                echo "Erro ao criar o chamado.";
            }
        } else {
            echo "Nome de usuário não encontrado.";
        }
    } else {
        echo "Erro ao buscar o nome do usuário.";
    }
}
?>