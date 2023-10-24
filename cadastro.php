<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'B') {
    header("Location: ./admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo Usuário | WISETECH</title>
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

<body>
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
          <form action="./admin.php" method="post">
          <button class="font-bold block py-4 px-2 text-white rounded-lg hover:bg- md:hover:bg-white md:border border hover:bg-white transition duration-700 hover:text-principal md:px-2 md:py-2 dark:text-white mb-4 text-center md:mb-0 " type="submit">VOLTAR</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
<section>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4 flex justify-center items-center ">Cadastro de Usuário ou Funcionário</h1>
        <div class="flex justify-center items-center">
        <form method="post" action="processar_cadastro.php" class="max-w-md">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email:</label>
                <input type="email" name="email" required class="border rounded w-full p-2">
            </div>
            <div class="mb-4">
                <label for="nome" class="block text-sm font-medium text-gray-600">Nome:</label>
                <input type="text" name="nome" required class="border rounded w-full p-2">
            </div>
            <div class="mb-4">
                <label for="senha" class="block text-sm font-medium text-gray-600">Senha:</label>
                <input type="password" name="senha" required class="border rounded w-full p-2">
            </div>
            <div class="mb-4">
                <label for="setor" class="block text-sm font-medium text-gray-600">Setor:</label>
                <input type="text" name="setor" required class="border rounded w-full p-2">
            </div>
            <div class="mb-4">
                <label for="cargo" class="block text-sm font-medium text-gray-600">Cargo:</label>
                <select name="cargo" class="border rounded w-full p-2">
                    <option value="Funcionário">Funcionário</option>
                    <option value="Suporte T.I">Suporte T.I</option>
                    <option value="Suporte Financeiro">Suporte Financeiro</option>
                    <option value="Suporte Manutenção">Suporte Manutenção</option>
                </select>
            </div>
            <button type="submit" class="bg-principal text-white font-medium p-2 rounded hover:bg-white hover:text-principal border hover:border-principal transition duration-500 uppercase">Cadastrar</button>
        </form>
      </div>
    </div>
</section>

<?php include('./footer.php'); ?>
</body>
</html>
</html>