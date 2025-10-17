<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notificações</title>

  <!-- CSS principal -->
  <link href="css/styles-notificacoes.css" rel="stylesheet"/>

  <!-- Ícones Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">
</head>
<body>

  
    <!-- Sidebar fixa à esquerda -->
  <div class="sidebar" id="sidebar">
    
    <!-- Logo / título -->
    <div class="logo-section">
      <h2><span class="highlight">Adven</span></h2>
      <hr>
    </div>

    <!-- Informações do usuário -->
    <div class="user-info">
      <div class="avatar"><i class="bi bi-person-fill"></i></div>
      <div class="user-details">
        <p class="username">adven</p>
        <p class="email">isabella.santos318@etec.sp.gov.br</p>
      </div>
    </div>

    <hr>

    <!-- Navegação da sidebar -->
    <ul class="nav-links">
      <li ><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
      <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
      <li><a href="notas.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
    
      <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
      <li><a href="bloco.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
      <li><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
      <li class="active">
        <a href="notificacoes.php"><i class="bi bi-bell"></i><span>Notificações</span><span class="badge">2</span></a>
      </li>
      <li><a href="suporte.php"><i class="bi bi-question-circle"></i><span>Suporte</span></a></li>
      <li><a href="configuracoes.php"><i class="bi bi-gear"></i><span>Configurações</span></a></li>
    </ul>

    <hr>

    <!-- Sair do sistema -->
    <div class="logout">
    <a href="./index.php" class="link-limpo">
  <i class="bi bi-arrow-bar-right"></i><span>Sair</span>
</a>

    </div>
  </div>

  <!-- Botão do menu mobile -->
  <button id="menu-toggle" class="menu-btn">
    <i class="bi bi-list"></i>
  </button>

  <!-- CONTEÚDO PRINCIPAL -->
  <div class="notificacoes-page">

    <!-- TOPO DA PÁGINA -->
    <div class="topo">
      <h1>Notificações</h1>
      <span class="badge">2 não lidas</span>
      <div class="actions">
        <a href="#"><i class="bi bi-check2-all"></i> Marcar todas como lidas</a>
        <a href="#"><i class="bi bi-funnel"></i> Filtros</a>
      </div>
    </div>

    <!-- ALERTA DE SUCESSO -->
    <div class="alerta sucesso">
      <div class="icone"><i class="bi bi-check-circle"></i></div>
      <div class="conteudo">
        <strong>Bem-vindo!</strong>
        <p>Sua conta foi criada com sucesso. Explore todas as funcionalidades do sistema.</p>
        <span>Agora</span>
      </div>
      <div class="acoes">
        <i class="bi bi-check2"></i>
        <i class="bi bi-trash"></i>
      </div>
    </div>

    <!-- ALERTA DE AVISO -->
    <div class="alerta aviso">
      <div class="icone"><i class="bi bi-exclamation-circle"></i></div>
      <div class="conteudo">
        <strong>Vencimento próximo</strong>
        <p>Você tem 3 contas vencendo nos próximos 7 dias.</p>
        <span>Agora</span>
      </div>
      <div class="acoes">
        <i class="bi bi-check2"></i>
        <i class="bi bi-trash"></i>
      </div>
    </div>

    <!-- AÇÕES RÁPIDAS -->
    <div class="acoes-rapidas">
      <h2>Ações Rápidas</h2>
      <div class="grid">
        <!-- Card 1 -->
        <div class="card azul">
          <h3>Configurar Alertas</h3>
          <p>Personalize quando e como receber notificações</p>
          <a href="#">Configurar →</a>
        </div>

        <!-- Card 2 -->
        <div class="card verde">
          <h3>Lembretes</h3>
          <p>Configure lembretes para vencimentos importantes</p>
          <a href="#">Criar lembrete →</a>
        </div>

        <!-- Card 3 -->
        <div class="card laranja">
          <h3>Relatórios</h3>
          <p>Receba relatórios automáticos por email</p>
          <a href="#">Ativar →</a>
        </div>
      </div>
    </div>

  </div>

</body>
</html>
