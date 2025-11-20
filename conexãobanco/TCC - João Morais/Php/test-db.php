<?php
/**
 * Teste rápido de conexão com o banco de dados.
 * Coloque este arquivo na mesma pasta de `db.php` e acesse pelo navegador ou execute via PHP CLI.
 */
header('Content-Type: application/json; charset=utf-8');

try {
    // inclui a conexão (assume que db.php está na mesma pasta)
    include_once __DIR__ . '/db.php'; // cria $pdo

    // consulta simples para verificar a conexão
    $stmt = $pdo->query('SELECT 1 AS ok, NOW() AS server_time');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'message' => 'Conexão com o banco estabelecida com sucesso.',
        'result' => $row
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    // Em caso de erro, retorne 500 e detalhe mínimo (em dev pode mostrar mais)
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Falha ao conectar ao banco de dados.',
        'error' => $e->getMessage()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
