<?php
require_once '../../app/config/database.php';

header("Content-Type: application/json");
session_start();

$id = $_POST['id'] ?? null;
$idUsuario = $_SESSION['user_id'] ?? null;

if (!$id || !$idUsuario) {
    echo json_encode(["success" => false, "message" => "ID inválido ou usuário não logado"]);
    exit;
}

$conn = (new Database())->getConnection();

try {
    $stmt = $conn->prepare("
        UPDATE tbl_Evento 
        SET eve_Concluido = 1 
        WHERE id_Evento = :id AND eve_IdUsuario = :usuario
    ");
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Compromisso concluído com sucesso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Evento não encontrado ou não pertence ao usuário"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
