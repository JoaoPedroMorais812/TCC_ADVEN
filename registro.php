<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Adven</title>

  <!-- Bootstrap + CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="Css/style.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="body">

  <!-- SIDEBAR -->
  <nav id="sidebar">
    <div id="sidebar_content">
      <div id="user">
        <img src="/Css/imagens/logo.png" id="user_avatar" alt="Avatar">
        <p id="user_infos">
          <span class="item-description">Fulano de Tal</span>
          <span class="item-description">Lorem Ipsum</span>
        </p>
      </div>

      <ul id="side_items">
        <li class="side-item active">
          <a href="#"><i class="bi bi-graph-up" style="font-size: 20px"></i><span class="item-description">Dashboard</span></a>
        </li>
        <li class="side-item">
          <a href="#"><i class="bi bi-person-fill" style="font-size: 20px"></i><span class="item-description">Registros</span></a>
        </li>
        <li class="side-item">
          <a href="#"><i class="bi bi-journal-text" style="font-size: 20px"></i><span class="item-description">Agenda</span></a>
        </li>
        <li class="side-item">
          <a href="#"><i class="bi bi-calendar" style="font-size: 20px"></i><span class="item-description">Bloco de Notas</span></a>
        </li>
        <li class="side-item">
          <a href="#"><i class="bi bi-bell-fill" style="font-size: 20px"></i><span class="item-description">Notificações</span></a>
        </li>
        <li class="side-item">
          <a href="#"><i class="bi bi-journal-bookmark-fill" style="font-size: 20px"></i><span class="item-description">Saber Mais</span></a>
        </li>
        <li class="side-item">
          <a href="#"><i class="bi bi-gear" style="font-size: 20px"></i><span class="item-description">Configurações</span></a>
        </li>

      </ul>

      <button id="open_btn">
        <i class="bi bi-arrow-right"></i>
      </button>
    </div>

    <div id="logout">
      <button id="logout_btn">
        <i class="bi bi-box-arrow-right" style="font-size: 20px"></i>
        <span class="item-description">Logout</span>
      </button>
    </div>
  </nav>  

<!-- /* CONTEÚDO PRINCIPAL -->
<main id="main_content">
    <div class="container-fluid">
    
    </div>

</main>
  <script>
  // Script para abrir/fechar a sidebar
  document.getElementById('open_btn').addEventListener('click', function () {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main_content');

    sidebar.classList.toggle('open-sidebar');

    // Adiciona/remover classe de margem do conteúdo principal
    if (sidebar.classList.contains('open-sidebar')) {
      main.style.marginLeft = '15%';
    } else {
      main.style.marginLeft = '10%';
    }
  });
</script>
</body>

</html>
