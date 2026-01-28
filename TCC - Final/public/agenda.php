<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';

// proteção de sessão
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$db = new Database();
$pdo = $db->getConnection();

// busca eventos direto no banco (tabela correta: tbl_Evento)
$stmt = $pdo->query("
    SELECT 
        id_Evento     AS id,
        eve_Titulo    AS titulo,
        eve_Descricao AS descricao,
        eve_Data      AS data,
        eve_Horario   AS horario,
        eve_Tipo      AS tipo,
        eve_Concluido AS concluido,
        eve_IdUsuario AS usuario
    FROM tbl_Evento
    ORDER BY eve_Data ASC, eve_Horario ASC
");
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agenda</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/styles-agenda.css" />
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
<div class="user-details">
<p class="username"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Usuário'); ?></p>
<p class="email"><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'email@dominio.com'); ?></p>

</div>

        </div>
    </div>
        <hr>
        <ul class="nav-links">
            <li><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
            <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
            <li><a href="historico.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
            <li class="active"><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
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

    <!-- CONTAINER PRINCIPAL -->
    <main class="agenda-container">
        <div class="agenda-header">
            <h1>Agenda</h1>
            <button class="btn-novo">+ Novo Compromisso</button>
        </div>

        <!-- CALENDÁRIO -->
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
                    <div>Dom</div>
                    <div>Seg</div>
                    <div>Ter</div>
                    <div>Qua</div>
                    <div>Qui</div>
                    <div>Sex</div>
                    <div>Sáb</div>
                </div>

                <div class="days" id="calendarDays"></div>
            </div>

            <!-- PAINEL LATERAL -->
            <div class="right-panel">
                <div class="selected-day">
                    <h3 id="selectedDate">Nenhuma data selecionada</h3>
                    <p id="selectedList">Nenhum compromisso para este dia</p>
                </div>
                <div class="appointments">
                    <h3>Próximos Compromissos</h3>

                    <?php
                    $listaFiltrada = array_filter($eventos, function ($e) {
                        return isset($e['id']) && !empty($e['id']);
                    });
                    ?>

                    <?php if (!empty($listaFiltrada)): ?>
                        <?php foreach ($listaFiltrada as $evento): ?>
                            <?php
                            $id        = $evento['id'];
                            $titulo    = $evento['titulo']    ?? '';
                            $descricao = $evento['descricao'] ?? '';
                            $data      = $evento['data']      ?? '';
                            $horario   = $evento['horario']   ?? '';
                            $tipo      = $evento['tipo']      ?? '';

                            $cor = match ($tipo) {
                                'Reunião'   => 'azul',
                                'Pagamento' => 'vermelho',
                                'Entrega'   => 'laranja',
                                default     => 'verde'
                            };
                            ?>
                            <div class="appointment <?= $cor ?>">
                                <strong><?= htmlspecialchars($titulo) ?></strong>
                                <span><?= htmlspecialchars($data) ?> às <?= htmlspecialchars($horario) ?></span>
                                <p><?= htmlspecialchars($descricao) ?></p>

                                <!-- Botão Concluir dentro de form -->
                                <form method="post" action="../api/agenda/concluir.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button type="submit" class="btn-acao btn-concluir" title="Concluir">
                                        <i class="bi bi-check-lg"></i> Concluir
                                    </button>
                                </form>

                                <!-- Botão Excluir dentro de form -->
                                <form method="post" action="../api/agenda/delete.php" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button type="submit" class="btn-acao btn-apagar" title="Apagar">
                                        <i class="bi bi-trash"></i> Excluir
                                    </button>
                                </form>

                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="sem-compromissos">Não existe nenhum compromisso</p>
                    <?php endif; ?>
                </div>
            </div>
    </main>

    <!-- MODAL DE NOVO COMPROMISSO -->
    <div class="modal-bg" id="modalBg">
        <div class="modal">
            <h2>Novo Compromisso</h2>
            <form id="formCompromisso">
                <label>Título</label>
                <input type="text" name="titulo" placeholder="Título do compromisso" required />

                <div class="modal-row">
                    <div class="col">
                        <label>Data</label>
                        <input type="date" name="data" required />
                    </div>
                    <div class="col">
                        <label>Horário</label>
                        <input type="time" name="horario" required />
                    </div>
                </div>

                <label>Tipo</label>
                <select name="tipo">
                    <option>Reunião</option>
                    <option>Pagamento</option>
                    <option>Entrega</option>
                    <option>Outro</option>
                </select>

                <label>Descrição</label>
                <textarea name="descricao" placeholder="Descrição do compromisso..."></textarea>

                <div class="modal-buttons">
                    <button type="button" class="cancelar" onclick="fecharModal()">Cancelar</button>
                    <button type="button" class="salvar">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- IMPORTE JS -->
    <script src="js/app-agenda.js"></script>

</body>

</html>