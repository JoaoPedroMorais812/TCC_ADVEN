<?php
require_once '../../app/config/database.php';
header("Content-Type: application/json");
session_start();

$conn = (new Database())->getConnection();

$periodo = $_GET['periodo'] ?? 'Mensal';

$idUsuario = $_SESSION['user_id'] ?? null;
if (!$idUsuario) {
  echo json_encode(["success" => false, "message" => "Usuário não logado"]);
  exit;
}

try {
  // Definir filtros para período atual e anterior
  switch ($periodo) {
    case 'Diário':
      $whereAtual = "DATE(reg_Data) = CURDATE()";
      $whereAnterior = "DATE(reg_Data) = CURDATE() - INTERVAL 1 DAY";
      break;
    case 'Semanal':
      $whereAtual = "YEARWEEK(reg_Data, 1) = YEARWEEK(CURDATE(), 1)";
      $whereAnterior = "YEARWEEK(reg_Data, 1) = YEARWEEK(CURDATE(), 1) - 1";
      break;
    case 'Mensal':
      $whereAtual = "MONTH(reg_Data) = MONTH(CURDATE()) AND YEAR(reg_Data) = YEAR(CURDATE())";
      $whereAnterior = "MONTH(reg_Data) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(reg_Data) = YEAR(CURDATE() - INTERVAL 1 MONTH)";
      break;
    case 'Anual':
      $whereAtual = "YEAR(reg_Data) = YEAR(CURDATE())";
      $whereAnterior = "YEAR(reg_Data) = YEAR(CURDATE()) - 1";
      break;
    default:
      $whereAtual = "1=1";
      $whereAnterior = "1=0";
  }

  // Totais do período atual
  $stmtAtual = $conn->prepare("
    SELECT 
      SUM(CASE WHEN reg_idNatureza = 1 THEN reg_Valor ELSE 0 END) AS creditos,
      SUM(CASE WHEN reg_idNatureza = 2 THEN reg_Valor ELSE 0 END) AS debitos
    FROM tbl_Registro
    WHERE $whereAtual AND reg_IdUsuario = :usuario
  ");
  $stmtAtual->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
  $stmtAtual->execute();
  $atual = $stmtAtual->fetch(PDO::FETCH_ASSOC);

  // Totais do período anterior
  $stmtAnterior = $conn->prepare("
    SELECT 
      SUM(CASE WHEN reg_idNatureza = 1 THEN reg_Valor ELSE 0 END) AS creditos,
      SUM(CASE WHEN reg_idNatureza = 2 THEN reg_Valor ELSE 0 END) AS debitos
    FROM tbl_Registro
    WHERE $whereAnterior AND reg_IdUsuario = :usuario
  ");
  $stmtAnterior->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
  $stmtAnterior->execute();
  $anterior = $stmtAnterior->fetch(PDO::FETCH_ASSOC);

  // Saldo
  $saldoAtual = ($atual['creditos'] ?: 0) - ($atual['debitos'] ?: 0);
  $saldoAnterior = ($anterior['creditos'] ?: 0) - ($anterior['debitos'] ?: 0);

  // Função para calcular variação %
  function variacao($atual, $anterior) {
    if ($anterior == 0) {
      return $atual > 0 ? 100 : 0;
    }
    return (($atual - $anterior) / $anterior) * 100;
  }

  echo json_encode([
    "creditos" => $atual['creditos'] ?: 0,
    "debitos" => $atual['debitos'] ?: 0,
    "saldo" => $saldoAtual,
    "variacaoCreditos" => variacao($atual['creditos'], $anterior['creditos']),
    "variacaoDebitos" => variacao($atual['debitos'], $anterior['debitos']),
    "variacaoSaldo" => variacao($saldoAtual, $saldoAnterior)
  ]);
} catch (PDOException $e) {
  echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
