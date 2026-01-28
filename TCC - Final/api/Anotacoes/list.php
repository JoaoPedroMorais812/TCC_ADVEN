<?php
require_once '../../app/config/database.php';

header("Content-Type: application/json");
session_start(); // garante que a sessão está ativa

$conn = (new Database())->getConnection();

$idUsuario = $_SESSION['user_id'] ?? null;
if (!$idUsuario) {
    echo json_encode(["success" => false, "message" => "Usuário não logado"]);
    exit;
}

$stmt = $conn->prepare("
    SELECT 
        ano_Id              AS id,
        ano_Titulo          AS titulo,
        ano_Conteudo        AS conteudo,
        ano_Cor             AS cor,
        ano_Favorito        AS favorita,
        ano_Data            AS data_criacao,
        ano_IdUsuario       AS id_usuario,
        ano_DataAtualizacao AS data_edicao
    FROM tbl_Anotacao
    WHERE ano_IdUsuario = :usuario
    ORDER BY ano_Data DESC
");
$stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);
