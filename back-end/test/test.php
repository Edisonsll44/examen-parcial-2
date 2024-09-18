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

    // Obtenemos todos los clubes de la base de datos
    $clubes = $clubesRepository->findAll();

    // Convertimos cada club en un objeto ClubDto
    $clubDtos = [];
    foreach ($clubes as $club) {
        $clubDto = new ClubDto($club);
        $clubDtos[] = $clubDto;
    }

    // Mostramos los datos de los clubes como objetos ClubDto
    foreach ($clubDtos as $clubDto) {
        echo "Nombre: " . $clubDto->nombre . "\n";
        echo "Deporte: " . $clubDto->deporte . "\n";
        echo "Ubicación: " . $clubDto->ubicacion . "\n";
        echo "Fecha de Fundación: " . $clubDto->fecha_fundacion . "\n";
        echo "---------------------------\n";
    }

} catch (Exception $e) {
    echo "Error al obtener los clubes: " . $e->getMessage();
}
