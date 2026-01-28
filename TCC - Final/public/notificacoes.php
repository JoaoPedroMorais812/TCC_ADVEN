<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notificações</title>
  <link href="css/styles-notificacoes.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">
</head>

<body>
  <!-- SIDEBAR -->
  <div class="sidebar" id="sidebar">
    <div class="logo-section">
      <h2><span class="highlight">Adven</span></h2>
      <hr>
    </div>
    <div class="user-info">
      <div class="avatar"><i class="bi bi-person-fill"></i></div>
      <div class="user-details">
        <p class="username"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Usuário'); ?></p>
                <p class="email"><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'email@dominio.com'); ?></p>
      </div>
    </div>
    <hr>
    <ul class="nav-links">
      <li><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
      <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
      <li><a href="historico.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
      <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
      <li><a href="anotacoes.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
      <li><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
      <li class="active">
        <a href="notificacoes.php"><i class="bi bi-bell"></i><span>Notificações</span><span class="badge">0</span></a>
      </li>
      <li><a href="suporte.php"><i class="bi bi-question-circle"></i><span>Suporte</span></a></li>
      <li><a href="configuracoes.php"><i class="bi bi-gear"></i><span>Configurações</span></a></li>
    </ul>
    <hr>
    <div class="logout">
      <a href="index.php" class="link-limpo">
        <i class="bi bi-arrow-bar-right"></i><span>Sair</span>
      </a>
    </div>
  </div>

  <button id="menu-toggle" class="menu-btn"><i class="bi bi-list"></i></button>

  <!-- CONTAINER PRINCIPAL -->
  <div class="notificacoes-page">
    <div class="topo">
      <h1>Notificações</h1>
      <span class="badge" id="badge-topo">0 não lidas</span>
      <div class="actions"><a href="#" id="marcar-todas"><i class="bi bi-check2-all"></i> Marcar todas como lidas</a></div>
    </div>

    <!-- Container dinâmico -->
    <div id="listaNotificacoes"></div>

    <div class="acoes-rapidas">
      <h2>Ações Rápidas</h2>
      <div class="grid">
        <div class="card azul">
          <h3>Configurar Alertas</h3>
          <p>Personalize quando e como receber notificações</p>
          <a href="#">Configurar →</a>
        </div>
        <div class="card verde">
          <h3>Lembretes</h3>
          <p>Configure lembretes para vencimentos importantes</p>
          <a href="#">Criar lembrete →</a>
        </div>
        <div class="card laranja">
          <h3>Relatórios</h3>
          <p>Receba relatórios automáticos por email</p>
          <a href="#">Ativar →</a>
        </div>
      </div>
    </div>
  </div>

  <!-- IMPORTE JS -->
  <script src="js/app-notificacoes.js"></script>
</body>
</html>
