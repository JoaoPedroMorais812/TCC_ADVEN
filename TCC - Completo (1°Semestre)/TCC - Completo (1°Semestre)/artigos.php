<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Artigos</title>
  <link rel="stylesheet" href="css/styles-artigos.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">

</head>
<body>
  <div class="container">
    <!-- SIDEBAR LATERAL -->
 
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
      <li><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
      <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
      <li><a href="notas.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
    
      <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
      <li><a href="bloco.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
      <li class="active"><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
      <li>
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


    <!-- Conteúdo principal -->
    <main class="content">
      <h1>Artigos de Educação Financeira</h1>

      <div class="filters">
        <input type="text" placeholder=" Buscar artigos..." />
        <select>
          <option>Todas as categorias</option>
          <option>Gestão Financeira</option>
          <option>Fluxo de Caixa</option>
          <option>Planejamento</option>
        </select>
      </div>

      <div class="articles">
<div class="card">
  <img src="./image/IMG-20250806-WA0001.jpg" alt="">
  <div class="card-body">
    <span class="categoria">Gestão Financeira</span>
    <h2>Como Organizar as Finanças da Sua Empresa</h2>
    <p>Aprenda estratégias essenciais para manter o controle financeiro da sua empresa...</p>
    <div class="meta">
      <span>👤 João Silva</span>
      <a href="#">Ler artigo →</a>
    </div>
    <div class="footer">
      <span>🕒 5 min</span>
      <span>09 de janeiro de 2025</span>
    </div>
  </div>
</div>

<div class="card">
  <img src="./image/IMG-20250806-WA0002.jpg" alt="">
  <div class="card-body">
    <span class="categoria">Fluxo de Caixa</span>
    <h2>Fluxo de Caixa: O Que É e Como Gerenciar</h2>
    <p>Entenda a importância do fluxo de caixa e aprenda técnicas práticas...</p>
    <div class="meta">
      <span>👤 Maria Santos</span>
      <a href="#">Ler artigo →</a>
    </div>
    <div class="footer">
      <span>🕒 7 min</span>
      <span>07 de janeiro de 2025</span>
    </div>
  </div>
</div>

<div class="card">
  <img src="./image/IMG-20250806-WA0003.jpg" alt="">
  <div class="card-body">
    <span class="categoria">Fluxo de Caixa</span>
    <h2>Fluxo de Caixa: A contgem de valores</h2>
    <p>Entenda como realizar esse proxesso...</p>
    <div class="meta">
      <span>👤 Maria Santos</span>
      <a href="#">Ler artigo →</a>
    </div>
    <div class="footer">
      <span>🕒 7 min</span>
      <span>07 de janeiro de 2025</span>
    </div>
  </div>
</div>

<div class="card">
  <img src="./image/IMG-20250806-WA0004.jpg" alt="">
  <div class="card-body">
    <span class="categoria">Fluxo de Caixa</span>
    <h2>Como realizar e organizar os valores</h2>
    <p>Veja o crescimento da empresa com a organização do fluxo</p>
    <div class="meta">
      <span>👤 Maria Santos</span>
      <a href="#">Ler artigo →</a>
    </div>
    <div class="footer">
      <span>🕒 7 min</span>
      <span>07 de janeiro de 2025</span>
    </div>
  </div>
</div>

<div class="card">
  <img src="./image/IMG-20250806-WA0005.jpg" alt="">
  <div class="card-body">
    <span class="categoria">Fluxo de Caixa</span>
    <h2>O aumento das informações</h2>
    <p>A que ponto podemos aumentar o aumento dos registros</p>
    <div class="meta">
      <span>👤 Maria Santos</span>
      <a href="#">Ler artigo →</a>
    </div>
    <div class="footer">
      <span>🕒 7 min</span>
      <span>07 de janeiro de 2025</span>
    </div>
  </div>
</div>

      </div>
    </main>
  </div>

  <script src="js/app-artigos.js"></script>
</body>
</html>
