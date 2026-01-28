<?php
require_once __DIR__ . '/../../app/config/database.php';
session_start();

// Verifica usuário logado
$idUsuario = $_SESSION['user_id'] ?? null;
if (!$idUsuario) {
    echo "Usuário não logado";
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();

$sql = $pdo->prepare("
        SELECT 
            r.id_Registro AS id,
            r.reg_Data AS data,
            r.reg_Nome AS conta,
            r.reg_Valor AS valor,
            n.nat_Titulo AS fonte,
            rc.rec_Titulo AS recorrencia
        FROM tbl_Registro r
        LEFT JOIN tbl_Natureza n ON n.id_Natureza = r.reg_idNatureza
        LEFT JOIN tbl_Recorrencia rc ON rc.id_Recorrencia = r.reg_idRecorrencia
        WHERE r.reg_IdUsuario = :usuario
        ORDER BY r.reg_Data DESC
");

    $sql->bindValue(":usuario", $idUsuario, PDO::PARAM_INT);
    $sql->execute();
    $dados = $sql->fetchAll(PDO::FETCH_ASSOC);

    // Montar o conteúdo TXT
    $conteudo = "===== RELATÓRIO DE RECEITAS ADVEN =====\n";
    $conteudo .= "Gerado em: " . date("d/m/Y H:i") . "\n\n";

    $total = 0;

    foreach ($dados as $d) {
        $conteudo .= "ID: {$d['id']}\n";
        $conteudo .= "Data: {$d['data']}\n";
        $conteudo .= "Conta: {$d['conta']}\n";
        $conteudo .= "Fonte: " . ($d["fonte"] ?? "-") . "\n";
        $conteudo .= "Valor: R$ " . number_format($d["valor"], 2, ',', '.') . "\n";
        $conteudo .= "Recorrência: " . ($d["recorrencia"] ?? "-") . "\n";
        $conteudo .= "---------------------------------------\n";

        $total += floatval($d["valor"]);
    }

    $conteudo .= "\nTOTAL GERAL: R$ " . number_format($total, 2, ',', '.') . "\n";
    $conteudo .= "=========================================\n";

    // Fazer download
    header("Content-Type: text/plain; charset=utf-8");
    header("Content-Disposition: attachment; filename=relatorio_receitas.txt");
    echo $conteudo;
    exit;

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
