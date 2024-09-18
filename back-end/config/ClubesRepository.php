<?php
require_once 'RepositoryInterface.php';
class ClubesRepository implements RepositoryInterface {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findAll() {
        $query = "SELECT * FROM Clubes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM Clubes WHERE club_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($club) {
        $query = "INSERT INTO Clubes (nombre, deporte, ubicacion, fecha_fundacion) VALUES (:nombre, :deporte, :ubicacion, :fecha_fundacion)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nombre', $club->nombre);
        $stmt->bindParam(':deporte', $club->deporte);
        $stmt->bindParam(':ubicacion', $club->ubicacion);
        $stmt->bindParam(':fecha_fundacion', $club->fecha_fundacion);
        
        $stmt->execute();
    }

    public function update($id, $club) {
    $query = "UPDATE Clubes SET nombre = :nombre, deporte = :deporte, ubicacion = :ubicacion, fecha_fundacion = :fecha_fundacion WHERE club_id = :id";
    $stmt = $this->conn->prepare($query);

    // Mapeamos las propiedades del objeto ClubDto
    $stmt->bindParam(':nombre', $club->nombre);
    $stmt->bindParam(':deporte', $club->deporte);
    $stmt->bindParam(':ubicacion', $club->ubicacion);
    $stmt->bindParam(':fecha_fundacion', $club->fecha_fundacion);
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}

    public function delete($id) {
        $query = "DELETE FROM Clubes WHERE club_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
