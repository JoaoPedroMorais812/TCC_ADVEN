<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../../app/config/database.php';
session_start();

try {
    // Instancia a classe Database e obtém a conexão
    $db = new Database();
    $pdo = $db->getConnection();

    $idUsuario = $_SESSION['user_id'] ?? null;
    if (!$idUsuario) {
        echo json_encode([
            "status"    => "error",
            "mensagem"  => "Usuário não logado"
        ]);
        exit;
    }

    $sql = $pdo->prepare("
        SELECT 
            r.id_Registro       AS id,
            r.reg_Data          AS data,
            r.reg_Nome          AS conta,
            r.reg_Valor         AS valor,
            r.reg_Descricao     AS descricao,
            r.reg_idNatureza    AS idNatureza,
            r.reg_idRecorrencia AS idRecorrencia,
            nat.nat_Titulo      AS natureza,
            rec.rec_Titulo      AS recorrencia
        FROM tbl_Registro r
        LEFT JOIN tbl_Natureza   nat ON nat.id_Natureza   = r.reg_idNatureza
        LEFT JOIN tbl_Recorrencia rec ON rec.id_Recorrencia = r.reg_idRecorrencia
        WHERE r.reg_IdUsuario = :usuario
        ORDER BY r.reg_Data DESC
    ");

    $sql->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
    $sql->execute();
    $dados = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "dados"  => $dados
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status"    => "error",
        "mensagem"  => $e->getMessage()
    ]);
}
