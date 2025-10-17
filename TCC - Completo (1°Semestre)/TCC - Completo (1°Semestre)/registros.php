<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <!-- Link para o Tailwind CSS (para classes utilitárias) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Links para os seus arquivos de estilos personalizados -->
    <link rel="stylesheet" href="css/styles-registros.css">
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
      <li class="active"><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
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


    <!-- Wrapper para o Conteúdo Principal da Página -->
    <div class="main-content-wrapper">
        <!-- Conteúdo original de registros.html começa aqui -->
        <div class="registros-container">
            <h1 class="page-title">Registros</h1>

            <!-- Abas de Navegação -->
            <div class="tabs-navigation">
                <button class="tab-button active" data-tab="debitos">Débitos</button>
                <button class="tab-button" data-tab="ganhos">Ganhos</button>
                <button class="tab-button" data-tab="adicionais">Adicionais</button>
                <button class="tab-button" data-tab="investimentos">Investimentos</button>
            </div>

            <!-- Conteúdo da Aba de Débitos -->
            <div id="debitos-tab-content" class="tab-content active">
                <form id="debito-form" class="registro-form">
                    <!-- Linha 1: Nome/Descrição e Valor -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome-descricao">Nome/Descrição *</label>
                            <input type="text" id="nome-descricao" name="nome_descricao"
                                placeholder="Descrição do débito" required>
                        </div>
                        <div class="form-group">
                            <label for="valor">Valor (R$) *</label>
                            <input type="number" id="valor" name="valor" value="0.00" step="0.01" required>
                        </div>
                    </div>

                    <!-- Linha 2: Data de Vencimento e Categoria -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="data-vencimento">Data de Vencimento *</label>
                            <input type="date" id="data-vencimento" name="data_vencimento" required>
                        </div>
                        <div class="form-group">
                            <label for="categoria">Categoria *</label>
                            <select id="categoria" name="categoria" required>
                                <option value="">Selecione uma categoria</option>
                                <!-- Opções serão preenchidas via JavaScript -->
                            </select>
                        </div>
                    </div>

                    <!-- Linha 3: Recorrência e Status -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="recorrencia">Recorrência</label>
                            <select id="recorrencia" name="recorrencia">
                                <option value="sem-recorrencia">Sem recorrência</option>
                                <!-- Opções serão preenchidas via JavaScript -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status">
                                <option value="pendente">Pendente</option>
                                <!-- Opções serão preenchidas via JavaScript -->
                            </select>
                        </div>
                    </div>

                    <!-- Linha 4: Observações -->
                    <div class="form-group full-width">
                        <label for="observacoes">Observações</label>
                        <textarea id="observacoes" name="observacoes"
                            placeholder="Observações adicionais..."></textarea>
                    </div>

                    <!-- Botão de Adicionar Débito -->
                    <div class="form-actions">
                        <button type="submit" class="add-button">
                            <i class="fas fa-plus"></i> Adicionar Débito
                        </button>
                    </div>
                </form>
            </div>

            <!-- Conteúdo das outras abas (vazio por enquanto) -->
            <div id="ganhos-tab-content" class="tab-content">
                <p class="placeholder-text">Conteúdo para Ganhos...</p>
            </div>
            <div id="adicionais-tab-content" class="tab-content">
                <p class="placeholder-text">Conteúdo para Adicionais...</p>
            </div>
            <div id="investimentos-tab-content" class="tab-content">
                <p class="placeholder-text">Conteúdo para Investimentos...</p>
            </div>
        </div>
        <!-- Conteúdo original de registros.html termina aqui -->
    </div>

    <!-- Seu arquivo JavaScript -->
    <script src="js/app-registros.js"></script>
</body>

</html>