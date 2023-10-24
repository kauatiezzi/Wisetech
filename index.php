<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WISETECH</title>
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
          <a href="./login/login.php" class="font-bold block py-4 px-2 text-white rounded-lg hover:bg- md:hover:bg-white md:border border hover:bg-white transition duration-700 hover:text-principal md:px-2 md:py-2 dark:text-white mb-4 text-center md:mb-0 ">LOGIN</a>
        </li>
        <li>
          <a href="#" class="font-bold block py-4 px-2 text-white rounded-lg hover:bg- md:hover:bg-white md:border border hover:bg-white transition duration-700 hover:text-principal md:px-2 md:py-2 dark:text-white text-center md:mb-0">COMPRAR AGORA</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<section>
  <div name='home' class='w-full h-screen bg-white flex flex-col justify-between'>
        <div class='grid md:grid-cols-2 max-w-[1240px] mx-auto mt-32 '>
            <div class='flex flex-col justify-center md:items-start w-full px-2 py-8'>
                <h1 class='py-3 text-5xl md:text-7xl font-bold text-principal '>Chamados Empresariais.</h1>
                <p class='text-2xl text-principal'>Apresentamos o nosso software de gestão de chamados internos, a solução definitiva para empresas que desejam resolver problemas de forma rápida e eficaz. Com a nossa plataforma intuitiva e poderosa, você pode centralizar, acompanhar e resolver todos os tipos de solicitações internas com facilidade.</p>
                <a href="" class='py-3 px-6 sm:w-[60%] my-4 bg-transparent hover:bg-principal cursor-pointer rounded-lg text-principal font-bold hover:text-white border border-principal hover:border-transparent transition duration-700 text-center'>CONTRATE JÁ PARA SUA EMPRESA</a>
            </div>
            <div class='hidden md:block'>
                <img class='w-full ' src='./assets/pagina-inicial.png' alt="/" />
            </div>
        </div>
    </div>
</section>

<section>
      <div name='platforms' class='w-full'>
      <div class='max-w-[1240px] mx-auto px-2'>
        <h2 class='text-5xl font-bold text-center'>Conheça Nossa Plataforma</h2>
        <p class='text-2xl py-8 text-gray-500 text-center'>
          Nossa plataforma possui diversas ferramentas a fim de facilitar o dia a dia da resolução de problemas técnicos internos de uma empresa.
        </p>

        <div class='grid sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4'>

          <div class='flex'>
            <div>
              <img class='mr-3 mt-2 text-green-600'src="./assets/check.png" alt="">
            </div>
            <div class="ml-4">
              <h3 class='font-bold text-lg'>Abertura de Chamados</h3>
              <p class='text-lg pt-2 pb-4'>
                O sistema permitirá que os colaboradores abram chamados de manutenção informando os detalhes do problema e a localização específica do ativo com defeito.
              </p>
            </div>
          </div>
          <div class='flex'>
            <div>
              <img class='mr-3 mt-2 text-green-600'src="./assets/check.png" alt="">
            </div>
            <div class="ml-4">
              <h3 class='font-bold text-lg'>Identificação de Ativos</h3>
              <p class='text-lg pt-2 pb-4'>
                O sistema deverá permitir a identificação precisa do ativo com defeito, incluindo informações como localização (escritório, andar, número do computador), tipo de equipamento e descrição do problema.
              </p>
            </div>
          </div>
          <div class='flex'>
            <div>
              <img class='mr-3 mt-2 text-green-600'src="./assets/check.png" alt="">
            </div>
            <div class="ml-4">
              <h3 class='font-bold text-lg'>Registro de Informações</h3>
              <p class='text-lg pt-2 pb-4'>
                Ao abrir um chamado, o colaborador deverá fornecer informações detalhadas sobre o problema enfrentado, incluindo descrição dos sintomas, mensagens de erro (se aplicável) e outras observações relevantes.
              </p>
            </div>
          </div>
          <div class='flex'>
            <div>
              <img class='mr-3 mt-2 text-green-600'src="./assets/check.png" alt="">
            </div>
            <div class="ml-4">
              <h3 class='font-bold text-lg'>Atribuição de Responsáveis</h3>
              <p class='text-lg pt-2 pb-4'>
                O sistema enviará os chamados a uma pessoa designada a analisar o problema e encaminhar para o responsável pela manutenção do problema. O responsável receberá uma notificação do novo chamado.
              </p>
            </div>
          </div>
          <div class='flex'>
            <div>
              <img class='mr-3 mt-2 text-green-600'src="./assets/check.png" alt="">
            </div>
            <div class="ml-4">
              <h3 class='font-bold text-lg'>Acompanhamento de Chamados</h3>
              <p class='text-lg pt-2 pb-4'>
                Os colaboradores poderão acompanhar o status dos chamados abertos, verificando se a manutenção foi agendada, em andamento ou concluída.
              </p>
            </div>
          </div>
          <div class='flex'>
            <div>
              <img class='mr-3 mt-2 text-green-600'src="./assets/check.png" alt="">
            </div>
            <div class="ml-4">
              <h3 class='font-bold text-lg'>Notificações e Alertas</h3>
              <p class='text-lg pt-2 pb-4'>
                O sistema enviará notificações aos colaboradores e responsáveis pela manutenção, informando sobre atualizações nos chamados e a conclusão das intervenções.
              </p>
            </div>
          </div>
          <div class='flex'>
            <div>
              <img class='mr-3 mt-2 text-green-600'src="./assets/check.png" alt="">
            </div>
            <div class="ml-4">
              <h3 class='font-bold text-lg'>Histórico e Relatórios</h3>
              <p class='text-lg pt-2 pb-4'>
                Será mantido um histórico de todos os chamados abertos e suas resoluções. Relatórios poderão ser gerados para análise de tendências e melhorias na gestão da manutenção.
              </p>
            </div>
          </div>
          <div class='flex'>
            <div>
              <img class='mr-3 mt-2 text-green-600'src="./assets/check.png" alt="">
            </div>
            <div class="ml-4">
              <h3 class='font-bold text-lg'>Integração de Dados</h3>
              <p class='text-lg pt-2 pb-4'>
                O sistema poderá ser integrado a outras ferramentas internas para acesso rápido a informações sobre os ativos e colaboradores.
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>
</section>

