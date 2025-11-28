<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "db.php"; // conexão com o banco

$response = [
    "receitas" => [],
    "agenda" => [],
    "notificacoes" => [],
    "proximasSaidas" => []
];

// ------------------------------
// 1) RECEBENDO PARÂMETROS
// ------------------------------
$periodo = $_GET['periodo'] ?? 'Todas as despesas';
$fonte = $_GET['fonte'] ?? 'Todas as fontes';
$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;

// ------------------------------
// 2) BASE DA QUERY
// ------------------------------
$query = "SELECT id, data, conta, fonte, valor, recorrencia FROM tbl_notas WHERE 1=1";
$params = [];
$types = "";

// ------------------------------
// 3) FILTRO POR FONTE
// ------------------------------
if (!empty($fonte) && $fonte !== "Todas as fontes") {
    $query .= " AND fonte = ?";
    $params[] = $fonte;
    $types .= "s";
}

// ------------------------------
// 4) FILTRO POR PERÍODO PADRÃO
// ------------------------------
switch ($periodo) {
    case "Últimos 7 dias":
        $query .= " AND data >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        break;
    case "Últimos 30 dias":
        $query .= " AND data >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
        break;
    case "Últimos 6 meses":
        $query .= " AND data >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)";
        break;
    case "Último ano":
        $query .= " AND data >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
        break;
    default:
        // Todas as despesas → sem filtro
        break;
}

// ------------------------------
// 5) FILTRO POR INTERVALO (start/end)
// ------------------------------
if (!empty($start)) {
    $query .= " AND data >= ?";
    $params[] = $start;
    $types .= "s";
}

if (!empty($end)) {
    $query .= " AND data <= ?";
    $params[] = $end;
    $types .= "s";
}

// ------------------------------
// 6) ORDENAR
// ------------------------------
$query .= " ORDER BY data DESC";

// ------------------------------
// 7) EXECUTAR QUERY
// ------------------------------
$stmt = $conn->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// ------------------------------
// 8) MONTA RECEITAS
// ------------------------------
while ($row = $result->fetch_assoc()) {
    $response["receitas"][] = [
        "id"          => $row["id"],
        "data"        => $row["data"],
        "conta"       => $row["conta"],
        "fonte"       => $row["fonte"],
        "valor"       => floatval($row["valor"]),
        "recorrencia" => $row["recorrencia"]
    ];
}

// ---------------------------------------
// 9) MOCKS – Agenda / Notificações / Saídas
// ---------------------------------------
$response["agenda"] = [
    ["titulo" => "Recebimento: Cliente X", "data" => "2025-08-21"],
    ["titulo" => "Pagamento Programado", "data" => "2025-08-28"]
];

$response["notificacoes"] = [
    ["titulo" => "Depósito recebido", "mensagem" => "Um pagamento foi confirmado."],
    ["titulo" => "Alerta", "mensagem" => "Receita recorrente vence amanhã."]
];

$response["proximasSaidas"] = [
    ["titulo" => "Pagamento aluguel", "data" => "2025-09-05", "valor" => 850],
    ["titulo" => "Internet", "data" => "2025-09-10", "valor" => 140]
];

// ------------------------------
// 10) RETORNAR JSON
// ------------------------------
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;
