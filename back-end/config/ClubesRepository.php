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

        // Ejecutar la consulta y verificar si la inserción fue exitosa
        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // Devuelve el ID del nuevo registro
        } else {
            return false; // Fallo en la inserción
        }
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

        // Ejecutar la consulta y verificar si la actualización fue exitosa
        return $stmt->execute(); // Devuelve true si se actualizó al menos una fila
    }

    public function delete($id) {
        $query = "DELETE FROM Clubes WHERE club_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        // Ejecutar la consulta y verificar si la eliminación fue exitosa
        return $stmt->execute(); // Devuelve true si se eliminó al menos una fila
    }
}
