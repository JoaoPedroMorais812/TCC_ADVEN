<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receitas</title>

  <!-- Bootstrap CSS (necessário para btn-warning e btn-danger) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Ícones do Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- CSS específico para histórico -->
  <link rel="stylesheet" href="css/styles-historico.css">

  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">
</head>

<body class="dark">

  <!-- Sidebar do registro -->
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
      <li class="active"><a href="historico.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
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

    <div class="logout">
      <a href="./index.php" class="link-limpo">
        <i class="bi bi-arrow-bar-right"></i><span>Sair</span>
      </a>
    </div>
  </div>

  <button id="menu-toggle" class="menu-btn">
    <i class="bi bi-list"></i>
  </button>

  <!-- Conteúdo principal -->
  <div class="cont-prin">
    <div class="dashboard-container">
      <header class="dashboard-header">
        <h1 class="header-title">Receitas</h1>
      </header>

      <main class="main-content">
        <div class="left-panel">

          <div class="filter-bar">
            <div class="search-input">
              <i class="fas fa-search"></i>
              <input type="text" placeholder="Buscar Registro..." id="search-input">
            </div>

            <select class="filter-select" id="filter-periodo">
              <option>Todas as despesas</option>
              <option>Últimos 7 dias</option>
              <option>Últimos 30 dias</option>
              <option>Últimos 6 meses</option>
              <option>Último ano</option>
            </select>

            <select class="filter-select" id="filter-fontes">
              <option>Todas as fontes</option>
              <option>Debitos</option>
              <option>Credito</option>
              <option>Investimentos</option>
              <option>Empréstimos</option>
            </select>

            <button class="btn-export"><i class="bi bi-download"></i> +Exportar Receitas</button>
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
                </thead>

                <tbody id="table-content">
                  <tr>
                    <td>2025-08-18</td>
                    <td>Conta Corrente</td>
                    <td>Prestação de Serviço</td>
                    <td>R$ 1.200,00</td>
                    <td>Sim</td>
                    <td class="actions-edit">
                      <button class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i>
                      </button>
                    </td>
                    <td class="actions-delete">
                      <button class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>

              </table>
            </div>
          </div>

        </div>
      </main>
    </div>
  </div>

  <script src="js/app-historico.js"></script>
</body>

</html>