<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>

    <link rel="stylesheet" href="css/styles-editarPerfil.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
      <li ><a href="dashboard.php"><i class="bi bi-bar-chart"></i><span>Dashboard</span></a></li>
      <li><a href="registros.php"><i class="bi bi-file-earmark-text"></i><span>Registros</span></a></li>
      <li><a href="notas.php"><i class="bi bi-graph-up-arrow"></i><span>Receitas</span></a></li>
    
      <li><a href="agenda.php"><i class="bi bi-calendar-week"></i><span>Agenda</span></a></li>
      <li><a href="bloco.php"><i class="bi bi-file-earmark"></i><span>Bloco de Notas</span></a></li>
      <li><a href="artigos.php"><i class="bi bi-book"></i><span>Artigos</span></a></li>
      <li>
        <a href="notificacoes.php"><i class="bi bi-bell"></i><span>Notificações</span><span class="badge">2</span></a>
      </li>
      <li><a href="suporte.php"><i class="bi bi-question-circle"></i><span>Suporte</span></a></li>
      <li class="active"><a href="configuracoes.php"><i class="bi bi-gear"></i><span>Configurações</span></a></li>
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
    

            <div class="content-body">
                <div class="profile-form-container">
                    <form id="editProfileForm">
                        <div class="form-section">
                            <h3>Foto de Perfil</h3>
                            <div class="form-group-inline">
                                <div class="profile-avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="input-field">
                                    <label for="profile-image-url">URL da imagem</label>
                                    <input type="text" id="profile-image-url" name="profile-image-url" placeholder="URL da imagem">
                                </div>
                            </div>
                            <div class="form-group-inline">
                                <div class="input-field">
                                    <label for="company-name">Nome da Empresa *</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-building"></i>
                                        <input type="text" id="company-name" name="company-name" required>
                                    </div>
                                </div>
                                <div class="input-field">
                                    <label for="cnpj">CNPJ *</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-hashtag"></i>
                                        <input type="text" id="cnpj" name="cnpj" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-inline">
                                <div class="input-field full-width">
                                    <label for="email">Email *</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" id="email" name="email" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section password-change-section">
                            <h3>Alterar Senha</h3>
                            <button type="button" class="cancel-password-change">Cancelar</button>

                            <div class="form-group-inline">
                                <div class="input-field full-width">
                                    <label for="current-password">Senha Atual *</label>
                                    <div class="input-with-icon-right">
                                        <i class="fas fa-lock"></i>
                                        <input type="password" id="current-password" name="current-password" required>
                                        <span class="toggle-password" data-target="current-password"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group-inline">
                                <div class="input-field">
                                    <label for="new-password">Nova Senha *</label>
                                    <div class="input-with-icon-right">
                                        <i class="fas fa-lock"></i>
                                        <input type="password" id="new-password" name="new-password" required>
                                        <span class="toggle-password" data-target="new-password"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                                <div class="input-field">
                                    <label for="confirm-new-password">Confirmar Nova Senha *</label>
                                    <div class="input-with-icon-right">
                                        <i class="fas fa-lock"></i>
                                        <input type="password" id="confirm-new-password" name="confirm-new-password" required>
                                        <span class="toggle-password" data-target="confirm-new-password"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="css/styles-editarPerfil.css"></script>
</body>
</html>