<?php
require_once '../../app/config/database.php';
header("Content-Type: application/json");
session_start();

$conn = (new Database())->getConnection();

$idUsuario = $_SESSION['user_id'] ?? null;
if (!$idUsuario) {
  echo json_encode(["success" => false, "message" => "Usuário não logado"]);
  exit;
}

try {
  $stmt = $conn->prepare("
    SELECT 
      reg_Nome AS descricao, 
      reg_Valor AS valor, 
      reg_Data AS data,
      CASE WHEN reg_idNatureza = 1 THEN 'Receita' ELSE 'Despesa' END AS tipo
    FROM tbl_Registro
    WHERE reg_IdUsuario = :usuario
    ORDER BY reg_Data DESC
    LIMIT 10
  ");
  $stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
  $stmt->execute();

  $historico = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($historico);
} catch (PDOException $e) {
  echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
