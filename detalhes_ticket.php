<?php
session_start();
include('./db_conexao/db_connect.php'); // Inclui o arquivo de conexão

if (!isset($_SESSION["user_id"])) {
    // Se o usuário não estiver logado, redirecionar para a página de login
    header("Location: ./login/login.php");
    exit();
}

$ticket_id = $_GET["id"];

// Consulta SQL para obter detalhes do chamado
$sql = "SELECT * FROM tickets WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


// Recuperar dados de nome e cargo do usuário
$user_id = $_SESSION["user_id"]; // Certifique-se de ter a variável de sessão correta para o ID do usuário logado.

$sql_user = "SELECT nome, cargo FROM login_user WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_data = $result_user->fetch_assoc();

// Armazenar os dados em variáveis separadas
$sender = $user_data["nome"];
$cargo = $user_data["cargo"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalhes | WISETECH</title>
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
<nav class="bg-principal border-gray-200">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="./index.php" class="flex items-center">
         <img class='w-40' src='./assets/logobranca.png' alt="" />
    </a>
    <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white       rounded-lg md:hidden focus:outline-none" aria-controls="navbar-default" aria-expanded="false">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg  md:flex-row md:space-x-8 md:mt-0 md:border-0">

        <li>
          <form action="./login/logout.php" method="post">
          <button class="font-bold block py-4 px-2 text-white rounded-lg hover:bg- md:hover:bg-white md:border border hover:bg-white transition duration-700 hover:text-principal md:px-2 md:py-2 dark:text-white mb-4 text-center md:mb-0 " type="submit">SAIR</button>
          </form>
        </li>
        <li>
          <a href="./admin.php" class="font-bold block py-4 px-2 text-white rounded-lg hover:bg- md:hover:bg-white md:border border hover:bg-white transition duration-700 hover:text-principal md:px-2 md:py-2 dark:text-white text-center md:mb-0">VOLTAR</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<main class="flex-1 p-4">
  <div class="m-8 border border-principal p-4 rounded">
    <!-- Exibir os detalhes do chamado na página -->
    <h1 class="text-2xl font-bold uppercase text-principal"><?php echo $row['titulo']; ?></h1>
    <p class="font-semibold text-gray-500 mb-4">Status: <?php echo $row['status']; ?></p>
    <!-- Informações adicionais -->
    <div class="mb-4">
        <p><span class="font-semibold">Categoria:</span> <?php echo $row['categoria']; ?></p>
        <p><span class="font-semibold">Localização:</span> <?php echo $row['localizacao']; ?></p>
        <p><span class="font-semibold">Setor:</span> <?php echo $row['setor']; ?></p>
        <p><span class="font-semibold">Criado por:</span> <?php echo $row['nome']; ?></p>
    </div>

    <p class="font-semibold mt-8">Descrição:</p>
    <p class="text-gray-700 mb-4"><?php echo $row['descricao']; ?></p>

    <?php
    // Obtém o ID do ticket da URL
    $ticket_idc = $_GET["id"];

// Consulta as mensagens associadas ao ticket especificado
    $sqlc = "SELECT * FROM chat_messages WHERE ticket_id = ? ORDER BY created_at ASC";
    $stmtc = $conn->prepare($sqlc);
    $stmtc->bind_param("i", $ticket_idc);
    $stmtc->execute();
    $resultc = $stmtc->get_result();

// Exibe as mensagens
  echo '<div class="border border-gray-300 rounded-lg">';
    echo '<p class="font-bold text-principal text-3xl text-center mt-2">CHAT</p>';
while ($row = $resultc->fetch_assoc()) {
    echo '<div class="message mt-4 p-3 bg-gray-100 rounded-lg border border-gray-300 shadow-md mb-4 mx-12">';
echo '<strong class="text-principal">' . htmlspecialchars($row["cargo"]) .' | ' . htmlspecialchars($row["sender"]) . ':</strong> ' . htmlspecialchars($row["message"]);
echo '</div>';
}
echo '</div>';
    ?>

    <form class="mt-4" method="post" action="enviar_mensagem.php">
    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>">
    <input type="hidden" name="sender" value="<?php echo htmlspecialchars($sender); ?>">
    <input type="hidden" name="cargo" value="<?php echo htmlspecialchars($cargo); ?>">
    
    <div class="mb-4">
        <label for="message" class="block text-lg font-semibold text-principal">NOVA MENSAGEM:</label>
        <textarea name="message" class="mt-1 p-2 block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="4" required></textarea>
    </div>
    <div class="mt-2">
        <button type="submit" class="px-4 py-2 bg-principal hover:bg-white text-white hover:text-principal border border-principal hover:border hover:border-principal rounded-3xl transition duration-700 uppercase font-semibold">Enviar</button>
    </div>
</form>
  </div>
</main>

<?php include('./footer.php'); ?>
    
    <!-- Outros conteúdos da página administrativa continuam aqui -->
</body>
</html>