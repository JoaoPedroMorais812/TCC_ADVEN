<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../../app/config/database.php';
session_start();

$db = new Database();
$pdo = $db->getConnection();

$id         = $_POST["id"] ?? null;
$nome       = $_POST["nome"] ?? "";
$valor      = $_POST["valor"] ?? "0.00";
$data       = $_POST["data"] ?? "";
$descricao  = $_POST["descricao"] ?? "";
$natureza   = $_POST["natureza"] ?? null;
$recorrencia= $_POST["recorrencia"] ?? null;

$idUsuario = $_SESSION['user_id'] ?? null;
if (!$id || !$idUsuario) {
    echo json_encode(["status" => "error", "mensagem" => "ID não enviado ou usuário não logado."]);
    exit;
}

try {
    $sql = $pdo->prepare("
        UPDATE tbl_Registro 
        SET 
            reg_Nome = :nome,
            reg_Descricao = :descricao,
            reg_Data = :data,
            reg_Valor = :valor,
            reg_idNatureza = :natureza,
            reg_idRecorrencia = :recorrencia
        WHERE id_Registro = :id AND reg_IdUsuario = :usuario
    ");

    $sql->bindValue(":id", $id, PDO::PARAM_INT);
    $sql->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":descricao", $descricao);
    $sql->bindValue(":data", $data);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":natureza", $natureza, PDO::PARAM_INT);
    $sql->bindValue(":recorrencia", $recorrencia, PDO::PARAM_INT);

    $sql->execute();

    if ($sql->rowCount() > 0) {
        echo json_encode(["status" => "success", "mensagem" => "Registro atualizado com sucesso."]);
    } else {
        echo json_encode(["status" => "error", "mensagem" => "Registro não encontrado ou não pertence ao usuário."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "mensagem" => $e->getMessage()]);
}
