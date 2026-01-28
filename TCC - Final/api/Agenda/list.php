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
    // só traz compromissos não concluídos do usuário logado
    $stmt = $conn->prepare("
        SELECT 
            id_Evento AS id, 
            eve_Titulo AS titulo, 
            eve_Descricao AS descricao, 
            eve_Data AS data, 
            eve_Horario AS horario, 
            eve_Tipo AS tipo 
        FROM tbl_Evento 
        WHERE eve_Concluido = 0 
          AND eve_IdUsuario = :usuario
        ORDER BY eve_Data ASC
    ");
    $stmt->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($eventos);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
