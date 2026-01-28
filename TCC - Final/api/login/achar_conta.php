<?php
session_start();
require_once __DIR__ . '/../../app/config/database.php';

// cria a conexão com o banco
$db = new Database();
$pdo = $db->getConnection();

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  // tabela correta: tbl_Usuario
  $sql = "SELECT * FROM tbl_Usuario WHERE usu_Email = :email LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":email", $email);
  $stmt->execute();

  if ($stmt->rowCount() === 1) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Como você está usando senha em texto puro:
    if ($senha === $row['usu_Senha']) {

      // salva a sessão
      $_SESSION["loggedin"]   = true;
      $_SESSION["user_id"]    = $row["id_Usuario"];   // id do usuário
      $_SESSION["user_email"] = $row["usu_Email"];    // email
      $_SESSION["user_name"]  = $row["usu_Nome"];     // nome

      header("Location: ../../public/dashboard.php");
      exit;
    } else {
      if ($senha !== $row['usu_Senha']) {
    $_SESSION['login_error'] = "⚠️ Email ou senha incorretos. Verifique e tente novamente.";
    header("Location: ../../public/login.php");
    exit;
}
    }
  } else {
    $error = "Email ou senha incorretos";
  }
}
?>
