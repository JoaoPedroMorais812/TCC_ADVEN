<?php
header('Content-Type: application/json; charset=utf-8');
try {
    include_once __DIR__ . '/db.php'; // cria $pdo

    // Parâmetros aceitos via querystring:
    // - natureza (default 'Credito')
    // - periodo (ex: '30d', '90d', '1y') OR start & end (YYYY-MM-DD)
    // - fonte (filtro de texto que aplica LIKE em reg_Nome)

    $natureza = isset($_GET['natureza']) ? trim($_GET['natureza']) : 'Credito';
    $periodo = isset($_GET['periodo']) ? trim($_GET['periodo']) : null;
    $start = isset($_GET['start']) ? trim($_GET['start']) : null;
    $end = isset($_GET['end']) ? trim($_GET['end']) : null;
    $fonte = isset($_GET['fonte']) ? trim($_GET['fonte']) : null;

    $where = [];
    $params = [];

    // Filtra pela natureza (categoria) — padrão 'Credito'
    $where[] = 'reg_idNatureza = :natureza';
    $params[':natureza'] = $natureza;

    // Data: se start & end fornecidos, usa BETWEEN
    if ($start && $end) {
        // Validação básica do formato YYYY-MM-DD
        $startDt = DateTime::createFromFormat('Y-m-d', $start);
        $endDt = DateTime::createFromFormat('Y-m-d', $end);
        if ($startDt && $endDt) {
            $where[] = 'reg_Data BETWEEN :start AND :end';
            $params[':start'] = $startDt->format('Y-m-d');
            $params[':end'] = $endDt->format('Y-m-d');
        }
    } elseif ($periodo && strtolower($periodo) !== 'all') {
        // Formato esperado: number + unit (d, m, y). Ex: 30d, 6m, 1y
        if (preg_match('/^(\d+)([dmy])$/i', $periodo, $matches)) {
            $n = (int)$matches[1];
            $unit = strtolower($matches[2]);
            $now = new DateTime();
            switch ($unit) {
                case 'd':
                    $intervalSpec = 'P' . $n . 'D';
                    break;
                case 'm':
                    $intervalSpec = 'P' . $n . 'M';
                    break;
                case 'y':
                    $intervalSpec = 'P' . $n . 'Y';
                    break;
                default:
                    $intervalSpec = null;
            }
            if ($intervalSpec) {
                $startDt = (new DateTime())->sub(new DateInterval($intervalSpec));
                $where[] = 'reg_Data >= :start';
                $params[':start'] = $startDt->format('Y-m-d');
            }
        }
    }

    // Fonte: aplica LIKE em reg_Nome quando fornecida
    if ($fonte !== null && $fonte !== '') {
        $where[] = 'reg_Nome LIKE :fonte';
        $params[':fonte'] = '%' . str_replace('%', '\\%', $fonte) . '%';
    }

    // Monta a query com proteção e limite para evitar retorno massivo
    $sql = 'SELECT id, reg_Nome, reg_Descricao, reg_Data, reg_Valor, reg_idNatureza, reg_idRecorrencia
            FROM tbl_registro';
    if (count($where) > 0) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }
    $sql .= ' ORDER BY reg_Data DESC, id DESC LIMIT 1000';

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $receitas = [];
    $total = 0.0;
    foreach ($rows as $r) {
        $valor = (float) $r['reg_Valor'];
        $total += $valor;
        $receitas[] = [
            'id' => isset($r['id']) ? $r['id'] : null,
            'data' => isset($r['reg_Data']) ? $r['reg_Data'] : null,
            'conta' => isset($r['reg_idNatureza']) && $r['reg_idNatureza'] !== '' ? $r['reg_idNatureza'] : 'Conta',
            'fonte' => isset($r['reg_Nome']) ? $r['reg_Nome'] : '',
            'valor' => $valor,
            'recorrencia' => isset($r['reg_idRecorrencia']) && $r['reg_idRecorrencia'] !== '' ? $r['reg_idRecorrencia'] : 'Sem recorrência',
            'observacoes' => isset($r['reg_Descricao']) ? $r['reg_Descricao'] : ''
        ];
    }

    // Monta métricas simples (pode ser melhorado depois)
    $metrics = [
        'totalReceitas' => $total,
        'totalDespesas' => 0.0,
        'saldo' => $total,
        'previsoes' => 0.0,
        'changeReceitas' => '0%',
        'changeDespesas' => '0%',
        'changeSaldo' => '0%'
    ];

    $result = [
        'success' => true,
        'metrics' => $metrics,
        'receitas' => $receitas,
        'agenda' => [],
        'notificacoes' => [],
        'proximasSaidas' => []
    ];

    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
