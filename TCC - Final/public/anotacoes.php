<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../app/config/database.php';

// proteção de sessão
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$db = new Database();
$pdo = $db->getConnection();

// busca anotações do usuário logado
$stmt = $pdo->prepare("
    SELECT 
        ano_Id               AS id,
        ano_Titulo           AS titulo,
        ano_Data             AS data,
        ano_Conteudo         AS conteudo,
        ano_Cor              AS cor,
        ano_Favorito         AS favorito,
        ano_DataAtualizacao  AS atualizado
    FROM tbl_Anotacao
    WHERE ano_IdUsuario = :idUsuario
    ORDER BY ano_Data DESC
");
$stmt->bindParam(":idUsuario", $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$anotacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Bloco de Notas</title>
    <link rel="stylesheet" href="css/styles-anotacoes.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
            <li><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
            <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
            <li><a href="historico.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
            <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
            <li class="active"><a href="anotacoes.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
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

    <!--CONTAINER PRINCIPAL-->
    <div class="notas-page">
        <div class="header">
            <h1>Bloco de Notas</h1>
            <button class="btn-nova"><i class="bi bi-plus"></i> Nova Anotação</button>
        </div>
        <div class="search-container">
            <i class="bi bi-search"></i>
            <input type="text" class="search" id="search" placeholder="Buscar anotações..." oninput="searchNotes()">
        </div>

        <!-- ANOTAÇÕES FAVORITAS -->
        <div class="favoritas">
            <h2 id="favoritasTitulo"><i class="bi bi-star"></i> Favoritas</h2>
            <div class="notas-grid" id="favoriteNotes">

            </div>
        </div>

        <!-- ANOTAÇÕES -->
        <div class="todas">
            <h2 id="todasTitulo">Todas as Anotações</h2>
            <div class="notas-grid" id="allNotes">
                <?php if (!empty($anotacoes) && is_array($anotacoes)): ?>
                    <?php foreach ($anotacoes as $nota): ?>
                        <div class="nota <?= isset($nota['cor']) ? htmlspecialchars($nota['cor']) : 'amarelo' ?>">
                            <h3><?= isset($nota['titulo']) ? htmlspecialchars($nota['titulo']) : 'Sem título' ?></h3>
                            <p><?= isset($nota['conteudo']) ? nl2br(htmlspecialchars($nota['conteudo'])) : 'Sem conteúdo' ?></p>
                            <div class="nota-footer">
                                <span><i class="bi bi-clock"></i> Criado:
                                    <?= isset($nota['data_criacao']) ? date('d/m/Y, H:i', strtotime($nota['data_criacao'])) : 'Data desconhecida' ?>
                                </span>
                                <div class="actions">
                                    <?php if (!empty($nota['favorita'])): ?>
                                        <i class="bi bi-star-fill"></i>
                                    <?php else: ?>
                                        <i class="bi bi-star"></i>
                                    <?php endif; ?>
                                    <i class="bi bi-pencil"></i>
                                    <i class="bi bi-trash text-red"></i>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; margin-top: 20px; color: #94a3b8;">
                        Não há anotações.
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <p id="noResults" style="display: none; text-align: center; margin-top: 20px; color: #94a3b8;">
            Nenhuma anotação foi criada!
        </p>

        <!-- MODAL NOVA ANOTAÇÃO-->
        <div id="noteModal" class="modal hidden">
            <div class="modal-content">
                <h2 id="modalTitle">Nova Anotação</h2>

                <label for="noteTitle">Título</label>
                <input type="text" id="noteTitle">

                <label for="noteContent">Conteúdo</label>
                <textarea id="noteContent"></textarea>

                <fieldset class="color-group">
                    <input type="radio" name="noteColor" value="amarelo" checked>
                    <input type="radio" name="noteColor" value="verde">
                    <input type="radio" name="noteColor" value="azul">
                    <input type="radio" name="noteColor" value="roxo">
                    <input type="radio" name="noteColor" value="rosa">
                    <input type="radio" name="noteColor" value="laranja">
                </fieldset>

                <label>
                    <input type="checkbox" id="noteFavorite">
                    Marcar como favorita
                </label>

                <div class="modal-actions">
                    <button id="btnCancel">Cancelar</button>
                    <button id="btnSave">Criar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- IMPORTE JS -->
    <script src="js/app-anotacoes.js"></script>
</body>

</html>