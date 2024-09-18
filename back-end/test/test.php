<?php
// Incluir la clase Database
require_once '../config/Database.php';

// Instanciar la clase Database
$database = new Database();

// Obtener la conexión
$conn = $database->getConnection();

// Verificar si la conexión fue exitosa
if($conn) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "No se pudo conectar a la base de datos.";
}
