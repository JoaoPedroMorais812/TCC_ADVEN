<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro</title>

    <link rel="stylesheet" href="css/styles-cadastro.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">

</head>
<body>
    <header class="navbar">
    <div class="navbar-container">
      <div class="logo">ADVEN</div>
      <nav class="nav-links">
        <a href="#" class="active"><i class="bi bi-house-door"></i> Home</a>
        <a href="./sobrenos.php"><i class="bi bi-info-circle"></i> Sobre Nós</a>
        <a href="./ptpv.php"><i class="bi bi-shield"></i> Política de Privacidade</a>
        <a href="./termos.php"><i class="bi bi-file-earmark-medical"></i> Termos de Uso</a>
      </nav>
      <div class="nav-auth">
        <a href="./login.php" class="login">Entrar</a>
        <a href="./cadastro.php" class="btn-primary">Cadastrar</a>
      </div>
    </div>
  </header>

    <div class="container">
        <form class="form-criar-conta" action="criar_conta.php" method="post" enctype="multipart/form-data">
            <h2>Criar nova conta</h2>

            <!-- Foto de Perfil -->
            <label class="foto-perfil-label" for="fotoPerfil">
                <div class="foto-perfil-placeholder" title="Clique para enviar foto de perfil">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#aaa" width="40" height="40" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
                    </svg>
                </div>
                <input type="file" id="fotoPerfil" name="fotoPerfil" accept="image/*" style="display:none" />
                <input type="text" name="urlImagem" placeholder="URL da imagem" />
                <small>(Opcional)</small>
            </label>

            <input type="text" name="nomeEmpresa" placeholder="Nome da sua empresa" required />

            <input type="text" name="cnpj" placeholder="00.000.000/0000-00" pattern="\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}" title="Digite um CNPJ válido" required />

            <input type="email" name="email" placeholder="seu@email.com" required />

            <div class="input-senha">
                <input type="password" id="senha" name="senha" placeholder="Sua senha" required />
                <button type="button" class="toggle-senha" onclick="toggleSenha('senha', this)" aria-label="Mostrar/ocultar senha">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            <div class="input-senha">
                <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme sua senha" required />
                <button type="button" class="toggle-senha" onclick="toggleSenha('confirmarSenha', this)" aria-label="Mostrar/ocultar senha">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            <button type="submit" class="btn-criar"><a href="./dashboard.php">Criar Conta</a></button>

            <p class="link-login">Já tem uma conta? <a href="./login.php">Faça login</a></p>
        </form>
    </div>

</body>
</html>
