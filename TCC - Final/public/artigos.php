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
  <title>Artigos</title>
  <link rel="stylesheet" href="css/styles-artigos.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">

</head>

<body>
  <div class="container">
    <!-- SIDEBAR LATERAL -->

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
            <li><a href="historico.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
            <li ><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
            <li><a href="anotacoes.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
            <li class="active"><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
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
            <h2>10 dicas de gestão financeira para pequenas empresas</h2>
            <p>Descubra práticas essenciais para manter a saúde financeira do seu negócio.</p>
            <div class="meta">
              <span>👤 Contábeis</span>
              <a href="https://www.contabeis.com.br/artigos/68466/10-dicas-de-gestao-financeira-para-pequenas-empresas" target="_blank">Acessar o artigo →</a>
            </div>
            <div class="footer">
              <span>🕒 6 min</span>
              <span>Novembro de 2025</span>
            </div>
          </div>
        </div>

        <div class="card">
          <img src="./image/IMG-20250806-WA0002.jpg" alt="">
          <div class="card-body">
            <span class="categoria">Gestão Financeira</span>
            <h2>5 passos para melhorar a gestão financeira da sua empresa</h2>
            <p>Aprenda a organizar e otimizar os recursos financeiros em cinco etapas práticas.</p>
            <div class="meta">
              <span>👤 Poder360</span>
              <a href="https://www.poder360.com.br/poder-empreendedor/leia-5-passos-para-melhorar-a-gestao-financeira-da-sua-empresa" target="_blank">Acessar o artigo →</a>
            </div>
            <div class="footer">
              <span>🕒 5 min</span>
              <span>Novembro de 2025</span>
            </div>
          </div>
        </div>

        <div class="card">
          <img src="./image/IMG-20250806-WA0003.jpg" alt="">
          <div class="card-body">
            <span class="categoria">Gestão Financeira</span>
            <h2>Small Business Financial Management</h2>
            <p>Guia completo da NetSuite para pequenas empresas administrarem suas finanças com eficiência.</p>
            <div class="meta">
              <span>👤 NetSuite</span>
              <a href="https://www.netsuite.com/portal/resource/articles/financial-management/small-business-financial-management.shtml" target="_blank">Acessar o artigo →</a>
            </div>
            <div class="footer">
              <span>🕒 8 min</span>
              <span>Novembro de 2025</span>
            </div>
          </div>
        </div>

        <div class="card">
          <img src="./image/IMG-20250806-WA0004.jpg" alt="">
          <div class="card-body">
            <span class="categoria">Gestão Financeira</span>
            <h2>10 dicas essenciais de gestão financeira para pequenas empresas</h2>
            <p>Saiba como aplicar boas práticas financeiras para garantir o crescimento sustentável.</p>
            <div class="meta">
              <span>👤 Gestão Nuvem</span>
              <a href="https://gestaonuvem.com.br/10-dicas-essenciais-de-gestao-financeira-para-pequenas-empresas/" target="_blank">Acessar o artigo →</a>
            </div>
            <div class="footer">
              <span>🕒 6 min</span>
              <span>Novembro de 2025</span>
            </div>
          </div>
        </div>

        <div class="card">
          <img src="./image/IMG-20250806-WA0005.jpg" alt="">
          <div class="card-body">
            <span class="categoria">Gestão Financeira</span>
            <h2>Small Business Financial Tips</h2>
            <p>Dicas práticas para pequenas empresas alcançarem estabilidade e crescimento financeiro.</p>
            <div class="meta">
              <span>👤 NetSuite</span>
              <a href="https://www.netsuite.com/portal/resource/articles/financial-management/small-business-financial-tips.shtml" target="_blank">Acessar o artigo →</a>
            </div>
            <div class="footer">
              <span>🕒 7 min</span>
              <span>Novembro de 2025</span>
            </div>
          </div>
        </div>


      </div>
    </main>
  </div>

  <script src="js/app-artigos.js"></script>
</body>

</html>