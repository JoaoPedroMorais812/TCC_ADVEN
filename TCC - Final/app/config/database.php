<?php
class Database {
    private $host = "localhost";
    private $db_name = "ADVEN";   
    private $username = "root";       
    private $password = " ";          
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
