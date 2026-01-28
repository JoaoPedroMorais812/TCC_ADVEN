<?php
require_once '../../app/config/database.php';

header("Content-Type: application/json");
session_start(); // garante que a sessão está ativa

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['title']) || empty($data['content'])) {
    echo json_encode(["success" => false, "message" => "Dados inválidos"]);
    exit;
}

$title    = $data['title'];
$content  = $data['content'];
$color    = $data['color'] ?? "amarelo";
$favorite = !empty($data['favorite']) ? 1 : 0;

$db   = new Database();
$conn = $db->getConnection();

try {
    // pega o id do usuário logado
    $idUsuario = $_SESSION['user_id'] ?? null;
    if (!$idUsuario) {
        echo json_encode(["success" => false, "message" => "Usuário não logado"]);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO tbl_Anotacao 
        (ano_Titulo, ano_Data, ano_Conteudo, ano_Cor, ano_Favorito, ano_IdUsuario)
        VALUES (:titulo, NOW(), :conteudo, :cor, :favorito, :usuario)
    ");
    $stmt->bindValue(":titulo", $title);
    $stmt->bindValue(":conteudo", $content);
    $stmt->bindValue(":cor", $color);
    $stmt->bindValue(":favorito", $favorite, PDO::PARAM_INT);
    $stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);

    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Anotação criada com sucesso"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
