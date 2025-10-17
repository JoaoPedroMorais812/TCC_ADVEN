<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Bloco de Notas</title>
  <link rel="stylesheet" href="css/styles-bloco.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
      <li><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
      <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
      <li><a href="notas.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
    
      <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
      <li class="active"><a href="bloco.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
      <li><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
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

  <div class="notas-page">
    <div class="header">
      <h1>Bloco de Notas</h1>
      <button class="btn-nova"><i class="bi bi-plus"></i> Nova Anotação</button>

    </div>

    <!-- Barra de busca de anotações -->
    <div class="search-container">
      <i class="bi bi-search"></i>
      <input type="text" class="search" id="search" placeholder="Buscar anotações..." oninput="searchNotes()">
    </div>

    <!-- Seção de anotações favoritas -->
    <div class="favoritas">
      <h2 id="favoritasTitulo"><i class="bi bi-star"></i> Favoritas</h2>
      <div class="notas-grid" id="favoriteNotes">

        <!-- Exemplo de nota favorita -->
        <div class="nota amarelo">
          <h3>Senhas Importantes</h3>
          <p>Banco do Brasil: usuario123</p>
          <p>Itaú: empresa456</p>
          <p>Receita Federal: cnpj789</p>
          <div class="nota-footer">
            <span><i class="bi bi-clock"></i> Editado: 14/01/2025, 21:00</span>
            <div class="actions">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-pencil"></i>
              <i class="bi bi-trash text-red"></i>
            </div>
          </div>
        </div>

        <!-- Outra nota favorita -->
        <div class="nota verde">
          <h3>Ideias para Melhorias</h3>
          <p>Sistema de gestão:</p>
          <p>- Automatizar relatórios</p>
          <p>- Integrar com banco</p>
          <p>- Melhorar interface</p>
          <div class="nota-footer">
            <span><i class="bi bi-clock"></i> Criado: 13/01/2025, 21:00</span>
            <div class="actions">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-pencil"></i>
              <i class="bi bi-trash text-red"></i>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Seção de todas as anotações -->
    <div class="todas">
      <h2 id="todasTitulo">Todas as Anotações</h2>
      <div class="notas-grid" id="allNotes">

        <!-- Exemplo de anotação -->
        <div class="nota azul">
          <h3>Reunião Cliente ABC</h3>
          <p>Pontos importantes:</p>
          <p>- Apresentar nova proposta</p>
          <p>- Discutir prazos</p>
          <p>- Negociar valores</p>
          <div class="nota-footer">
            <span><i class="bi bi-clock"></i> Criado: 11/01/2025, 21:00</span>
            <div class="actions">
              <i class="bi bi-star"></i>
              <i class="bi bi-pencil"></i>
              <i class="bi bi-trash text-red"></i>
            </div>
          </div>
        </div>

        <!-- Outra anotação -->
        <div class="nota roxo">
          <h3>Fornecedores</h3>
          <p>Lista de fornecedores aprovados:</p>
          <p>1. Empresa X – (11) 1234-5678</p>
          <p>2. Empresa Y – (11) 8765-4321</p>
          <p>3. Empresa Z – (11) 5555-5555</p>
          <div class="nota-footer">
            <span><i class="bi bi-clock"></i> Editado: 12/01/2025, 21:00</span>
            <div class="actions">
              <i class="bi bi-star"></i>
              <i class="bi bi-pencil"></i>
              <i class="bi bi-trash text-red"></i>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Mensagem quando não houver resultados de busca -->
    <p id="noResults" style="display: none; text-align: center; margin-top: 20px; color: #94a3b8;">
      Não há anotações correspondentes.
    </p>

    <!-- JavaScript principal da página -->
    <script src="js/app-bloco.js"></script>
</body>

</html>