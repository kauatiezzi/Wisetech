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
$userID = $_SESSION["user_id"];
$sql = "SELECT * FROM tickets WHERE criado_por = $userID";
$result = $conn->query($sql);

if (isset($_SESSION['senha_alterada']) && $_SESSION['senha_alterada'] === true) {
    // Mostra o modal de confirmação
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("small-modal");
            if (modal) {
                modal.classList.remove("hidden");
            }
        });
    </script>';
    
    // Limpa a variável de sessão após mostrar o modal
    $_SESSION['senha_alterada'] = false;
}

if (isset($_SESSION['ticket_att']) && $_SESSION['ticket_att'] === true) {
    // Mostra o modal de confirmação
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("small-modal2");
            if (modal) {
                modal.classList.remove("hidden");
            }
        });
    </script>';
    
    // Limpa a variável de sessão após mostrar o modal
    $_SESSION['ticket_att'] = false;
}

if (isset($_SESSION['ticket_excluido']) && $_SESSION['ticket_excluido'] === true) {
    // Mostra o modal de confirmação
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("small-modal3");
            if (modal) {
                modal.classList.remove("hidden");
            }
        });
    </script>';
    
    // Limpa a variável de sessão após mostrar o modal
    $_SESSION['ticket_excluido'] = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel | WISETECH</title>
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
          <form action="./login/trocarsenha.php" method="post">
          <button class="font-bold block py-4 px-2 text-white rounded-lg hover:bg- md:hover:bg-white md:border border hover:bg-white transition duration-700 hover:text-principal md:px-2 md:py-2 dark:text-white mb-4 text-center md:mb-0 " type="submit">ALTERAR SENHA</button>
          </form>
        </li>
        <li>
          <a href="./ticket.php" class="font-bold block py-4 px-2 text-white rounded-lg hover:bg- md:hover:bg-white md:border border hover:bg-white transition duration-700 hover:text-principal md:px-2 md:py-2 dark:text-white text-center md:mb-0">CRIAR UM TICKET</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<main class="flex-1">
    
    <?php
    // Conteúdo para usuário com permissão A
