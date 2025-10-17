<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Agenda</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/styles-agenda.css" />
    <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">
</head>

<body>
   <!-- Sidebar fixa à esquerda -->
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
      <li><a href="notas.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
    
      <li class="active"><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
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

    <!-- ============================== CONTEÚDO PRINCIPAL DA AGENDA ============================== -->
    <main class="agenda-container">
    
        <div class="agenda-header">
            <h1>Agenda</h1>
            <button class="btn-novo">+ Novo Compromisso</button>
        </div>

    
        <div class="calendar-wrapper">
         
            <div class="calendar-box">
                <div class="calendar-header">
                    <h2 id="monthYear">Agosto 2025</h2>
                    <div class="calendar-controls">
                        <button onclick="prevMonth()">&lt;</button>
                        <button onclick="goToToday()">Hoje</button>
                        <button onclick="nextMonth()">&gt;</button>
                    </div>
                </div>

                
                <div class="day-names">
                    <div>Dom</div><div>Seg</div><div>Ter</div><div>Qua</div>
                    <div>Qui</div><div>Sex</div><div>Sáb</div>
                </div>

            
                <div class="days" id="calendarDays"></div>
            </div>

  
            <div class="right-panel">
                <div class="selected-day">
                    <h3 id="selectedDate">Nenhuma data selecionada</h3>
                    <p id="selectedList">Nenhum compromisso para este dia</p>
                </div>

                <div class="appointments">
                    <h3>Próximos Compromissos</h3>
                    <div class="appointment azul">
                        <strong>Reunião com cliente ABC</strong>
                        <span>19/01/2025 às 14:00</span>
                    </div>
                    <div class="appointment vermelho">
                        <strong>Pagamento fornecedor XYZ</strong>
                        <span>21/01/2025 às 09:00</span>
                    </div>
                    <div class="appointment laranja">
                        <strong>Entrega relatório financeiro</strong>
                        <span>24/01/2025 às 17:00</span>
                    </div>
                    <div class="appointment verde">
                        <strong>Revisão orçamento</strong>
                        <span>27/01/2025 às 10:00</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ============================== MODAL DE NOVO COMPROMISSO ============================== -->
    <div class="modal-bg" id="modalBg">
        <div class="modal">
            <h2>Novo Compromisso</h2>
            
            <label>Título *</label>
            <input type="text" placeholder="Título do compromisso" />

            <div class="modal-row">
                <div class="col">
                    <label>Data *</label>
                    <input type="date" />
                </div>
                <div class="col">
                    <label>Horário *</label>
                    <input type="time" />
                </div>
            </div>

            <label>Tipo *</label>
            <select>
                <option>Reunião</option>
                <option>Pagamento</option>
                <option>Entrega</option>
                <option>Outro</option>
            </select>

            <label>Descrição</label>
            <textarea placeholder="Descrição do compromisso..."></textarea>

            <div class="modal-buttons">
                <button class="cancelar" onclick="fecharModal()">Cancelar</button>
                <button class="salvar">Salvar</button>
            </div>
        </div>
    </div>

    <!-- ============================== SCRIPTS ============================== -->
    <script src="js/app-agenda.js"></script>
</body>
</html>
