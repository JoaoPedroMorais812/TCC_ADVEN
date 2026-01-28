<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../../app/config/database.php';
session_start();

$db = new Database();
$pdo = $db->getConnection();

// valida método
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Método inválido. Use POST."]);
    exit;
}

// pega dados enviados via FormData
$nome        = $_POST["nome_descricao"] ?? null;
$valor       = $_POST["valor"] ?? null;
$data        = $_POST["data_vencimento"] ?? null;
$categoria   = $_POST["categoria"] ?? null;     // deve ser o ID da Natureza
$recorrencia = $_POST["recorrencia"] ?? null;   // deve ser o ID da Recorrência
$observacoes = $_POST["observacoes"] ?? null;

$idUsuario   = $_SESSION['user_id'] ?? null;
if (!$idUsuario) {
    echo json_encode(["success" => false, "message" => "Usuário não logado"]);
    exit;
}

// validação
if (empty($nome) || $valor === null || empty($data) || empty($categoria)) {
    echo json_encode(["success" => false, "message" => "Parâmetros inválidos."]);
    exit;
}

try {
    $sql = "INSERT INTO tbl_Registro 
            (reg_Nome, reg_Valor, reg_Data, reg_Descricao, reg_idNatureza, reg_idRecorrencia, reg_IdUsuario) 
            VALUES (:nome, :valor, :data, :descricao, :natureza, :recorrencia, :usuario)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":valor", $valor);
    $stmt->bindParam(":data", $data);
    $stmt->bindParam(":descricao", $observacoes);
    $stmt->bindParam(":natureza", $categoria, PDO::PARAM_INT);
    $stmt->bindParam(":recorrencia", $recorrencia, PDO::PARAM_INT);
    $stmt->bindParam(":usuario", $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Registro adicionado com sucesso."]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Erro interno", "details" => $e->getMessage()]);
}
