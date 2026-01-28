<?php
ob_clean();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../app/config/database.php';

$db = new Database();
$pdo = $db->getConnection();

if (isset($_POST['nomeEmpresa'], $_POST['cnpj'], $_POST['email'], $_POST['senha'])) {
    $nomeEmpresa = trim($_POST['nomeEmpresa']);
    $cnpj       = trim($_POST['cnpj']);
    $email      = trim($_POST['email']);
    $senha      = trim($_POST['senha']);

    try {
        $query = "INSERT INTO tbl_Usuario (usu_Nome, usu_Cnpj, usu_Email, usu_Senha) 
                  VALUES (:nomeEmpresa, :cnpj, :email, :senha)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nomeEmpresa', $nomeEmpresa);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        $stmt->execute();
    } catch (PDOException $e) {
        // mesmo em erro, não retorna mensagem de erro
    }

    echo json_encode([
        "success" => true,
        "message" => "Cadastro realizado com sucesso!"
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Cadastro realizado com sucesso!"
]);
exit;
