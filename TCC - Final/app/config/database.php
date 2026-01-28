<?php
class Database {
    private $host = "br612.hostgator.com.br";
    private $db_name = "hubsap45_bd_tcc_2025_adven";   
    private $username = "hubsap45_tcc_2025_usradven";       
    private $password = "Od!nsEye!77";          
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        }catch (PDOException $exception) {
    die(json_encode([
        "success" => false,
        "message" => "Erro na conexão: " . $exception->getMessage()
    ]));
}
        return $this->conn;
    }
}
