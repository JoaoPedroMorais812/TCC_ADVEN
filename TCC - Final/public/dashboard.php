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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/styles-dashboard.css" />
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
            <li class="active"><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
            <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
            <li><a href="historico.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
            <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
            <li><a href="anotacoes.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
            <li><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
            <li><a href="notificacoes.php"><i class="bi bi-bell"></i><span>Notificações</span><span class="badge">2</span></a></li>
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

    <!-- BOTÃO MOBILE -->
    <button id="menu-toggle" class="menu-btn">
        <i class="bi bi-list"></i>
    </button>

    <!-- CONTAINER PRINCIPAL -->
    <div class="dashboard">

        <!-- BARRA DE TOPO -->
        <div class="header-bar">
            <h1>Dashboard</h1>
            <div class="header-controls">
                <select class="period-select">
                    <option>Mensal</option>
                    <option>Semanal</option>
                    <option>Anual</option>
                </select>
                <button class="filter-btn">
                    <span class="icon"><i class="bi bi-funnel"></i></span> Filtros
                </button>
            </div>
        </div>

        <!-- CARDS RESUMO -->
        <div class="cards">
            <div class="card green">
                <div>
                    <p class="title">Créditos</p>
                    <h2>R$ 0,00</h2> <!-- será atualizado via JS -->
                    <p class="percent positive">+0%</p>
                </div>
                <div class="icon"><i class="bi bi-graph-up-arrow"></i></div>
            </div>
            <div class="card red">
                <div>
                    <p class="title">Débitos</p>
                    <h2>R$ 0,00</h2> <!-- será atualizado via JS -->
                    <p class="percent negative">0%</p>
                </div>
                <div class="icon"><i class="bi bi-graph-down-arrow"></i></div>
            </div>
            <div class="card purple">
                <div>
                    <p class="title">Saldo</p>
                    <h2>R$ 0,00</h2> <!-- será atualizado via JS -->
                    <p class="percent positive">0%</p>
                </div>
                <div class="icon"><i class="bi bi-calculator"></i></div>
            </div>
        </div>

        <!-- GRÁFICOS E HISTÓRICO -->
        <div class="charts">
            <div class="chart-box">
                <div class="chart-header">
                    <h3>Crédito vs Débito</h3>

                    <div class="chart-controls">
                        <button id="btnBarra" class="chart-btn"><i class="bi bi-bar-chart-fill"></i></button>
                        <button id="btnLinha" class="chart-btn"><i class="bi bi-graph-up"></i></button>
                    </div>
                </div>
                <canvas id="graficoBarra"></canvas>
                <canvas id="graficoLinha" style="display:none;"></canvas>
            </div>

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
                    <tbody id="history-body">
                        <!-- será preenchido via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- IMPORTES JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/app-dashboard.js"></script>

</body>
</html>
