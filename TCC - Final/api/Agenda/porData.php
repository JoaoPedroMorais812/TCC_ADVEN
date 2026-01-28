<?php
require_once '../../app/config/database.php';
header("Content-Type: application/json");
session_start();

$conn = (new Database())->getConnection();
$data = $_POST['data'] ?? null;
$idUsuario = $_SESSION['user_id'] ?? null;

if (!$data || !$idUsuario) {
  echo json_encode([]);
  exit;
}

$stmt = $conn->prepare("
    SELECT eve_Titulo, eve_Descricao, eve_Horario 
    FROM tbl_Evento 
    WHERE eve_Data = :data 
      AND eve_IdUsuario = :usuario
");
$stmt->bindValue(":data", $data);
$stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
$stmt->execute();

$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($eventos);
