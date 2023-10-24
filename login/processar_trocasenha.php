<?php
session_start();

include('../db_conexao/db_connect.php'); // Inclui o arquivo de conexão

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
   $usuario = $_SESSION['user_id'];
$senha_atual = $_POST['senha_atual'];
$nova_senha = $_POST['nova_senha'];

// Consulta o banco de dados para verificar a senha atual
$sql = "SELECT password FROM login_user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $usuario); // 'i' para indicar um inteiro
$stmt->execute();
$stmt->bind_result($senha_db);
$stmt->fetch();
$stmt->close(); // Feche a primeira consulta aqui

if ($senha_atual === $senha_db) {
    // A senha atual está correta, então atualize a senha
    $sql = "UPDATE login_user SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $nova_senha, $usuario); // 'si' para indicar uma string e um inteiro
    $stmt->execute();
    $stmt->close();
    $_SESSION['senha_alterada'] = true;

    echo "Senha alterada com sucesso!";
    header("Location: ../admin.php");

} else {
    $_SESSION['senha_incorreta'] = true;
    header("Location: ./trocarsenha.php");
}

// Certifique-se de fechar a segunda consulta também
$stmt->close();
}
?>