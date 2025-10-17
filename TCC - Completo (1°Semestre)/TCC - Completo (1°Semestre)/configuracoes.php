<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <!-- Metadados básicos -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Configurações</title>

  <!-- Estilos CSS -->
  <link rel="stylesheet" href="css/styles-config.css" />

  <!-- Ícones do Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
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
      <li>
        <a href="notificacoes.php"><i class="bi bi-bell"></i><span>Notificações</span><span class="badge">2</span></a>
      </li>
      <li><a href="suporte.php"><i class="bi bi-question-circle"></i><span>Suporte</span></a></li>
      <li class="active"><a href="configuracoes.php"><i class="bi bi-gear"></i><span>Configurações</span></a></li>
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

  <!-- Área principal de conteúdo da tela de configurações -->
  <div class="configuracoes-page">
    <h1>Configurações</h1>

    <div class="grid">

      <!-- Card de Aparência (modo escuro) -->
      <div class="card wide">
        <h3><i class="bi bi-palette2"></i> Aparência</h3>
        <p><strong>Modo Escuro</strong><br><span>Ative o modo escuro para reduzir o cansaço visual</span></p>
        <div class="switch-area">
          <label class="switch">
            <input type="checkbox" checked>
            <span class="slider round"></span>
          </label>
          <div class="modo-ativo">
            <i class="bi bi-moon"></i> Modo Escuro Ativo
          </div>
        </div>
      </div>

      <!-- Card de Perfil -->
      <div class="card">
        <h3><i class="bi bi-person"></i> Perfil</h3>
        <p>Gerencie suas informações pessoais e dados da empresa</p>
        <button class="btn verde"><a href="editarPerfil.php" class="link-limpo"><i class="bi bi-person-lines-fill"></i> Editar Perfil</a></button>
      </div>

      <!-- Card de Notificações -->
      <div class="card">
        <h3><i class="bi bi-bell"></i> Notificações</h3>
        <div class="check-list">
          <label>
            <strong>Vencimentos</strong><br>
            <span>Alertas sobre contas próximas do vencimento</span>
            <input type="checkbox" checked>
          </label>
          <label>
            <strong>Metas Financeiras</strong><br>
            <span>Notificações sobre o progresso das metas</span>
            <input type="checkbox" checked>
          </label>
          <label>
            <strong>Relatórios Semanais</strong><br>
            <span>Resumo semanal por email</span>
            <input type="checkbox">
          </label>
        </div>
      </div>

      <!-- Card de Segurança -->
      <div class="card">
        <h3><i class="bi bi-shield-lock"></i> Segurança</h3>

        <div class="seguranca">
          <div>
            <strong>Autenticação em Duas Etapas</strong><br>
            <span>Adiciona uma camada extra de segurança</span>
          </div>
          <button class="btn azul">Configurar</button>
        </div>

        <div class="seguranca">
          <div>
            <strong>Sessões Ativas</strong><br>
            <span>Gerencie dispositivos conectados</span>
          </div>
          <button class="btn cinza">Ver todas</button>
        </div>

        <div class="seguranca">
          <div>
            <strong>Alterar Senha</strong><br>
            <span>Recomendamos alterar a cada 3 meses</span>
          </div>
          <button class="btn vermelho">Alterar</button>
        </div>
      </div>

      <!-- Card de Idioma e Região -->
      <div class="card wide">
        <h3><i class="bi bi-globe"></i> Idioma e Região</h3>
        <div class="select-group">
          <label>Idioma
            <select>
              <option>Português (Brasil)</option>
            </select>
          </label>
          <label>Moeda
            <select>
              <option>Real Brasileiro (R$)</option>
            </select>
          </label>
          <label>Fuso Horário
            <select>
              <option>Brasília (UTC-3)</option>
            </select>
          </label>
        </div>
      </div>

      <!-- Card de Dados e Privacidade -->
      <div class="card wide">
        <h3><i class="bi bi-lock"></i> Dados e Privacidade</h3>
        <button class="btn cinza full">Exportar Dados</button>
        <button class="btn cinza full">Política de Privacidade</button>
        <button class="btn vermelho full">Excluir Conta</button>
      </div>

    </div>
  </div>

  <!-- Script JS da página de configurações -->
  <script src="js/app-config.js"></script>
</body>
</html>
