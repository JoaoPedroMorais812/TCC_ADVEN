<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  
  <link rel="stylesheet" href="css/style-login.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">

</head>
<body>

  <div class="container">
    <div class="login-box">
      <div class="header">
       <a class="link-limpo" href="index.php"> <span class="back-arrow">&#8592;</span></a>
        <h2>Entrar na sua conta</h2>
      </div>

      <?php
session_start();
if (isset($_SESSION['login_error'])) {
    echo '<div style="
        background-color:#ffe0e0;
        color:#b00020;
        border:1px solid #b00020;
        padding:12px;
        margin-bottom:15px;
        border-radius:6px;
        text-align:center;
        font-family:Arial, sans-serif;
    ">' . $_SESSION['login_error'] . '</div>';
    unset($_SESSION['login_error']); // limpa para não ficar aparecendo sempre
}
?>


      <form action="../api/login/achar_conta.php" method="POST">

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

        <button type="submit" class="btn">Entrar</button>
      </form>
      <p class="signup">Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
    </div>
  </div>


  <script src="js/script-login.js"></script>
</body>
</html>
