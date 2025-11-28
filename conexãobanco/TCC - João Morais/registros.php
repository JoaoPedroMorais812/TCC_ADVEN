<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style-registro.css">
    <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">
</head>

<body class="dark">

    <!-- Sidebar -->
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
            <li class="active"><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
            <li><a href="historico.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
            <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
            <li><a href="bloco.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
            <li><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
            <li><a href="notificacoes.php"><i class="bi bi-bell"></i><span>Notificações</span><span class="badge">2</span></a></li>
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

    <!-- Mobile menu -->
    <button id="menu-toggle" class="menu-btn">
        <i class="bi bi-list"></i>
    </button>

    <!-- Conteúdo principal -->
    <div class="cont-prin">
        <h1 class="page-title">Registros</h1>

        <form id="debito-form" class="registro-form" action="Php/process-registro.php" method="post">

            <div class="form-row">
                <div class="form-group">
                    <label for="nome-descricao">Nome/Descrição *</label>
                    <input type="text" id="nome-descricao" name="nome_descricao" required>
                </div>

                <div class="form-group">
                    <label for="valor">Valor (R$) *</label>
                    <input type="number" id="valor" name="valor" value="0.00" step="0.01" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label for="data-vencimento">Data de Publicação *</label>
                    <input type="date" id="data-vencimento" name="data_vencimento" required>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group-2">
                    <label for="categoria">Categoria *</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Selecione uma categoria</option>
                    </select>
                </div>

                <div class="form-group-2">
                    <label for="recorrencia">Recorrência</label>
                    <select id="recorrencia" name="recorrencia">
                        <option value="">Sem recorrência</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="observacoes">Observações</label>
                    <textarea id="observacoes" name="observacoes"></textarea>
                </div>

                <!-- Mensagem de retorno -->
                <div id="registro-msg" aria-live="polite"
                    style="margin-top:1rem; display:none; padding:10px; border-radius:7px;">
                </div>

                <div class="form-actions">
                    <button type="submit" class="add-button">
                        <i class="fas fa-plus"></i> Adicionar Registro
                    </button>

                    <button type="button" id="limpar-button" class="clear-button">
                        Limpar
                    </button>
                </div>

            </div>
        </form>
    </div>

    <div id="alert-box"></div>

    <script src="js/app-registros.js"></script>
</body>

</html>