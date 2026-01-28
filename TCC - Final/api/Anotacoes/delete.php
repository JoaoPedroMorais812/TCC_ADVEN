<?php
require_once '../../app/config/database.php';
header("Content-Type: application/json");
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['id'])) {
    echo json_encode(["success" => false, "message" => "ID inválido"]);
    exit;
}

$id = (int)$data['id'];
$idUsuario = $_SESSION['user_id'] ?? null;

if (!$idUsuario) {
    echo json_encode(["success" => false, "message" => "Usuário não logado"]);
    exit;
}

$conn = (new Database())->getConnection();

try {
    $stmt = $conn->prepare("
        DELETE FROM tbl_Anotacao 
        WHERE ano_Id = :id AND ano_IdUsuario = :usuario
    ");
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Anotação excluída com sucesso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Anotação não encontrada ou não pertence ao usuário"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
