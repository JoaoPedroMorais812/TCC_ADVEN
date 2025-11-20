<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suporte</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/styles-suporte.css">
  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">
</head>

<body class="dark">

   <div class="sidebar" id="sidebar">
    <div class="logo-section">
      <h2><span class="highlight">Adven</span></h2>
      <hr>
    </div>
    <div class="user-info">
      <div class="avatar"><i class="bi bi-person-fill"></i></div>
      <div class="user-details">
        <p class="username">adven</p>
        <p class="email">isabella.santos318@etec.sp.gov.br</p>
      </div>
    </div>
    <hr>
    <ul class="nav-links">
      <li><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
      <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
      <li><a href="notas.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
      <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
      <li><a href="bloco.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
      <li><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
      <li>
        <a href="notificacoes.php"><i class="bi bi-bell"></i><span>Notificações</span><span class="badge">2</span></a>
      </li>
      <li class="active"><a href="suporte.php"><i class="bi bi-question-circle"></i><span>Suporte</span></a></li>
      <li><a href="configuracoes.php"><i class="bi bi-gear"></i><span>Configurações</span></a></li>
    </ul>
    <hr>
    <div class="logout">
      <a href="./index.php" class="link-limpo">
        <i class="bi bi-arrow-bar-right"></i><span>Sair</span>
      </a>
    </div>
  </div>
  <button id="menu-toggle" class="menu-btn">
    <i class="bi bi-list"></i>
  </button> 

  <!-- CONTAINER -->

  <div class="main-content-wrapper">
    <div class="ajuda-container">
      <h1 class="page-title">Central de Ajuda e Suporte</h1>
      <p class="page-subtitle">Relate problemas técnicos ou tire suas dúvidas conosco</p>

      <section class="problem-type-section">
        <h2 class="section-title">Selecione o tipo de problema:</h2>
        <div class="problem-cards-grid">
          <div class="problem-card" data-problem-type="desempenho">
            <i class="bi bi-lightning-fill"></i>
            <h3 class="card-title">Problemas de Desempenho</h3>
            <p class="card-description">Travamentos, lentidão, páginas que não carregam</p>
          </div>
          <div class="problem-card" data-problem-type="conexao">
            <i class="bi bi-link-45deg"></i>
            <h3 class="card-title">Problemas de Conexão</h3>
            <p class="card-description">Dados que não carregam, erros de sincronização</p>
          </div>
          <div class="problem-card" data-problem-type="outros">
            <i class="bi bi-question"></i>
            <h3 class="card-title">Outros Problemas</h3>
            <p class="card-description">Dúvidas, sugestões ou outros tipos de problema</p>
          </div>
        </div>
      </section>

      <section class="faq-section">
        <h2 class="section-title">Perguntas Frequentes</h2>
        <div class="faq-list" id="faq-list"></div>
      </section>

    </div>
  </div>

  <script src="js/app-suporte.js"></script>
</body>

</html>