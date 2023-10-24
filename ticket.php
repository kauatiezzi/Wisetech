<?php
session_start();
include('./db_conexao/db_connect.php'); // Inclui o arquivo de conexão

if (!isset($_SESSION["user_id"])) {
    // Se o usuário não estiver logado, redirecionar para a página de login
    header("Location: ./login/login.php");
    exit();
}

// Verificar as permissões do usuário
$userType = $_SESSION["user_type"];
$user_id = $_SESSION["user_id"]; // Obtenha o ID do usuário da sessão

$sql = "SELECT nome FROM login_user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Inicialize a variável $nomeUsuario com um valor padrão
$nomeUsuario = "Nome não encontrado";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nomeUsuario = $row['nome'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Abrir Chamado | WISETECH</title>
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
          <a href="./admin.php" class="font-bold block py-4 px-2 text-white rounded-lg hover:bg- md:hover:bg-white md:border border hover:bg-white transition duration-700 hover:text-principal md:px-2 md:py-2 dark:text-white text-center md:mb-0">INÍCIO</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="flex-1">

<section>
  <form class="max-w-md mx-auto p-4 bg-gray-100 rounded shadow-lg mt-12 border border-principal" action="create_ticket.php" method="post">
    <h1 class="text-center text-principal font-bold uppercase text-2xl mb-4">Novo chamado</h1>
    <!-- Título -->
    <div class="mb-4">
      <label class="w-1/4 text-right pr-4 text-principal font-semibold">SEU NOME:</label>
      <input class="w-full p-2 rounded border border-gray-300 focus:outline-none focus:border-principal" type="text" name="nome" value="<?php echo htmlspecialchars($nomeUsuario); ?>" readonly>
    </div>
    <div class="mb-4">
      <label class="w-1/4 text-right pr-4 text-principal font-semibold">SEU SETOR:</label>
      <select class="w-full p-2 rounded border border-gray-300 focus:outline-none focus:border-principal" name="setor" required>
        <option value="Setor A">Setor A</option>
        <option value="Setor B">Setor B</option>
        <option value="Setor C">Setor C</option>
        <!-- Adicione mais opções conforme necessário -->
      </select>
    </div>
    <div class="mb-4">
       <label class="w-1/4 text-right pr-4 text-principal font-semibold">TÍTULO:</label>
      <input class="w-full p-2 rounded border border-gray-300 focus:outline-none focus:border-principal" type="text" name="titulo" placeholder="Insira um título" required>
    </div>
    <!-- Descrição -->
    <div class="mb-4">
      <label class="w-1/4 text-right pr-4 text-principal font-semibold">DESCRIÇÃO:</label>
      <textarea class="w-full p-2 rounded border border-gray-300 focus:outline-none focus:border-principal" name="descricao" placeholder="Insira a descrição do seu problema" required></textarea>
    </div>
    <!-- Setor -->
    <div class="mb-4">
      <label class="w-1/4 text-right pr-4 text-principal font-semibold">CATEGORIA DO PROBLEMA:</label>
      <select class="w-full p-2 rounded border border-gray-300 focus:outline-none focus:border-principal" name="categoria" required>
        <option value="Categoria 1">Categoria 1</option>
        <option value="Categoria 2">Categoria 2</option>
        <option value="Categoria 3">Categoria 3</option>
        <!-- Adicione mais opções conforme necessário -->
      </select>
    </div>
    <div class="mb-4">
      <label class="w-1/4 text-right pr-4 text-principal font-semibold">LOCALIZAÇÃO DO PROBLEMA:</label>
      <input class="w-full p-2 rounded border border-gray-300 focus:outline-none focus:border-principal" type="text" name="localizacao" placeholder="Ex: Computador 26 do 2º andar." required>
    </div>
    <!-- Botão de Envio -->
    <div>
      <button class="w-full bg-principal border border-principal text-white py-2 px-4 rounded hover:bg-white hover:text-principal uppercase font-bold hover:border-principal hover:border transition duration-700" type="submit">Criar Chamado</button>
    </div>
  </form>
</section>
</main>


<?php include('./footer.php'); ?>
    
    <!-- Outros conteúdos da página administrativa continuam aqui -->
</body>
</html>