if ($userType == 'A') {
    // Verifica se existem tickets para exibir
    if ($result->num_rows > 0) {
        echo '<div class="m-12 p-4 border border-principal rounded">';
        echo '<h2 class="text-lg font-bold mb-2 uppercase text-principal">SEUS CHAMADOS:</h2>';

        // Formulário para selecionar o tipo de ticket
        echo '<form method="get" action="">';
        echo '<label for="ticketFilter" class="text-principal font-semibold">Filtrar por tipo de ticket:</label>';
        echo '<select id="ticketFilter" name="tipo_ticket" class="ml-2 p-2 border border-principal rounded">';
        echo '<option value="Aberto" ' . ($_GET['tipo_ticket'] == 'Aberto' ? 'selected' : '') . '>Abertos</option>';
        echo '<option value="Todos" ' . ($_GET['tipo_ticket'] == 'Todos' ? 'selected' : '') . '>Todos</option>';
        echo '<option value="Fechado" ' . ($_GET['tipo_ticket'] == 'Fechado' ? 'selected' : '') . '>Fechados</option>';
        echo '</select>';
        echo '<input type="submit" value="Filtrar" class="ml-2 p-2 border border-principal rounded bg-principal text-white hover:bg-white hover:text-principal hover:border-principal font-semibold uppercase animation duration-500 cursor-pointer">';
        echo '</form>';

        echo '<div class="m-10 grid grid-cols-2 gap-4">';

        while ($row = $result->fetch_assoc()) {
            $ticketType = $_GET['tipo_ticket'] ?? 'Aberto'; // Padrão para 'Aberto' se não for especificado
            if ($ticketType == 'Todos' || $row['status2'] == $ticketType) {

                $statusColorClass = '';
                switch ($row['status']) {
                    case 'Aberto':
                        $statusColorClass = 'text-green-500 border border-green-200 bg-green-100';
                        break;
                    case 'Respondido':
                        $statusColorClass = 'text-blue-500 border border-blue-200 bg-blue-100';
                        break;
                    case 'Fechado':
                        $statusColorClass = 'text-gray-500 border border-gray-200 bg-gray-100';
                        break;
                    case 'Aguardando Resposta':
                        $statusColorClass = 'text-red-500 border border-red-200 bg-red-100';
                        break;
                    default:
                        $statusColorClass = 'text-gray-700';
                        break;
                }

                // Exibir os tickets encontrados em duas colunas
                
        echo '<div class="relative flex flex-col border p-4 rounded-lg shadow-md mb-10 border-gray-300">';
        echo '<div class="flex items-end justify-end">';
        if ($row['status'] !== 'Fechado') {
        echo '<form action="excluir_ticket.php" method="post">';
        echo '    <input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '    <button type="submit" class="absolute top-0 right-0 p-2 mt-2 mr-2 text-principal hover:text-white hover:bg-principal rounded-lg transition duration-500 focus:outline-none">';
        echo '        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">';
        echo '            <path d="M 10 2 L 9 3 L 3 3 L 3 5 L 4.109375 5 L 5.8925781 20.255859 L 5.8925781 20.263672 C 6.023602 21.250335 6.8803207 22 7.875 22 L 16.123047 22 C 17.117726 22 17.974445 21.250322 18.105469 20.263672 L 18.107422 20.255859 L 19.890625 5 L 21 5 L 21 3 L 15 3 L 14 2 L 10 2 z M 6.125 5 L 17.875 5 L 16.123047 20 L 7.875 20 L 6.125 5 z" fill="#ff0000"></path>';
        echo '        </svg>';
        echo '    </button>';
        echo '</form>';
        
        echo '<a href="editar_ticket.php?id=' . $row['id'] . '" class="absolute top-0 right-12 p-2 mt-2 mr-2 text-principal hover:text-white hover:bg-principal rounded-lg transition duration-500 focus:outline-none" id="optionsMenu">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 50 50">';
        echo '  <path d="M 43.125 2 C 41.878906 2 40.636719 2.488281 39.6875 3.4375 L 38.875 4.25 L 45.75 11.125 C 45.746094 11.128906 46.5625 10.3125 46.5625 10.3125 C 48.464844 8.410156 48.460938 5.335938 46.5625 3.4375 C 45.609375 2.488281 44.371094 2 43.125 2 Z M 37.34375 6.03125 C 37.117188 6.0625 36.90625 6.175781 36.75 6.34375 L 4.3125 38.8125 C 4.183594 38.929688 4.085938 39.082031 4.03125 39.25 L 2.03125 46.75 C 1.941406 47.09375 2.042969 47.457031 2.292969 47.707031 C 2.542969 47.957031 2.90625 48.058594 3.25 47.96875 L 10.75 45.96875 C 10.917969 45.914063 11.070313 45.816406 11.1875 45.6875 L 43.65625 13.25 C 44.054688 12.863281 44.058594 12.226563 43.671875 11.828125 C 43.285156 11.429688 42.648438 11.425781 42.25 11.8125 L 9.96875     44.09375 L 5.90625 40.03125 L 38.1875 7.75 C 38.488281 7.460938 38.578125 7.011719 38.410156 6.628906 C 38.242188 6.246094 37.855469 6.007813 37.4375    6.03125 C 37.40625 6.03125 37.375 6.03125 37.34375 6.03125 Z" fill="#0000FF"></path>';
        echo '</svg>';
        echo '</a>';
        }
        echo '</div>';  
        echo '<div>';
        echo '<p class="text-lg text-principal font-bold mb-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;">TÍTULO: <span class="font-semibold uppercase">' . $row['titulo'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Criado por: <span class="text-red-700">' . $row['nome'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Setor: <span class="text-principal">' . $row['setor'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Criado em: <span class="text-principal">' . date('d/m/Y', strtotime($row['data_criacao'])) . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Categoria: <span class="text-principal">' . $row['categoria'] . '</span></p>';
        echo '<div class="text-right mt-4 flex justify-between">';
        echo '<p class="font-semibold inline-block px-2 py-1 rounded mt-4 ' . $statusColorClass . '">' . $row['status'] . '</p>';
        if ($row['status'] !== 'Fechado') {
        echo '<a href="detalhes_ticket.php?id=' . $row['id'] . '" class="font-semibold inline-block px-2 py-1 rounded mt-4 text-gray-500 border border-gray-400 bg-gray-200">Ver detalhes</a>';
        }
        echo '</div>';
        echo '</div>';
                echo '</div>';
     }
 }
        echo '</div>';
        echo '</div>';
    } else {
        echo 'Você ainda não criou nenhum ticket.';
    }
}

    // Conteúdo para usuário com permissão B
elseif ($userType == 'B') {

    
echo '<div class="my-4 flex items-center space-x-4 bg-principal mt-0 pt-0 pb-4 pt-4">';
echo '<div class="mx-12">';
echo '<a href="cadastro.php" class="bg-principal hover:bg-white text-white border border-white hover:bg-white hover:text-principal rounded-lg uppercase py-2 px-4 mr-4 rounded font-bold transition duration-700">Adicionar Usuário</a>';
echo '<a href="lista_users.php" class="bg-principal hover:bg-white text-white border border-white hover:bg-white hover:text-principal rounded-lg uppercase py-2 px-4 mr-4 rounded font-bold transition duration-700">Ver Usuários</a>';
echo '</div>';
echo '</div>';

    // Consulta SQL para selecionar todos os tickets
    $sqlb = "SELECT * FROM tickets WHERE equipe_responsavel NOT IN ('TI', 'Manutencao', 'Financeiro')";
    $resultb = $conn->query($sqlb);

    if ($resultb->num_rows > 0) {
        echo '<div class="m-12 p-4 border border-principal rounded">';
        echo '<h2 class="text-lg font-bold mb-2 uppercase text-principal">TODOS OS CHAMADOS:</h2>';

        // Formulário para selecionar o tipo de ticket
        echo '<form method="get" action="">';
        echo '<label for="ticketFilter" class="text-principal font-semibold">Filtrar por tipo de ticket:</label>';
        echo '<select id="ticketFilter" name="tipo_ticket" class="ml-2 p-2 border border-principal rounded">';
        echo '<option value="Aberto" ' . ($_GET['tipo_ticket'] == 'Aberto' ? 'selected' : '') . '>Abertos</option>';
        echo '<option value="Todos" ' . ($_GET['tipo_ticket'] == 'Todos' ? 'selected' : '') . '>Todos</option>';
        echo '<option value="Fechado" ' . ($_GET['tipo_ticket'] == 'Fechado' ? 'selected' : '') . '>Fechados</option>';
        echo '</select>';
        echo '<input type="submit" value="Filtrar" class="ml-2 p-2 border border-principal rounded bg-principal text-white hover:bg-white hover:text-principal hover:border-principal font-semibold uppercase animation duration-500 cursor-pointer">';
        echo '</form>';

        echo '<div class="m-10 grid grid-cols-2 gap-4">';

        while ($row = $resultb->fetch_assoc()) {
            $ticketType = $_GET['tipo_ticket'] ?? 'Aberto'; // Padrão para 'Aberto' se não for especificado

            if ($ticketType == 'Todos' || $row['status2'] == $ticketType) {

                $statusColorClass = '';
                switch ($row['status']) {
                    case 'Aberto':
                        $statusColorClass = 'text-green-500 border border-green-200 bg-green-100';
                        break;
                    case 'Respondido':
                        $statusColorClass = 'text-blue-500 border border-blue-200 bg-blue-100';
                        break;
                    case 'Fechado':
                        $statusColorClass = 'text-gray-500 border border-gray-200 bg-gray-100';
                        break;
                    case 'Aguardando Resposta':
                        $statusColorClass = 'text-red-500 border border-red-200 bg-red-100';
                        break;
                    default:
                        $statusColorClass = 'text-gray-700';
                        break;
                }

                // Exibir os tickets encontrados em cinco colunas
echo '<div class="relative flex flex-col border p-4 rounded-lg shadow-md mb-10 border-gray-300">';
        echo '<div class="flex items-end justify-end">';
        if ($row['status'] !== 'Fechado') {
        echo '<form action="excluir_ticket.php" method="post">';
        echo '    <input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '    <button type="submit" class="absolute top-0 right-0 p-2 mt-2 mr-2 text-principal hover:text-white hover:bg-principal rounded-lg transition duration-500 focus:outline-none">';
        echo '        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">';
        echo '            <path d="M 10 2 L 9 3 L 3 3 L 3 5 L 4.109375 5 L 5.8925781 20.255859 L 5.8925781 20.263672 C 6.023602 21.250335 6.8803207 22 7.875 22 L 16.123047 22 C 17.117726 22 17.974445 21.250322 18.105469 20.263672 L 18.107422 20.255859 L 19.890625 5 L 21 5 L 21 3 L 15 3 L 14 2 L 10 2 z M 6.125 5 L 17.875 5 L 16.123047 20 L 7.875 20 L 6.125 5 z" fill="#ff0000"></path>';
        echo '        </svg>';
        echo '    </button>';
        echo '</form>';
        echo '<a href="editar_ticket.php?id=' . $row['id'] . '" class="absolute top-0 right-12 p-2 mt-2 mr-2 text-principal hover:text-white hover:bg-principal rounded-lg transition duration-500 focus:outline-none" id="optionsMenu">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 50 50">';
        echo '  <path d="M 43.125 2 C 41.878906 2 40.636719 2.488281 39.6875 3.4375 L 38.875 4.25 L 45.75 11.125 C 45.746094 11.128906 46.5625 10.3125 46.5625 10.3125 C 48.464844 8.410156 48.460938 5.335938 46.5625 3.4375 C 45.609375 2.488281 44.371094 2 43.125 2 Z M 37.34375 6.03125 C 37.117188 6.0625 36.90625 6.175781 36.75 6.34375 L 4.3125 38.8125 C 4.183594 38.929688 4.085938 39.082031 4.03125 39.25 L 2.03125 46.75 C 1.941406 47.09375 2.042969 47.457031 2.292969 47.707031 C 2.542969 47.957031 2.90625 48.058594 3.25 47.96875 L 10.75 45.96875 C 10.917969 45.914063 11.070313 45.816406 11.1875 45.6875 L 43.65625 13.25 C 44.054688 12.863281 44.058594 12.226563 43.671875 11.828125 C 43.285156 11.429688 42.648438 11.425781 42.25 11.8125 L 9.96875     44.09375 L 5.90625 40.03125 L 38.1875 7.75 C 38.488281 7.460938 38.578125 7.011719 38.410156 6.628906 C 38.242188 6.246094 37.855469 6.007813 37.4375    6.03125 C 37.40625 6.03125 37.375 6.03125 37.34375 6.03125 Z" fill="#0000FF"></path>';
        echo '</svg>';
        echo '</a>';
        }
        echo '</div>';  
        echo '<div>';
        echo '<p class="text-lg text-principal font-bold mb-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;">TÍTULO: <span class="font-semibold uppercase">' . $row['titulo'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Criado por: <span class="text-red-700">' . $row['nome'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Setor: <span class="text-principal">' . $row['setor'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Criado em: <span class="text-principal">' . date('d/m/Y', strtotime($row['data_criacao'])) . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Categoria: <span class="text-principal">' . $row['categoria'] . '</span></p>';
        echo '<div class="mt-4">';
        if ($row['status'] !== 'Fechado') {
        echo '<form method="post" action="atualizar_equipe_ticket.php">';
        echo '<input type="hidden" name="ticket_id" value="' . $row['id'] . '">'; // Passar o ID do ticket como um campo oculto
        echo '<label for="equipe" class="text-principal font-semibold">Selecione a equipe responsável:</label>';
        echo '<select id="equipe" name="nova_equipe" class="ml-2 p-2 border border-principal rounded">';
        echo '<option value="TI">T.I</option>'; // DEFINIR AS EQUIPES
        echo '<option value="Manutencao">Manutenção</option>';
        echo '<option value="Financeiro">Financeiro</option>';
        echo '</select>';
        echo '<input type="submit" value="Atualizar Equipe" class="ml-2 p-2 border border-principal rounded bg-principal text-white hover:bg-white hover:text-principal hover:border-principal font-semibold uppercase animation duration-500 cursor-pointer">';
        echo '</form>';
        }
        echo '</div>';
        echo '<div class="text-right mt-4 flex justify-between">';
        echo '<p class="font-semibold inline-block px-2 py-1 rounded mt-4 ' . $statusColorClass . '">' . $row['status'] . '</p>';
        if ($row['status'] !== 'Fechado') {
        echo '<a href="fechar_ticket.php?id=' . $row['id'] . '" class="font-semibold inline-block px-2 py-1 rounded mt-4 text-red-500 border border-red-400 bg-red-200">Fechar Chamado</a>';
        echo '<a href="detalhes_ticket.php?id=' . $row['id'] . '" class="font-semibold inline-block px-2 py-1 rounded mt-4 text-gray-500 border border-gray-400 bg-gray-200">Ver detalhes</a>';
    }
        echo '</div>';
        echo '</div>';
                echo '</div>';
            }
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo 'Você ainda não criou nenhum ticket.';
    }
}

elseif ($userType == 'TI') {
    // Consulta SQL para selecionar todos os tickets
    $sqlti = "SELECT * FROM tickets WHERE equipe_responsavel = 'TI'";;
    $resultti = $conn->query($sqlti);

    if ($resultti->num_rows > 0) {
        echo '<div class="m-12 p-4 border border-principal rounded">';
        echo '<h2 class="text-lg font-bold mb-2 uppercase text-principal">TODOS OS CHAMADOS:</h2>';

        // Formulário para selecionar o tipo de ticket
        echo '<form method="get" action="">';
        echo '<label for="ticketFilter" class="text-principal font-semibold">Filtrar por tipo de ticket:</label>';
        echo '<select id="ticketFilter" name="tipo_ticket" class="ml-2 p-2 border border-principal rounded">';
        echo '<option value="Aberto" ' . ($_GET['tipo_ticket'] == 'Aberto' ? 'selected' : '') . '>Abertos</option>';
        echo '<option value="Todos" ' . ($_GET['tipo_ticket'] == 'Todos' ? 'selected' : '') . '>Todos</option>';
        echo '<option value="Fechado" ' . ($_GET['tipo_ticket'] == 'Fechado' ? 'selected' : '') . '>Fechados</option>';
        echo '</select>';
        echo '<input type="submit" value="Filtrar" class="ml-2 p-2 border border-principal rounded bg-principal text-white hover:bg-white hover:text-principal hover:border-principal font-semibold uppercase animation duration-500 cursor-pointer">';
        echo '</form>';

        echo '<div class="m-10 grid grid-cols-2 gap-4">';

        while ($row = $resultti->fetch_assoc()) {
            $ticketType = $_GET['tipo_ticket'] ?? 'Aberto'; // Padrão para 'Aberto' se não for especificado

            if ($ticketType == 'Todos' || $row['status2'] == $ticketType) {

                $statusColorClass = '';
                switch ($row['status']) {
                    case 'Aberto':
                        $statusColorClass = 'text-green-500 border border-green-200 bg-green-100';
                        break;
                    case 'Respondido':
                        $statusColorClass = 'text-blue-500 border border-blue-200 bg-blue-100';
                        break;
                    case 'Fechado':
                        $statusColorClass = 'text-gray-500 border border-gray-200 bg-gray-100';
                        break;
                    case 'Aguardando Resposta':
                        $statusColorClass = 'text-red-500 border border-red-200 bg-red-100';
                        break;
                    default:
                        $statusColorClass = 'text-gray-700';
                        break;
                }

                // Exibir os tickets encontrados em cinco colunas
                echo '<div class="flex flex-col border p-4 rounded-lg shadow-md mb-10 border-gray-300">';
        echo '<div>';
        echo '<p class="text-lg text-principal font-bold mb-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;">TÍTULO: <span class="font-semibold uppercase">' . $row['titulo'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Criado por: <span class="text-red-700">' . $row['nome'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Setor: <span class="text-principal">' . $row['setor'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Criado em: <span class="text-principal">' . date('d/m/Y', strtotime($row['data_criacao'])) . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Categoria: <span class="text-principal">' . $row['categoria'] . '</span></p>';
        echo '<div class="mt-4">';
        echo '</div>';
        echo '<div class="text-right mt-4 flex justify-between">';
        echo '<p class="font-semibold inline-block px-2 py-1 rounded mt-4 ' . $statusColorClass . '">' . $row['status'] . '</p>';
        if ($row['status'] !== 'Fechado') {
        echo '<a href="fechar_ticket.php?id=' . $row['id'] . '" class="font-semibold inline-block px-2 py-1 rounded mt-4 text-red-500 border border-red-400 bg-red-200">Fechar Chamado</a>';
        echo '<a href="detalhes_ticket.php?id=' . $row['id'] . '" class="font-semibold inline-block px-2 py-1 rounded mt-4 text-gray-500 border border-gray-400 bg-gray-200">Ver detalhes</a>';
        }
        echo '</div>';
        echo '</div>';
                echo '</div>';
            }
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo 'Você ainda não criou nenhum ticket.';
    }
}

elseif ($userType == 'Manutencao') {
    // Consulta SQL para selecionar todos os tickets
    $sqlmc = "SELECT * FROM tickets WHERE equipe_responsavel = 'Manutencao'";;
    $resultmc = $conn->query($sqlmc);

    if ($resultmc->num_rows > 0) {
        echo '<div class="m-12 p-4 border border-principal rounded">';
        echo '<h2 class="text-lg font-bold mb-2 uppercase text-principal">TODOS OS CHAMADOS:</h2>';

        // Formulário para selecionar o tipo de ticket
        echo '<form method="get" action="">';
        echo '<label for="ticketFilter" class="text-principal font-semibold">Filtrar por tipo de ticket:</label>';
        echo '<select id="ticketFilter" name="tipo_ticket" class="ml-2 p-2 border border-principal rounded">';
        echo '<option value="Aberto" ' . ($_GET['tipo_ticket'] == 'Aberto' ? 'selected' : '') . '>Abertos</option>';
        echo '<option value="Todos" ' . ($_GET['tipo_ticket'] == 'Todos' ? 'selected' : '') . '>Todos</option>';
        echo '<option value="Fechado" ' . ($_GET['tipo_ticket'] == 'Fechado' ? 'selected' : '') . '>Fechados</option>';
        echo '</select>';
        echo '<input type="submit" value="Filtrar" class="ml-2 p-2 border border-principal rounded bg-principal text-white hover:bg-white hover:text-principal hover:border-principal font-semibold uppercase animation duration-500 cursor-pointer">';
        echo '</form>';

        echo '<div class="m-10 grid grid-cols-2 gap-4">';

        while ($row = $resultmc->fetch_assoc()) {
            $ticketType = $_GET['tipo_ticket'] ?? 'Aberto'; // Padrão para 'Aberto' se não for especificado

            if ($ticketType == 'Todos' || $row['status2'] == $ticketType) {

                $statusColorClass = '';
                switch ($row['status']) {
                    case 'Aberto':
                        $statusColorClass = 'text-green-500 border border-green-200 bg-green-100';
                        break;
                    case 'Respondido':
                        $statusColorClass = 'text-blue-500 border border-blue-200 bg-blue-100';
                        break;
                    case 'Fechado':
                        $statusColorClass = 'text-gray-500 border border-gray-200 bg-gray-100';
                        break;
                    case 'Aguardando Resposta':
                        $statusColorClass = 'text-red-500 border border-red-200 bg-red-100';
                        break;
                    default:
                        $statusColorClass = 'text-gray-700';
                        break;
                }

                // Exibir os tickets encontrados em cinco colunas
                echo '<div class="flex flex-col border p-4 rounded-lg shadow-md mb-10 border-gray-300">';
        echo '<div>';
        echo '<p class="text-lg text-principal font-bold mb-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;">TÍTULO: <span class="font-semibold uppercase">' . $row['titulo'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Criado por: <span class="text-red-700">' . $row['nome'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Setor: <span class="text-principal">' . $row['setor'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Criado em: <span class="text-principal">' . date('d/m/Y', strtotime($row['data_criacao'])) . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Categoria: <span class="text-principal">' . $row['categoria'] . '</span></p>';
        echo '<div class="mt-4">';
        echo '</div>';
        echo '<div class="text-right mt-4 flex justify-between">';
        echo '<p class="font-semibold inline-block px-2 py-1 rounded mt-4 ' . $statusColorClass . '">' . $row['status'] . '</p>';
        if ($row['status'] !== 'Fechado') {
        echo '<a href="fechar_ticket.php?id=' . $row['id'] . '" class="font-semibold inline-block px-2 py-1 rounded mt-4 text-red-500 border border-red-400 bg-red-200">Fechar Chamado</a>';
        echo '<a href="detalhes_ticket.php?id=' . $row['id'] . '" class="font-semibold inline-block px-2 py-1 rounded mt-4 text-gray-500 border border-gray-400 bg-gray-200">Ver detalhes</a>';
        }
        echo '</div>';
        echo '</div>';
                echo '</div>';
            }
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo 'Você ainda não criou nenhum ticket.';
    }
}

elseif ($userType == 'Financeiro') {
    // Consulta SQL para selecionar todos os tickets
    $sqlfc = "SELECT * FROM tickets WHERE equipe_responsavel = 'Financeiro'";;
    $resultfc = $conn->query($sqlfc);

    if ($resultfc->num_rows > 0) {
        echo '<div class="m-12 p-4 border border-principal rounded">';
        echo '<h2 class="text-lg font-bold mb-2 uppercase text-principal">TODOS OS CHAMADOS:</h2>';

        // Formulário para selecionar o tipo de ticket
        echo '<form method="get" action="">';
        echo '<label for="ticketFilter" class="text-principal font-semibold">Filtrar por tipo de ticket:</label>';
        echo '<select id="ticketFilter" name="tipo_ticket" class="ml-2 p-2 border border-principal rounded">';
        echo '<option value="Aberto" ' . ($_GET['tipo_ticket'] == 'Aberto' ? 'selected' : '') . '>Abertos</option>';
        echo '<option value="Todos" ' . ($_GET['tipo_ticket'] == 'Todos' ? 'selected' : '') . '>Todos</option>';
        echo '<option value="Fechado" ' . ($_GET['tipo_ticket'] == 'Fechado' ? 'selected' : '') . '>Fechados</option>';
        echo '</select>';
        echo '<input type="submit" value="Filtrar" class="ml-2 p-2 border border-principal rounded bg-principal text-white hover:bg-white hover:text-principal hover:border-principal font-semibold uppercase animation duration-500 cursor-pointer">';
        echo '</form>';

        echo '<div class="m-10 grid grid-cols-2 gap-4">';

        while ($row = $resultfc->fetch_assoc()) {
            $ticketType = $_GET['tipo_ticket'] ?? 'Aberto'; // Padrão para 'Aberto' se não for especificado

            if ($ticketType == 'Todos' || $row['status2'] == $ticketType) {

                $statusColorClass = '';
                switch ($row['status']) {
                    case 'Aberto':
                        $statusColorClass = 'text-green-500 border border-green-200 bg-green-100';
                        break;
                    case 'Respondido':
                        $statusColorClass = 'text-blue-500 border border-blue-200 bg-blue-100';
                        break;
                    case 'Fechado':
                        $statusColorClass = 'text-gray-500 border border-gray-200 bg-gray-100';
                        break;
                    case 'Aguardando Resposta':
                        $statusColorClass = 'text-red-500 border border-red-200 bg-red-100';
                        break;
                    default:
                        $statusColorClass = 'text-gray-700';
                        break;
                }

                // Exibir os tickets encontrados em cinco colunas
                echo '<div class="flex flex-col border p-4 rounded-lg shadow-md mb-10 border-gray-300">';
        echo '<div>';
        echo '<p class="text-lg text-principal font-bold mb-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%;">TÍTULO: <span class="font-semibold uppercase">' . $row['titulo'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Criado por: <span class="text-red-700">' . $row['nome'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Setor: <span class="text-principal">' . $row['setor'] . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Criado em: <span class="text-principal">' . date('d/m/Y', strtotime($row['data_criacao'])) . '</span></p>';
        echo '<p class="text-gray-700 font-semibold">Categoria: <span class="text-principal">' . $row['categoria'] . '</span></p>';
        echo '<div class="mt-4">';
        echo '</div>';
        echo '<div class="text-right mt-4 flex justify-between">';
        echo '<p class="font-semibold inline-block px-2 py-1 rounded mt-4 ' . $statusColorClass . '">' . $row['status'] . '</p>';
        if ($row['status'] !== 'Fechado') {
        echo '<a href="fechar_ticket.php?id=' . $row['id'] . '" class="font-semibold inline-block px-2 py-1 rounded mt-4 text-red-500 border border-red-400 bg-red-200">Fechar Chamado</a>';
        echo '<a href="detalhes_ticket.php?id=' . $row['id'] . '" class="font-semibold inline-block px-2 py-1 rounded mt-4 text-gray-500 border border-gray-400 bg-gray-200">Ver detalhes</a>';
        }
        echo '</div>';
        echo '</div>';
                echo '</div>';
            }
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo 'Você ainda não criou nenhum ticket.';
    }
}

    ?>


</main>

<?php include('./footer.php'); ?>

<div id="small-modal" tabindex="-1" class="fixed inset-0 z-50 hidden overflow-x-hidden overflow-y-auto modal-center mt-24">
    <div class="fixed inset-0 bg-black opacity-50"></div> <!-- Fundo escurecido -->
    <div class="relative max-w-md mx-auto rounded-lg">
        <!-- Modal content -->
        <div class="relative bg-principal rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5">
                <h3 class="text-xl font-medium text-white">
                    WiseTech
                </h3>
                <button type="button" class="text-white bg-transparent hover:bg-gray-200 hover:text-principal rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="small-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <p class="text-base leading-relaxed text-white">
                    Senha Alterada!
                </p>
            </div>
        </div>
    </div>
</div>

<div id="small-modal2" tabindex="-1" class="fixed inset-0 z-50 hidden overflow-x-hidden overflow-y-auto modal-center mt-24">
    <div class="fixed inset-0 bg-black opacity-50"></div> <!-- Fundo escurecido -->
    <div class="relative max-w-md mx-auto rounded-lg">
        <!-- Modal content -->
        <div class="relative bg-principal rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5">
                <h3 class="text-xl font-medium text-white">
                    WiseTech
                </h3>
                <button type="button" class="text-white bg-transparent hover:bg-gray-200 hover:text-principal rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="small-modal2">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <p class="text-base leading-relaxed text-white">
                    Chamado alterado com sucesso!
                </p>
            </div>
        </div>
    </div>
</div>

<div id="small-modal3" tabindex="-1" class="fixed inset-0 z-50 hidden overflow-x-hidden overflow-y-auto modal-center mt-24">
    <div class="fixed inset-0 bg-black opacity-50"></div> <!-- Fundo escurecido -->
    <div class="relative max-w-md mx-auto rounded-lg">
        <!-- Modal content -->
        <div class="relative bg-principal rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-5">
                <h3 class="text-xl font-medium text-white">
                    WiseTech
                </h3>
                <button type="button" class="text-white bg-transparent hover:bg-gray-200 hover:text-principal rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="small-modal3">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <p class="text-base leading-relaxed text-white">
                    Chamado excluído com sucesso!
                </p>
            </div>
        </div>
    </div>
</div>
    
    <script>
    // Função para fechar o modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = "none";
        }
    }

    // Escuta o evento de clique no botão "Close modal"
    var closeButton = document.querySelector('[data-modal-hide="small-modal"]');
    if (closeButton) {
        closeButton.addEventListener("click", function () {
            closeModal("small-modal");
        });
    }

    function closeModal2(modalId2) {
        var modal2 = document.getElementById(modalId2);
        if (modal2) {
            modal2.style.display = "none";
        }
    }

    // Escuta o evento de clique no botão "Close modal"
    var closeButton2 = document.querySelector('[data-modal-hide="small-modal2"]');
    if (closeButton2) {
        closeButton2.addEventListener("click", function () {
            closeModal("small-modal2");
        });
    }

    function closeModal2(modalId3) {
        var modal3 = document.getElementById(modalId3);
        if (modal3) {
            modal3.style.display = "none";
        }
    }

    // Escuta o evento de clique no botão "Close modal"
    var closeButton3 = document.querySelector('[data-modal-hide="small-modal3"]');
    if (closeButton3) {
        closeButton3.addEventListener("click", function () {
            closeModal("small-modal3");
        });
    }

    

</script>
</body>
</html>