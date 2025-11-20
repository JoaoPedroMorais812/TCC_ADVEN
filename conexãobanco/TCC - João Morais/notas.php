<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receitas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/styles-notas.css">
  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">
</head>

<body class="dark">

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
      <li class="active"><a href="notas.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>

      <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
      <li><a href="bloco.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
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

  <!-- Wrapper para o Conteúdo Principal da Página -->
  <div class="main-content-wrapper">
    <!-- Conteúdo original de Notas.html começa aqui -->
    <div class="dashboard-container">
      <header class="dashboard-header">
        <h1 class="header-title">Receitas</h1>

      </header>
      <main class="main-content">
        <div class="left-panel">
          <div class="filter-bar">
            <div class="search-input">
              <i class="fas fa-search"></i>
              <input type="text" placeholder="Buscar no dashboard..." id="search-input">
            </div>
            <select class="filter-select" id="filter-periodo">
              <option>Todas as despesas</option>
              <option>Últimos 7 dias</option>
              <option>Últimos 30 dias</option>
            </select>
            <select class="filter-select" id="filter-fontes">
              <option>Todas as fontes</option>
              <option>Venda de Produtos</option>
              <option>Prestação de Serviço</option>
            </select>
          </div>
          <div class="table-container">
            <div class="table-header">
              <h3 class="table-title">Lista de Receitas</h3>
              <span class="table-subtitle" id="total-lancamentos">0 lançamentos - Total R$ 0,00</span>

            </div>
            <div class="table-body">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Data</th>
                    <th>Conta</th>
                    <th>Fonte</th>
                    <th>Valor</th>
                    <th>Recorrência</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                  </tr>
                <tbody id="table-content">
                  <tr>
                    <td>2025-08-18</td>
                    <td>Conta Corrente</td>
                    <td>Prestação de Serviço</td>
                    <td>R$ 1.200,00</td>
                    <td>Sim</td>
                    <td class="actions-edit">
                      <button class="edit-btn-warning"><i class="bi bi-pencil"></i></button>
                    </td>
                    <td class="actions-delete">
                      <button class="delete-btn-danger"><i class="bi bi-trash"></i></button>
                    </td>
                  </tr>
                </tbody>
                </thead>
                <tbody id="table-content">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="js/app-notas.js"></script>
</body>

</html>