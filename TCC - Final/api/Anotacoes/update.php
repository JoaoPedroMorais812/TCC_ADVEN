<?php
require_once '../../app/config/database.php';
header("Content-Type: application/json");
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['id'])) {
    echo json_encode(["success" => false, "message" => "ID inválido"]);
    exit;
}

$id        = (int)$data['id'];
$title     = $data['title'] ?? null;
$content   = $data['content'] ?? null;
$color     = $data['color'] ?? null;
$favorita  = !empty($data['favorita']) ? 1 : 0;

$idUsuario = $_SESSION['user_id'] ?? null;
if (!$idUsuario) {
    echo json_encode(["success" => false, "message" => "Usuário não logado"]);
    exit;
}

$conn = (new Database())->getConnection();

try {
    $stmt = $conn->prepare("
        UPDATE tbl_Anotacao
        SET ano_Titulo = :titulo, 
            ano_Conteudo = :conteudo, 
            ano_Cor = :cor, 
            ano_Favorito = :favorita, 
            ano_DataAtualizacao = NOW()
        WHERE ano_Id = :id AND ano_IdUsuario = :usuario
    ");
    $stmt->bindValue(":titulo", $title);
    $stmt->bindValue(":conteudo", $content);
    $stmt->bindValue(":cor", $color);
    $stmt->bindValue(":favorita", $favorita, PDO::PARAM_INT);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Anotação atualizada com sucesso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Anotação não encontrada ou não pertence ao usuário"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
