<?php
require_once 'RepositoryInterface.php';
class MiembrosRepository implements RepositoryInterface {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findAll() {
        $query = "SELECT * FROM Miembros";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM Miembros WHERE miembro_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($miembro) {
        $query = "INSERT INTO Miembros (nombre, apellido, email, telefono, club_id) VALUES (:nombre, :apellido, :email, :telefono, :club_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $miembro->nombre);
        $stmt->bindParam(':apellido', $miembro->apellido);
        $stmt->bindParam(':email', $miembro->email);
        $stmt->bindParam(':telefono', $miembro->telefono);
        $stmt->bindParam(':club_id', $miembro->club_id);
        
        $stmt->execute();
    }

    public function update($id, $miembro) {
        $query = "UPDATE Miembros SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, club_id = :club_id WHERE miembro_id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $miembro->nombre);
        $stmt->bindParam(':apellido', $miembro->apellido);
        $stmt->bindParam(':email', $miembro->email);
        $stmt->bindParam(':telefono', $miembro->telefono);
        $stmt->bindParam(':club_id', $miembro->club_id); // Incluir club_id en la actualización
        $stmt->bindParam(':id', $miembro->miembro_id);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM Miembros WHERE miembro_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
