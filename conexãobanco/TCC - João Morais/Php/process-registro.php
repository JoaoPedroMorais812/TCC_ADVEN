<?php
/**
 * process-registro.php
 * Recebe POST do formulário de registros e grava na tabela `registros`.
 * Retorna JSON quando a requisição for AJAX/Accept: application/json, senão redireciona de volta.
 */

// Detecta requisição
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Determina se a resposta deve ser JSON
$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
    || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

// Função utilitária para resposta
function respond($data, $isJson = true)
{
    if ($isJson) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    // fallback: redireciona para página anterior
    $redirect = '/registros.php';
    if (!empty($data['success'])) {
        header('Location: ' . $redirect . '?success=1');
    } else {
        $msg = urlencode($data['message'] ?? 'Erro');
        header('Location: ' . $redirect . '?error=' . $msg);
    }
    exit;
}

// Recebe e sanitiza dados
$nome = trim($_POST['nome_descricao'] ?? '');
$valorRaw = trim($_POST['valor'] ?? '0');
$valor = str_replace(',', '.', $valorRaw);
$data_venc = $_POST['data_vencimento'] ?? null;
$categoria = trim($_POST['categoria'] ?? '');
$recorrencia = trim($_POST['recorrencia'] ?? '');
$observacoes = trim($_POST['observacoes'] ?? '');

// Validações básicas
$errors = [];
if ($nome === '') {
    $errors[] = 'O campo Nome/Descrição é obrigatório.';
}
if ($data_venc === '' || $data_venc === null) {
    $errors[] = 'A data de publicação é obrigatória.';
}
if ($valor === '' || !is_numeric($valor)) {
    $errors[] = 'O valor informado é inválido.';
}

if (!empty($errors)) {
    respond(['success' => false, 'message' => implode(' ', $errors)], $isAjax);
}

// Insere no banco usando PDO
try {
    include_once __DIR__ . '/db.php'; // cria $pdo

    $sql = "INSERT INTO tbl_registro (reg_Nome, reg_Descricao, reg_Data, reg_Valor, reg_idNatureza, reg_idRecorrencia)
            VALUES (:nome, :descricao, :data, :valor, :natureza, :recorrencia)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':descricao', $observacoes, PDO::PARAM_STR);
    $stmt->bindValue(':data', $data_venc, PDO::PARAM_STR);
    $stmt->bindValue(':valor', (float)$valor, PDO::PARAM_STR);
    $stmt->bindValue(':natureza', $categoria, PDO::PARAM_STR);
    $stmt->bindValue(':recorrencia', $recorrencia, PDO::PARAM_STR);

    $stmt->execute();

    // Último id inserido
    $lastId = $pdo->lastInsertId();

    // determina se estamos em modo debug via variável de ambiente APP_DEBUG
    $appDebug = getenv('APP_DEBUG') === '1';

    $response = ['success' => true, 'message' => 'Registro adicionado com sucesso.', 'id' => $lastId];

    // se quisermos, em modo debug retornamos também o registro recém-inserido
    if ($appDebug) {
        try {
            $sel = $pdo->prepare('SELECT * FROM tbl_registro WHERE id = :id');
            $sel->bindValue(':id', $lastId, PDO::PARAM_INT);
            $sel->execute();
            $response['record'] = $sel->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $inner) {
            // não falha a resposta principal se o select falhar
            error_log('process-registro fetch error: ' . $inner->getMessage());
        }
    }

    respond($response, $isAjax);

} catch (Exception $e) {
    // Registra o erro no log do servidor
    error_log('process-registro error: ' . $e->getMessage());

    // Só inclui detalhes de exceção quando APP_DEBUG=1 no ambiente
    $appDebug = getenv('APP_DEBUG') === '1';
    $resp = ['success' => false, 'message' => 'Erro ao salvar registro. Verifique o log do servidor.'];
    if ($appDebug) {
        $resp['error'] = $e->getMessage();
        $resp['trace'] = $e->getTraceAsString();
    }
    respond($resp, $isAjax);
}
