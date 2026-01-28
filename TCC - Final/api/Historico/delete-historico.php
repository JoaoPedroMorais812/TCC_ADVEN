<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../../app/config/database.php';
session_start();

$db = new Database();
$pdo = $db->getConnection();

if (!isset($_POST['id'])) {
    echo json_encode(["status" => "error", "mensagem" => "ID não recebido."]);
    exit;
}

$id = intval($_POST['id']);
$idUsuario = $_SESSION['user_id'] ?? null;

if (!$idUsuario) {
    echo json_encode(["status" => "error", "mensagem" => "Usuário não logado"]);
    exit;
}

try {
    $sql = $pdo->prepare("
        DELETE FROM tbl_Registro 
        WHERE id_Registro = :id AND reg_IdUsuario = :usuario
    ");
    $sql->bindValue(":id", $id, PDO::PARAM_INT);
    $sql->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        echo json_encode(["status" => "success", "mensagem" => "Registro excluído com sucesso."]);
    } else {
        echo json_encode(["status" => "error", "mensagem" => "Registro não encontrado ou não pertence ao usuário."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "mensagem" => $e->getMessage()]);
}
