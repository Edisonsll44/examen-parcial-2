<?php
// Incluimos los archivos necesarios
require_once '../config/Database.php';
require_once '../config/ClubesRepository.php';
require_once '../dto/ClubDto.php';

try {
    // Establecemos la conexión con la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Creamos una instancia del repositorio
    $clubesRepository = new ClubesRepository($db);

    // Simulamos los datos actualizados para un club
    $clubIdToUpdate = 11; // Cambia este ID según el club que deseas actualizar

    $updatedData = [
        'nombre' => 'Club Atlético Quito',
        'deporte' => 'Fútbol',
        'ubicacion' => 'Quito, Ecuador',
        'fecha_fundacion' => '1950-05-20'
    ];

    // Creamos un objeto DTO para el club con los datos actualizados
    $clubDto = new ClubDto($updatedData);
    
    // Llamamos al método update del repositorio para actualizar el club
    $clubesRepository->update($clubIdToUpdate, $clubDto);

    echo "Club actualizado exitosamente.\n";
} catch (Exception $e) {
    echo "Error al actualizar el club: " . $e->getMessage();
}
