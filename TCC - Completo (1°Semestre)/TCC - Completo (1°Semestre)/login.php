<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  
  <link rel="stylesheet" href="css/styles-login.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">

</head>
<body>
  <header class="navbar">
    <div class="navbar-container">
      <div class="logo">ADVEN</div>
      <nav class="nav-links">
        <a href="./index.php" class="active"><i class="bi bi-house-door"></i> Home</a>
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
    <div class="login-box">
      <div class="header">
        <span class="back-arrow">  <a href="./index.php"> &#8592; </a></span> 
        <h2>Entrar na sua conta</h2>
      </div>
      <form action="login.php" method="POST">
        <label for="email"><i class="bi bi-envelope"></i> Email</label>
        <div class="input-group">
          <input type="email" name="email" id="email" placeholder="seu@email.com" required>
        </div>

        <label for="senha"><i class="bi bi-lock"></i> Senha</label>
        <div class="input-group">
          <input type="password" name="senha" id="senha" placeholder="Sua senha" required>
          <span class="icon eye" onclick="togglePassword()">
            <i class="bi bi-eye"></i>
          </span>
        </div>

        <div class="forgot">
          <a href="#">Esqueceu sua senha?</a>
        </div>

        <button type="submit" class="btn"><a href="./dashboard.php"> Entrar </a></button>
      </form>
      <p class="signup">Não tem uma conta? <a href="./cadastro.php">Cadastre-se</a></p>
    </div>
  </div>

  <script src="css/styles-login.css"></script>
</body>
</html>
