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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Configurações</title>
  <link rel="stylesheet" href="css/styles-config.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon" />
</head>

<body>

  <!-- SIDEBAR -->
  <div class="sidebar" id="sidebar">
    <div class="logo-section">
      <h2><span class="highlight">Adven</span></h2>
      <hr />
    </div>
    <div class="user-info">
      <div class="avatar"><i class="bi bi-person-fill"></i></div>
      <div class="user-details">
<p class="username"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Usuário'); ?></p>
<p class="email"><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'email@dominio.com'); ?></p>
      </div>
    </div>
    <hr />
    <ul class="nav-links">
      <li><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
      <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
      <li><a href="historico.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
      <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
      <li><a href="anotacoes.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
      <li><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
      <li>
        <a href="notificacoes.php">
          <i class="bi bi-bell"></i><span>Notificações</span><span class="badge">2</span>
        </a>
      </li>
      <li><a href="suporte.php"><i class="bi bi-question-circle"></i><span>Suporte</span></a></li>
      <li class="active"><a href="configuracoes.php"><i class="bi bi-gear"></i><span>Configurações</span></a></li>
    </ul>
    <hr/>
    <div class="logout">
      <a href="index.php" class="link-limpo">
        <i class="bi bi-arrow-bar-right"></i><span>Sair</span>
      </a>
    </div>
  </div>

  <button id="menu-toggle" class="menu-btn"><i class="bi bi-list"></i></button>

  <!-- CONTAINER PRINCIPAL -->
  <div class="configuracoes-page">
    <h1>Configurações</h1>
    <div class="grid">
      <!-- Aparência
      <div class="card wide">
        <h3><i class="bi bi-palette2"></i> Aparência</h3>
        <p><strong>Modo Escuro</strong><br /><span>Ative o modo escuro para reduzir o cansaço visual</span></p>

        <div class="switch-area">
          <label class="switch">
            <input type="checkbox" checked />
            <span class="slider round"></span>
          </label>
          <div class="modo-ativo">
            <i class="bi bi-moon"></i> Modo Escuro Ativo
          </div>
        </div>
      </div> -->

      <!-- Perfil -->
      <div class="card">
        <h3><i class="bi bi-person"></i> Perfil</h3>
        <p>Gerencie suas informações pessoais e dados da empresa</p>
        <button class="btn verde">
          <a href="editarPerfil.php" class="link-limpo">
            <i class="bi bi-person-lines-fill"></i> Editar Perfil
          </a>
        </button>
      </div>

      <!-- Notificações -->
      <div class="card">
        <h3><i class="bi bi-bell"></i> Notificações</h3>
        <div class="check-list">
          <label>
            <strong>Compromissos</strong><br />
            <span>Alertas sobre próximos Compromissos</span>
            <input type="checkbox" checked />
          </label>
          <label>
            <strong>Relatórios Semanais</strong><br />
            <span>Resumo semanal por email</span>
            <input type="checkbox" />
          </label>
        </div>
      </div>

      <!-- Segurança
      <div class="card">
        <h3><i class="bi bi-shield-lock"></i> Segurança</h3>

        <div class="seguranca">
          <div>
            <strong>Autenticação em Duas Etapas</strong><br />
            <span>Adiciona uma camada extra de segurança</span>
          </div>
          <button class="btn azul">Configurar</button>
        </div>
        <div class="seguranca">
          <div>
            <strong>Sessões Ativas</strong><br />
            <span>Gerencie dispositivos conectados</span>
          </div>
          <button class="btn cinza">Ver todas</button>
        </div>
        <div class="seguranca">
          <div>
            <strong>Alterar Senha</strong><br />
            <span>Recomendamos alterar a cada 3 meses</span>
          </div>
          <button class="btn vermelho">Alterar</button>
        </div>
      </div> -->

      <!-- Dados e Privacidade -->
      <div class="card wide">
        <h3><i class="bi bi-lock"></i> Dados e Privacidade</h3>
        <button class="btn cinza full">Política de Privacidade</button>
        <form action="../api/login/excluir_conta.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita!');">
  <button type="submit" class="btn vermelho full">Excluir Conta</button>
</form>

      </div>
    </div>
  </div>

  <!-- IMPORTE JS -->
  <script src="js/app-config.js"></script>

</body>
</html>