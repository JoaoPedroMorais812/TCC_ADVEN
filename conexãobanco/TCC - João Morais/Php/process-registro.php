<?php

// -----------------------------------------------------------------------------
// Aceita apenas POST
// -----------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// -----------------------------------------------------------------------------
// Deve responder em JSON?
// -----------------------------------------------------------------------------
$isAjax =
    (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
    ||
    (isset($_SERVER['HTTP_ACCEPT']) &&
        strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

// -----------------------------------------------------------------------------
// Função utilitária de resposta
// -----------------------------------------------------------------------------
function respond($data, $isJson = true)
{
    if ($isJson) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    header('Location: /registros.php');
    exit;
}

// -----------------------------------------------------------------------------
// Recebe e sanitiza
// -----------------------------------------------------------------------------
$nome         = trim($_POST['nome_descricao'] ?? '');
$valorRaw     = trim($_POST['valor'] ?? '0');
$valor        = str_replace(',', '.', $valorRaw);
$data_venc    = $_POST['data_vencimento'] ?? null;
$categoria    = trim($_POST['categoria'] ?? '');
$recorrencia  = trim($_POST['recorrencia'] ?? '');
$observacoes  = trim($_POST['observacoes'] ?? '');

// -----------------------------------------------------------------------------
// ✔ Regras automáticas de IDs
//    (AGORA USANDO OS VALORES QUE O JS REALMENTE ENVIA)
// -----------------------------------------------------------------------------

// Categoria
switch (strtolower($categoria)) {
    case 'debito':
        $categoria = 1;  // ID correto na tbl_natureza
        break;

    case 'credito':
        $categoria = 2;
        break;

    default:
        $categoria = 3; // Outros
        break;
}

// Recorrência
switch (strtolower($recorrencia)) {
    case 'diario':
        $recorrencia = 6;   // ID 6 na tbl_recorrencia
        break;

    case 'semanal':
        $recorrencia = 2;
        break;

    case 'mensal':
        $recorrencia = 3;
        break;

    case 'anual':
        $recorrencia = 4;
        break;

    default:
        $recorrencia = 1; // Sem recorrência
        break;
}

// -----------------------------------------------------------------------------
// Validações
// -----------------------------------------------------------------------------
$errors = [];

if ($nome === '') {
    $errors[] = 'O campo Nome/Descrição é obrigatório.';
}

if (empty($data_venc)) {
    $errors[] = 'A data de publicação é obrigatória.';
}

if ($valor === '' || !is_numeric($valor)) {
    $errors[] = 'O valor informado é inválido.';
}

if (!empty($errors)) {
    respond(['success' => false, 'message' => implode(' ', $errors)], $isAjax);
}

// -----------------------------------------------------------------------------
// Inserção
// -----------------------------------------------------------------------------
try {
    include_once __DIR__ . '/db.php';

    $sql = "INSERT INTO tbl_registro 
           (reg_Nome, reg_Descricao, reg_Data, reg_Valor, reg_idNatureza, reg_idRecorrencia)
           VALUES
           (:nome, :descricao, :data, :valor, :natureza, :recorrencia)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':descricao', $observacoes);
    $stmt->bindValue(':data', $data_venc);
    $stmt->bindValue(':valor', $valor);
    $stmt->bindValue(':natureza', $categoria);
    $stmt->bindValue(':recorrencia', $recorrencia);

    $stmt->execute();

    respond([
        'success' => true,
        'message' => 'Registro adicionado com sucesso.'
    ], $isAjax);
} catch (Exception $e) {

    error_log('Erro ao inserir registro: ' . $e->getMessage());

    respond([
        'success' => false,
        'message' => 'Erro ao salvar registro. Verifique o log do servidor.'
    ], $isAjax);
}
