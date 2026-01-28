<?php
require_once __DIR__ . '/../../app/config/database.php';
session_start();

header("Content-Type: application/json");

try {
    $conn = (new Database())->getConnection();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Conexão falhou: " . $e->getMessage()]);
    exit;
}

// Validação básica
$titulo     = $_POST['titulo']    ?? null;
$dataEvento = $_POST['data']      ?? null;
$horario    = $_POST['horario']   ?? null;
$tipo       = $_POST['tipo']      ?? null;
$descricao  = $_POST['descricao'] ?? '';

if (!$titulo || !$dataEvento || !$horario || !$tipo) {
    echo json_encode(["success" => false, "message" => "Dados incompletos"]);
    exit;
}

// Pega o usuário da sessão
$idUsuario = $_SESSION['user_id'] ?? null;
if (!$idUsuario) {
    echo json_encode(["success" => false, "message" => "Usuário não logado"]);
    exit;
}

try {
    $stmt = $conn->prepare("
        INSERT INTO tbl_Evento 
        (eve_Titulo, eve_Descricao, eve_Data, eve_Horario, eve_Tipo, eve_IdUsuario, eve_Concluido)
        VALUES (:titulo, :descricao, :data, :horario, :tipo, :usuario, 0)
    ");

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':data', $dataEvento);
    $stmt->bindParam(':horario', $horario);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':usuario', $idUsuario, PDO::PARAM_INT);

    $stmt->execute();

    $id = $conn->lastInsertId();
    if ($id && $id !== "0") {
        echo json_encode(["success" => true, "id" => (int)$id, "message" => "Compromisso criado"]);
    } else {
        echo json_encode(["success" => false, "message" => "Insert não confirmou (sem ID)"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
