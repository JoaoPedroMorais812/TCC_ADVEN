<!-- <?php
      // include_once('conexao.php');

      // $fotoPerfil = $_POST['fotoPerfil'];
      // $nomeEmpresa = $_POST['nomeEmpresa'];
      // $cnpj = $_POST['cnpj'];
      // $email = $_POST['email'];
      // $senha = $_POST['senha'];

      // $result = mysqli_query($conn, "INSERT INTO tbl_usuario(usu_Foto, usu_Nome, usu_Cnpj, usu_Email, usu_Senha)
      // VALUES('$fotoPerfil', '$nomeEmpresa', '$cnpj', '$email', '$senha')" );

      ?> -->

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cadastro</title>

  <link rel="stylesheet" href="css/style-cadastro.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="shortcut icon" href="./image/Logo.jpeg" type="image/x-icon">

</head>

<body>
  <div class="container">
    <form class="form-criar-conta"
      method="POST"
      action="../api/login/criar_conta.php"
      enctype="multipart/form-data">


      <h2>Criar nova conta</h2>

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


      <button type="submit" class="btn-criar">Criar Conta</button>

      <div id="mensagem" class="mensagem"></div>

      <p class="link-login">Já tem uma conta? <a href="login.php">Faça login</a></p>
    </form>
  </div>

  <script src="js/script-cadastro.js"></script>
</body>

</html>