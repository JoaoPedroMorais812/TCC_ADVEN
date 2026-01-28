<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receitas</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/styles-historico.css">
      <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">
</head>

<body class="dark">

  <button class="menu-btn" onclick="document.querySelector('.sidebar').classList.toggle('open')">
    <i class="fa fa-bars"></i>
  </button>

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
            <li class="active"><a href="historico.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
            <li ><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
            <li><a href="anotacoes.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
            <li><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
            <li>
                <a href="notificacoes.php"><i class="bi bi-bell"></i><span>Notificações</span><span class="badge">2</span></a>
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

    <button id="menu-toggle" class="menu-btn">
        <i class="bi bi-list"></i>
    </button>
  <div class="cont-prin">
    <div class="dashboard-container">

      <header class="dashboard-header">
        <h1 class="header-title">Receitas</h1>
      </header>

      <main class="main-content">

        <div class="widgets-container" style="display: flex; gap: 20px; margin-bottom: 20px;">
          <div class="widget">
            <h3>Agenda Financeira</h3>
            <div id="agenda-financeira" class="widget-list"></div>
          </div>
          <div class="widget">
            <h3>Próximas Saídas</h3>
            <div id="proximas-saidas" class="widget-list"></div>
          </div>
          <div class="widget">
            <h3>Notificações</h3>
            <div id="notificacoes" class="widget-list"></div>
          </div>
        </div>

        <div class="filter-bar">
          <div class="search-input">
            <i class="fa fa-search"></i>
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
            <option>Débitos</option>
            <option>Crédito</option>
            <option>Investimentos</option>
            <option>Empréstimos</option>
          </select>
<a href="../api/Historico/export-historico.php" class="btn btn-primary px-3 py-2 rounded">
    <i class="fa fa-download"></i> Exportar Receitas
</a>

        </div>

        <div class="table-container">
          <div class="table-header">
            <h3 class="table-title">Lista de Receitas</h3>
            <span class="table-subtitle" id="total-lancamentos">0 lançamentos - Total R$ 0,00</span>
          </div>

          <div class="table-responsive">
            <table class="data-table table">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Conta</th>
                  <th>Categoria</th>
                  <th>Valor</th>
                  <th>Recorrência</th>
                  <th>Editar</th>
                  <th>Excluir</th>
                </tr>
              </thead>
              <tbody id="table-content">
              </tbody>
            </table>
          </div>
        </div>
      </main>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/app-historico.js"></script>

</body>

</html>

