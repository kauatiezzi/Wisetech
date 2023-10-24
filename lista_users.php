<?php
session_start();
include('./db_conexao/db_connect.php'); // Inclui o arquivo de conexão

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'B') {
    header("Location: admin.php");
    exit;
}

if (isset($_POST['excluir_usuario']) && isset($_POST['usuario_id'])) {
    $usuario_id = $_POST['usuario_id'];

    // Evitar a exclusão do próprio usuário logado
    if ($_SESSION['user_id'] != $usuario_id) {
        $sql = "DELETE FROM login_user WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $usuario_id);

        if ($stmt->execute()) {
            $_SESSION['user_excluido'] = true;
            header("Location: lista_users.php");
            exit;
        } else {
            // Erro ao excluir usuário
            echo "Erro ao excluir usuário: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Não permitir a exclusão do próprio usuário logado
        echo "Você não pode excluir a si mesmo.";
    }
}

$sql = "SELECT * FROM login_user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $users = [];
}

if (isset($_SESSION['user_cadastrado']) && $_SESSION['user_cadastrado'] === true) {
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
    $_SESSION['user_cadastrado'] = false;
}

if (isset($_SESSION['user_excluido']) && $_SESSION['user_excluido'] === true) {
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
    $_SESSION['user_excluido'] = false;
}

if (isset($_SESSION['user_atualizado']) && $_SESSION['user_atualizado'] === true) {
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
    $_SESSION['user_atualizado'] = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuários | WISETECH</title>
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
          <form action="./admin.php" method="post">
          <button class="font-bold block py-4 px-2 text-white rounded-lg hover:bg- md:hover:bg-white md:border border hover:bg-white transition duration-700 hover:text-principal md:px-2 md:py-2 dark:text-white mb-4 text-center md:mb-0 " type="submit">VOLTAR</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>


<main class="flex-1">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4 text-principal">Lista de Usuários</h1>
        <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-md">
            <thead class="bg-principal text-white">
                <tr>
                    <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">ID</th>
                    <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Nome</th>
                    <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                    <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Setor</th>
                    <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Cargo</th>
                    <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Editar Usuários</th>
                    <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Excluir Usuários</th>
                </tr>
            </thead>
            <tbody class="text-principal">
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td class="text-left py-3 px-4"><?php echo $user['id']; ?></td>
                        <td class="text-left py-3 px-4"><?php echo $user['nome']; ?></td>
                        <td class="text-left py-3 px-4"><?php echo $user['email']; ?></td>
                        <td class="text-left py-3 px-4"><?php echo $user['setor']; ?></td>
                        <td class="text-left py-3 px-4"><?php echo $user['cargo']; ?></td>
                        <td class="text-left py-3 px-4">
                        <?php if ($_SESSION['user_id'] != $user['id']) : ?>
                         <a href="editar_usuario.php?id=<?php echo $user['id']; ?>" class="text-blue-600 hover:text-blue-800 font-semibold">Editar Usuário</a>
                        <?php endif; ?>
                        </td>
                        <td class="text-left py-3 px-4">
                            <?php if ($_SESSION['user_id'] != $user['id']) : ?>
                                <form method="post" action="lista_users.php">
                                    <input type="hidden" name="usuario_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" name="excluir_usuario" class="text-red-600 font-semiboldhover:text-red-800">Excluir Usuário</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include('./footer.php'); ?> <!--PEGAR A FOOTER-->

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
                    Usuário cadastrado com sucesso!
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
                    Usuário excluído com sucesso.
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
                    Usuário atualizado com sucesso.
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