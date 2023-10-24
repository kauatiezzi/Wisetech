<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | WISETECH</title>
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon-16x16.png">
<link rel="manifest" href="../assets/site.webmanifest">
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
         <img class='w-40' src='../assets/logobranca.png' alt="" />
    </a>
    <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white       rounded-lg md:hidden focus:outline-none" aria-controls="navbar-default" aria-expanded="false">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg  md:flex-row md:space-x-8 md:mt-0 md:border-0">

        <li>
          <a href="../index.php" class="font-bold block py-4 px-2 text-white rounded-lg hover:bg- md:hover:bg-white md:border border hover:bg-white transition duration-700 hover:text-principal md:px-2 md:py-2 dark:text-white text-center md:mb-0">PÁGINA INICIAL</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<section>
   <div class="min-h-screen bg-white flex justify-center items-center">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-sm border rounded-lg border-principal">
            <h1 class="text-2xl text-principal font-bold mb-4">LOGIN</h1>
            <form action="./processamento_login.php" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-principal">EMAIL</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full border rounded py-2 px-3"
                        placeholder="seuemail@example.com"
                    />
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-principal">SENHA</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full border rounded py-2 px-3"
                        placeholder="********"
                    />
                </div>
                <div class="mb-4">
                    <button
                        type="submit"
                        class="w-full py-2 px-4 bg-transparent hover:bg-principal cursor-pointer rounded-lg text-principal font-bold hover:text-white border border-principal hover:border-transparent transition duration-700 mb-5 text-center"
                    >
                        ENTRAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<footer>
  <div class='w-full mt-24 bg-principal text-gray-300 py-y px-2'>
        <div class='max-w-[1240px] mx-auto grid grid-cols-2 md:grid-cols-6 border-b-2 border-gray-600 py-8'>
            <div>
                <h6 class='font-bold uppercase pt-2'>SOLUÇÕES</h6>
                <ul>
                    <li class='py-1'>Sistemas</li>
                </ul>
            </div>
            <div>
                <h6 class='font-bold uppercase pt-2'>SUPORTE</h6>
                <ul>
                    <li class='py-1'>Preços</li>
                </ul>
            </div>
            <div>
                <h6 class='font-bold uppercase pt-2'>EMPRESA</h6>
                <ul>
                    <li class='py-1'>Sobre</li>
                </ul>
            </div>
            <div>
                <h6 class='font-bold uppercase pt-2'>TERMOS</h6>
                <ul>
                    <li class='py-1'>Termos</li>
                </ul>
            </div>
            <div class='col-span-2 pt-8 md:pt-2'>
                <p class='font-bold uppercase'>Se inscreva na nossa newsletter</p>
                <p class='py-4'>As ultimas atualizações da nossa empresa, disponível na sua caixa de email semanalmente.</p>
                <form class='flex flex-col sm:flex-row'>
                    <input class='w-full p-2 mr-4 rounded-md mb-4' type="email" placeholder='Email...'/>
                    <button class='p-2 mb-4 bg-transparent hover:bg-white cursor-pointer rounded-lg text-white font-bold hover:text-principal border border-white hover:border-transparent transition duration-700 text-center'>INSCREVER</button>
                </form>
            </div>
        </div>

        <div class='flex flex-col max-w-[1240px] px-2 py-4 mx-auto justify-between sm:flex-row text-center text-gray-500'>
        <p class='py-4'>2023 Kauã Tiezzi, Todos direitos reservados.</p>
        <div class='flex justify-between sm:w-[300px] pt-4 text-2xl'>
          <a href=""><img src="../assets/facebook.svg" class="w-6 h-6" alt=""></a>
          <a href=""><img src="../assets/instagram.svg" class="w-6 h-6" alt=""></a>
          <a href=""><img src="../assets/x.svg" class="w-6 h-6" alt=""></a>
          <a href=""><img src="../assets/github.svg" class="w-6 h-6" alt=""></a>
        </div>
        </div>
    </div>
</footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>


</body>
</html>