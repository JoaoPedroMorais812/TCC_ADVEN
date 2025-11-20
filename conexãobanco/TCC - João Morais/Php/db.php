<?php
/**
 * Arquivo de conexão com o banco de dados (PDO)
 * Ajuste as variáveis abaixo conforme seu ambiente (XAMPP padrão: user=root, password="")
 */

// Configurações do banco
$DB_HOST = '127.0.0.1';
$DB_NAME = 'adven'; // <-- altere para o nome do seu banco
$DB_USER = 'root';
$DB_PASS = '';
$DB_CHARSET = 'utf8mb4';

$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=$DB_CHARSET";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    // Em produção, prefira registros de erro em vez de exibir a mensagem completa
    error_log('DB connection failed: ' . $e->getMessage());
    // Exibe mensagem genérica para o usuário
    die('Erro ao conectar ao banco de dados. Verifique as configurações.');
}

?>
