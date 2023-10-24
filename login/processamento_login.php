<?php
session_start();

include('../db_conexao/db_connect.php');

// Processamento do formulário de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id, email, user_type, nome FROM login_user WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["user_type"] = $row["user_type"];
        $_SESSION['nome'] = $row["nome"];

        // Redirecionar para a página administrativa
        header("Location: ../admin.php");
        exit();
    } else {
        echo "Login falhou. Verifique suas credenciais.";
    }
}

$conn->close();
?>