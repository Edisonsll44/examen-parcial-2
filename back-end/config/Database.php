<?php
class Database {
    private $host = "localhost";
    private $db_name = "sistema_clubes";
    private $username = "root"; 
    private $password = "root";
    private $port = "3307"; 
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Aquí se especifica el puerto 3307
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
