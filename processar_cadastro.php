<?php

session_start();


include('./db_conexao/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha']; // NÃO recomendado para produção.
    $setor = $_POST['setor'];
    $cargo = $_POST['cargo'];

    // Inserir os dados no banco de dados
    // Lembre-se de realizar validações adequadas e verificar a unicidade do email.

    // Exemplo de SQL para inserção:
    $sql = "INSERT INTO login_user (email, nome, password, setor, cargo, user_type) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $email, $nome, $senha, $setor, $cargo, getPermissionByCargo($cargo));
    
    if ($stmt->execute()) {
        $_SESSION['user_cadastrado'] = true;
        header("Location: ./lista_users.php");

    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

function getPermissionByCargo($cargo) {
    // Defina as permissões com base no cargo
    switch ($cargo) {
        case 'Funcionário':
            return 'A';
        case 'Suporte T.I':
            return 'TI';
        case 'Suporte Financeiro':
            return 'Financeiro';
        case 'Suporte Manutenção':
            return 'Manutencao';
        default:
            return 'A'; // Permissão padrão para outros cargos
    }
}
?>