<?php
session_start();
include('./db_conexao/db_connect.php');

$stmt_ticket = null; // Inicializa a variável $stmt_ticket

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $ticket_id = $_GET["id"];

    if (!$stmt_ticket) {
        // Se a declaração não foi definida, prepare a consulta
        $sql_ticket = "SELECT * FROM tickets WHERE id = ?";
        $stmt_ticket = $conn->prepare($sql_ticket);
        $stmt_ticket->bind_param("i", $ticket_id);
    }

    if ($stmt_ticket->execute()) {
        $result_ticket = $stmt_ticket->get_result();

        if ($result_ticket->num_rows > 0) {
            $row_ticket = $result_ticket->fetch_assoc();

            if (intval($_SESSION["user_id"]) === intval($row_ticket["criado_por"]) || $_SESSION["user_type"] === "B") {
                $titulo = $row_ticket["titulo"];
                $descricao = $row_ticket["descricao"];
                $setor = $row_ticket["setor"];
                $categoria = $row_ticket["categoria"];
                $localizacao = $row_ticket["localizacao"];
                $status = $row_ticket["status"];
                $data_criacao = $row_ticket["data_criacao"];
            } else {
                echo "Você não tem permissão para editar este ticket.";
                exit();
            }
        } else {
            echo "Ticket não encontrado.";
            exit();
        }
    } else {
        echo "Erro ao buscar informações do ticket.";
        exit();
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticket_id = $_POST["id"];
    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];
    $setor = $_POST["setor"];
    $categoria = $_POST["categoria"];
    $localizacao = $_POST["localizacao"];
    $status = $_POST["status"];

    if (!$stmt_ticket) {
        // Se a declaração não foi definida, prepare a consulta
        $sql_ticket = "UPDATE tickets SET titulo = ?, descricao = ?, setor = ?, categoria = ?, localizacao = ?, status = ? WHERE id = ?";
        $stmt_ticket = $conn->prepare($sql_ticket);
    }

    // Certifique-se de que a declaração esteja definida antes de tentar bind_param
    if ($stmt_ticket) {
        $stmt_ticket->bind_param("ssssssi", $titulo, $descricao, $setor, $categoria, $localizacao, $status, $ticket_id);

        if ($stmt_ticket->execute()) {
            $_SESSION['ticket_att'] = true;
            header("Location: ./admin.php");
            exit();
        } else {
            echo "Erro ao atualizar o ticket.";
        }
    } else {
        echo "Erro ao preparar a consulta de atualização do ticket.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Chamado | WISETECH</title>
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
  <?php include('./header.php'); ?>
<section>
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-md w-96">
            <h1 class="text-xl font-bold mb-4 text-principal uppercase">Editar Chamado</h1>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $ticket_id; ?>">
                <div class="mb-4">
                    <label for="titulo" class="block text-gray-600 text-sm font-medium">Título:</label>
                    <input type="text" name="titulo" value="<?php echo $titulo; ?>" class="border rounded w-full p-2">
                </div>
                <div class="mb-4">
                    <label for="descricao" class="block text-gray-600 text-sm font-medium">Descrição:</label>
                    <textarea name="descricao" class="border rounded w-full p-2" rows="4"><?php echo $descricao; ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="setor" class="block text-gray-600 text-sm font-medium">Setor:</label>
                    <input type="text" name="setor" value="<?php echo $setor; ?>" class="border rounded w-full p-2">
                </div>
                <div class="mb-4">
                    <label for="categoria" class="block text-gray-600 text-sm font-medium">Categoria:</label>
                    <input type="text" name="categoria" value="<?php echo $categoria; ?>" class="border rounded w-full p-2">
                </div>
                <div class="mb-4">
                    <label for="localizacao" class="block text-gray-600 text-sm font-medium">Localização:</label>
                    <input type="text" name="localizacao" value="<?php echo $localizacao; ?>" class="border rounded w-full p-2">
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-600 text-sm font-medium">Status:</label>
                    <input type="text" name="status" value="<?php echo $status; ?>" class="border rounded w-full p-2">
                </div>
                <button type="submit" class="bg-principal hover:bg-white text-white border border-white hover:bg-white hover:text-principal rounded-lg uppercase py-2 px-4 mr-4 rounded font-bold transition duration-500 hover:border-principal">Atualizar Chamado</button>
            </form>
        </div>
    </div>
</section>
    <?php include('./footer.php'); ?>
</body>
</html>