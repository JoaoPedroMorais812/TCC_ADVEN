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
  $dados = [];

  switch ($periodo) {
    case 'Diário':
      $sql = "
        SELECT HOUR(reg_Data) AS label,
               SUM(CASE WHEN reg_idNatureza = 1 THEN reg_Valor ELSE 0 END) AS creditos,
               SUM(CASE WHEN reg_idNatureza = 2 THEN reg_Valor ELSE 0 END) AS debitos
        FROM tbl_Registro
        WHERE DATE(reg_Data) = CURDATE()
          AND reg_IdUsuario = :usuario
        GROUP BY HOUR(reg_Data)
        ORDER BY HOUR(reg_Data)";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      for ($h = 0; $h < 24; $h++) {
        $found = array_filter($rows, fn($r) => $r['label'] == $h);
        $dados[] = $found ? array_values($found)[0] : ["label" => $h, "creditos" => 0, "debitos" => 0];
      }
      break;

    case 'Semanal':
      $sql = "
        SELECT DAYOFWEEK(reg_Data) AS label,
               SUM(CASE WHEN reg_idNatureza = 1 THEN reg_Valor ELSE 0 END) AS creditos,
               SUM(CASE WHEN reg_idNatureza = 2 THEN reg_Valor ELSE 0 END) AS debitos
        FROM tbl_Registro
        WHERE YEARWEEK(reg_Data, 1) = YEARWEEK(CURDATE(), 1)
          AND reg_IdUsuario = :usuario
        GROUP BY DAYOFWEEK(reg_Data)
        ORDER BY DAYOFWEEK(reg_Data)";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      for ($d = 1; $d <= 7; $d++) {
        $found = array_filter($rows, fn($r) => $r['label'] == $d);
        $dados[] = $found ? array_values($found)[0] : ["label" => $d, "creditos" => 0, "debitos" => 0];
      }
      break;

    case 'Mensal':
      $sql = "
        SELECT MONTH(reg_Data) AS label,
               SUM(CASE WHEN reg_idNatureza = 1 THEN reg_Valor ELSE 0 END) AS creditos,
               SUM(CASE WHEN reg_idNatureza = 2 THEN reg_Valor ELSE 0 END) AS debitos
        FROM tbl_Registro
        WHERE YEAR(reg_Data) = YEAR(CURDATE())
          AND reg_IdUsuario = :usuario
        GROUP BY MONTH(reg_Data)
        ORDER BY MONTH(reg_Data)";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      for ($m = 1; $m <= 12; $m++) {
        $found = array_filter($rows, fn($r) => $r['label'] == $m);
        $dados[] = $found ? array_values($found)[0] : ["label" => $m, "creditos" => 0, "debitos" => 0];
      }
      break;

    case 'Anual':
      $sql = "
        SELECT YEAR(reg_Data) AS label,
               SUM(CASE WHEN reg_idNatureza = 1 THEN reg_Valor ELSE 0 END) AS creditos,
               SUM(CASE WHEN reg_idNatureza = 2 THEN reg_Valor ELSE 0 END) AS debitos
        FROM tbl_Registro
        WHERE reg_IdUsuario = :usuario
        GROUP BY YEAR(reg_Data)
        ORDER BY YEAR(reg_Data)";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $anoAtual = (int)date("Y");
      $anoInicial = $anoAtual - 4; // últimos 5 anos

      for ($a = $anoInicial; $a <= $anoAtual; $a++) {
        $found = array_filter($rows, fn($r) => $r['label'] == $a);
        $dados[] = $found ? array_values($found)[0] : ["label" => $a, "creditos" => 0, "debitos" => 0];
      }
      break;

    default:
      $dados = [];
  }

  echo json_encode($dados);
} catch (PDOException $e) {
  echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
