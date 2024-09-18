<?php
require_once 'RepositoryInterface.php';

class MiembroRepository implements RepositoryInterface {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene todos los miembros.
     * 
     * @return array Lista de miembros.
     */
    public function findAll() {
        $query = "SELECT * FROM Miembros";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un miembro por su ID.
     * 
     * @param int $id ID del miembro.
     * @return array|false Detalles del miembro o false si no se encuentra.
     */
    public function findById($id) {
        $query = "SELECT * FROM Miembros WHERE miembro_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Inserta un nuevo miembro en la base de datos.
     * 
     * @param MiembroDto $miembro Objeto DTO del miembro.
     * @return int|false ID del nuevo miembro o false si la inserción falla.
     */
    public function create($miembro) {
        $query = "INSERT INTO Miembros (nombre, apellido, email, telefono, club_id) VALUES (:nombre, :apellido, :email, :telefono, :club_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $miembro->nombre);
        $stmt->bindParam(':apellido', $miembro->apellido);
        $stmt->bindParam(':email', $miembro->email);
        $stmt->bindParam(':telefono', $miembro->telefono);
        $stmt->bindParam(':club_id', $miembro->club_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // Devuelve el ID del nuevo registro
        } else {
            return false; // Fallo en la inserción
        }
    }

    /**
     * Actualiza los datos de un miembro existente.
     * 
     * @param int $id ID del miembro a actualizar.
     * @param MiembroDto $miembro Objeto DTO con los nuevos datos del miembro.
     * @return bool Verdadero si la actualización fue exitosa, falso en caso contrario.
     */
    public function update($id, $miembro) {
        $query = "UPDATE Miembros SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, club_id = :club_id WHERE miembro_id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $miembro->nombre);
        $stmt->bindParam(':apellido', $miembro->apellido);
        $stmt->bindParam(':email', $miembro->email);
        $stmt->bindParam(':telefono', $miembro->telefono);
        $stmt->bindParam(':club_id', $miembro->club_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute(); // Devuelve true si se actualizó al menos una fila
    }

    /**
     * Elimina un miembro por su ID.
     * 
     * @param int $id ID del miembro a eliminar.
     * @return bool Verdadero si la eliminación fue exitosa, falso en caso contrario.
     */
    public function delete($id) {
        $query = "DELETE FROM Miembros WHERE miembro_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute(); // Devuelve true si se eliminó al menos una fila
    }
}
