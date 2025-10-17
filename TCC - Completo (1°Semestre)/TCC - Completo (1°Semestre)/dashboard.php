<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- ========================== METADADOS ========================== -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>

    <!-- ========================== ÍCONES E ESTILOS ========================== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/styles-dashboard.css" />
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
      <li class="active"><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
      <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
      <li><a href="notas.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
    
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

    <!-- ========================== CONTEÚDO PRINCIPAL ========================== -->
    <div class="dashboard">

        <!-- BARRA DE TOPO -->
        <div class="header-bar">
            <h1>Dashboard</h1>
            <div class="header-controls">
                <!-- SELEÇÃO DE PERÍODO -->
                <select class="period-select">
                    <option>Mensal</option>
                    <option>Semanal</option>
                    <option>Diário</option>
                    <option>Anual</option>
                </select>

                <!-- BOTÃO DE FILTRO -->
                <button class="filter-btn">
                    <span class="icon"><i class="bi bi-funnel"></i></span> Filtros
                </button>
            </div>
        </div>

        <!-- CARDS DE RESUMO -->
        <div class="cards">
            <!-- CARD: RECEITAS -->
            <div class="card green">
                <div>
                    <p class="title">Receitas</p>
                    <h2>R$ 85.430,00</h2>
                    <p class="percent positive">+12.5%</p>
                </div>
                <div class="icon"><i class="bi bi-graph-up-arrow"></i></div>
            </div>

            <!-- CARD: DESPESAS -->
            <div class="card red">
                <div>
                    <p class="title">Despesas</p>
                    <h2>R$ 54.280,00</h2>
                    <p class="percent negative">-3.2%</p>
                </div>
                <div class="icon"><i class="bi bi-graph-down-arrow"></i></div>
            </div>

            <!-- CARD: LUCRO -->
            <div class="card blue">
                <div>
                    <p class="title">Lucro</p>
                    <h2>R$ 31.150,00</h2>
                    <p class="percent positive">+18.7%</p>
                </div>
                <div class="icon"><i class="bi bi-currency-dollar"></i></div>
            </div>

            <!-- CARD: TOTAL -->
            <div class="card purple">
                <div>
                    <p class="title">Total</p>
                    <h2>R$ 139.710,00</h2>
                    <p class="percent positive">+8.4%</p>
                </div>
                <div class="icon"><i class="bi bi-calculator"></i></div>
            </div>
        </div>

        <!-- GRÁFICOS -->
        <div class="charts">
            <!-- GRÁFICO DE COLUNAS -->
            <div class="chart-box">
                <div class="chart-header">
                    <h3>Receitas vs Despesas</h3>
                    <div class="chart-controls">
                        <button class="chart-btn"><i class="bi bi-bar-chart-fill"></i></button>
                        <button class="chart-btn"><i class="bi bi-pie-chart-fill"></i></button>
                    </div>
                </div>
                <div class="chart-placeholder">Gráfico de Colunas</div>
            </div>

            <!-- GRÁFICO DE LINHA -->
            <div class="chart-box">
                <div class="chart-header">
                    <h3>Fluxo de Caixa</h3>
                </div>
                <div class="chart-placeholder">Gráfico de Linha</div>
            </div>
        </div>

        <!-- HISTÓRICO FINANCEIRO -->
        <div class="history-box">
            <h3>Histórico Recente</h3>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- REGISTROS -->
                    <tr>
                        <td>Venda de produtos</td>
                        <td class="positive">+R$ 2.500</td>
                        <td>14/01/2025</td>
                        <td><span class="badge receita">Receita</span></td>
                    </tr>
                    <tr>
                        <td>Pagamento fornecedor</td>
                        <td class="negative">R$ 1.800</td>
                        <td>13/01/2025</td>
                        <td><span class="badge despesa">Despesa</span></td>
                    </tr>
                    <tr>
                        <td>Prestação de serviços</td>
                        <td class="positive">+R$ 3.200</td>
                        <td>12/01/2025</td>
                        <td><span class="badge receita">Receita</span></td>
                    </tr>
                    <tr>
                        <td>Energia elétrica</td>
                        <td class="negative">R$ 450</td>
                        <td>11/01/2025</td>
                        <td><span class="badge despesa">Despesa</span></td>
                    </tr>
                    <tr>
                        <td>Venda online</td>
                        <td class="positive">+R$ 1.750</td>
                        <td>10/01/2025</td>
                        <td><span class="badge receita">Receita</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================== JAVASCRIPT ========================== -->
    <script src="js/app-dashboard.js"></script>

</body>

</html>