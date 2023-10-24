<?php
session_start();

include('./db_conexao/db_connect.php');

// Verificar se o usuário está autenticado e tem permissão de edição (Permissão B)
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'B') {
    header("Location: login.php");
    exit;
}

// Verificar se o ID do usuário a ser editado é fornecido na URL
if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // Verificar se o usuário a ser editado existe no banco de dados
    $sql = "SELECT * FROM login_user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        header("Location: lista_users.php");
        exit;
    }
} else {
    header("Location: lista_users.php");
    exit;
}

// Processar o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $setor = $_POST['setor'];
    $cargo = $_POST['cargo'];

    // Atualizar os dados do usuário no banco de dados
    $sql = "UPDATE login_user SET nome = ?, email = ?, setor = ?, cargo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $nome, $email, $setor, $cargo, $usuario_id);

    if ($stmt->execute()) {
        $_SESSION['user_atualizado'] = true;
        header("Location: lista_users.php");
    } else {
        echo "Erro ao atualizar o usuário: " . $stmt->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Usuário | WISETECH</title>
  <link rel="apple-touch-icon" sizes="180x180" href="./assets/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon-16x16.png">
<link rel="manifest" href="./assets/site.webmanifest">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
    screens: {
      sm: '640px',
      // => @media (min-width: 640px) { ... }

      md: '768px',
      // => @media (min-width: 768px) { ... }

      lg: '1024px',
      // => @media (min-width: 1024px) { ... }

      xl: '1280px',
      // => @media (min-width: 1280px) { ... }

      '2xl': '1536px',
      // => @media (min-width: 1536px) { ... }
    },
    fontFamily: {
      'sans': ['ui-sans-serif', 'system-ui',],
      'serif': ['ui-serif', 'Georgia',],
      'mono': ['ui-monospace', 'SFMono-Regular',],
    },
     extend: {
      colors: {
        principal: '#312553',
        cinza: '#DADADA',
      },
     },
    },
  }
  </script>
  <link rel="stylesheet" href="./css/index.css" />
</head>
<body class="flex flex-col min-h-screen">
<?php include('./header.php'); ?>
<main class="flex-1">
    <div class="container mx-auto p-4">
        <h1 class="mt-4 text-2xl font-semibold mb-4 text-principal flex justify-center items-center">Editar Usuário</h1>
        <div class="flex justify-center items-center">
        <form method="post" action="editar_usuario.php?id=<?php echo $usuario_id; ?>" class="max-w-md">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email:</label>
                <input type="email" name="email" required class="border rounded w-full p-2" value="<?php echo $user['email']; ?>">
            </div>
            <div class="mb-4">
                <label for="nome" class="block text-sm font-medium text-gray-600">Nome:</label>
                <input type="text" name="nome" required class="border rounded w-full p-2" value="<?php echo $user['nome']; ?>">
            </div>
            <div class="mb-4">
                <label for="setor" class="block text-sm font-medium text-gray-600">Setor:</label>
                <input type="text" name="setor" required class="border rounded w-full p-2" value="<?php echo $user['setor']; ?>">
            </div>
            <div class="mb-4">
                <label for="cargo" class="block text-sm font-medium text-gray-600">Cargo:</label>
                <select name="cargo" class="border rounded w-full p-2">
                    <option value="Funcionário" <?php echo ($user['cargo'] === 'Funcionário') ? 'selected' : ''; ?>>Funcionário</option>
                    <option value="Suporte T.I" <?php echo ($user['cargo'] === 'Suporte T.I') ? 'selected' : ''; ?>>Suporte T.I</option>
                    <option value="Suporte Financeiro" <?php echo ($user['cargo'] === 'Suporte Financeiro') ? 'selected' : ''; ?>>Suporte Financeiro</option>
                    <option value="Suporte Manutenção" <?php echo ($user['cargo'] === 'Suporte Manutenção') ? 'selected' : ''; ?>>Suporte Manutenção</option>
                </select>
            </div>
            <button type="submit" class="bg-principal text-white font-medium p-2 rounded hover:bg-white hover:text-principal border hover:border-principal transition duration-500 uppercase">Atualizar</button>
        </form>
</div>
    </div>
</main>

<?php include('./footer.php'); ?>