<section>
     <div name='pricing' class='w-full text-white my-24'>
      <div class='w-full h-[800px] bg-principal absolute mix-blend-overlay'></div>

      <div class='max-w-[1240px] mx-auto py-12'>

        <div class='text-center py-8 text-slate-300'>
          <h2 class='text-3xl uppercase'>Planos</h2>
          <h3 class='text-5xl font-bold text-white py-8'>Tudo isso pelo melhor preço do mercado.</h3>
        </div>

        <div class='grid md:grid-cols-2'>

          <div class='bg-white text-slate-900 m-4 p-8 rounded-xl shadow-2xl relative'>
            <span class='uppercase px-3 py-1 bg-indigo-200 text-indigo-900 rounded-2xl text-sm'>Comum</span>
            <div>
              <p class='text-6xl font-bold py-4 flex'>R$59,90<span class='text-xl text-slate-500 flex flex-col justify-end'>/mês</span></p>
            </div>
            <div class='text-2xl'>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Acesso Básico.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Abertura Ilimitada de Chamados.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Acompanhamento de Chamados.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Histórico de Chamados.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Notificações Básicas.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Interface Amigável.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Integração Básica de Dados.</p>
                <button class='w-full py-4 my-4 bg-principal hover:bg-transparent cursor-pointer rounded-lg text-white font-bold hover:text-principal border border-principal hover:border-principal transition duration-700 text-center'>CONTRATAR</button>
            </div>
          </div>
          <div class='bg-white text-slate-900 m-4 p-8 rounded-xl shadow-2xl relative'>
            <span class='uppercase px-3 py-1 bg-indigo-200 text-indigo-900 rounded-2xl text-sm'>Avançado</span>
            <div>
              <p class='text-6xl font-bold py-4 flex'>R$109,90<span class='text-xl text-slate-500 flex flex-col justify-end'>/mês</span></p>
            </div>
            <div class='text-2xl'>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Todas as Vantagens do Plano Normal.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Suporte Técnico Premium.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Relatórios Avançados.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Notificações Avançadas.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Treinamento Personalizado.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Integração Avançada de Dados.</p>
                <p class='flex py-4'><img class='mr-3 mt-2 w-6 h-6'src="./assets/check.png" alt="">Assinatura Mensal ou Anual.</p>
                <button class='w-full py-4 my-4 bg-principal hover:bg-transparent cursor-pointer rounded-lg text-white font-bold hover:text-principal border border-principal hover:border-principal transition duration-700 text-center'>CONTRATAR</button>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<?php include('./footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>


</body>
</html>