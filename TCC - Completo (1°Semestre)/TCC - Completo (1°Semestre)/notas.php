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
      <li ><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
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
                <button class="header-button">Adicionar Nova Receita</button>
            </header>
            <section class="metrics-cards">
                <div class="metric-card">
                    <span class="card-label">Total de Receitas</span>
                    <span class="card-value" id="total-receitas">R$ 0,00</span>
                    <span class="card-change positive" id="total-receitas-change"></span>
                </div>
                <div class="metric-card">
                    <span class="card-label">Total de Despesas</span>
                    <span class="card-value" id="total-despesas">R$ 0,00</span>
                    <span class="card-change negative" id="total-despesas-change"></span>
                </div>
                <div class="metric-card">
                    <span class="card-label">Saldo</span>
                    <span class="card-value" id="saldo">R$ 0,00</span>
                    <span class="card-change positive" id="saldo-change"></span>
                </div>
                <div class="metric-card">
                    <span class="card-label">Próximas Entradas</span>
                    <span class="card-value" id="previsoes">R$ 0,00</span>
                    <span class="card-change positive" id="previsoes-change">2 contas a vencer</span>
                </div>
            </section>
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
                        <select class="filter-select" id="filter-contas">
                            <option>Todas as contas</option>
                            <option>Banco do Brasil</option>
                            <option>Itaú</option>
                        </select>
                    </div>
                    <div class="table-container">
                        <div class="table-header">
                            <h3 class="table-title">Lista de Receitas</h3>
                            <span class="table-subtitle" id="total-lancamentos">0 lançamentos - Total R$ 0,00</span>
                            <button class="table-add-button">
                                <i class="fas fa-plus"></i>
                                <span>Adicionar</span>
                            </button>
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
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="table-content">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <aside class="right-panel">
                    <div class="widget">
                        <div class="widget-header">
                            <h4 class="widget-title">Agenda Financeira</h4>
                            <a href="#" class="widget-link">Ver Agenda Completa</a>
                        </div>
                        <div class="widget-content" id="agenda-financeira">
                        </div>
                    </div>
                    <div class="widget">
                        <div class="widget-header">
                            <h4 class="widget-title">Notificações <span class="notification-count"
                                    id="notification-count"></span></h4>
                        </div>
                        <div class="widget-content" id="notificacoes">
                        </div>
                    </div>
                    <div class="widget">
                        <div class="widget-header">
                            <h4 class="widget-title">Próximas Saídas</h4>
                        </div>
                        <div class="widget-content" id="proximas-saidas">
                        </div>
                    </div>
                </aside>
            </main>
        </div>
        <!-- Conteúdo original de Notas.html termina aqui -->
    </div>

    <script src="js/app-notas.js"></script>
</body>

</html>