<?php
// Configuración de headers para CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

// Incluir los archivos necesarios
require_once '../config/ClubesRepository.php';
require_once '../dto/ClubDto.php';
require_once '../config/database.php'; 

$database = new Database();
$db = $database->getConnection();

$clubesRepository = new ClubesRepository($db);

switch ($_GET["op"]) {
    case 'todos':
        $clubes = $clubesRepository->findAll(); 
        $clubDtos = array_map(function($club) {
            return new ClubDto($club); 
        }, $clubes);
        echo json_encode($clubDtos); 
        break;

    case 'uno':
        $idClub = $_POST["id"];
        $club = $clubesRepository->findById($idClub); 
        if ($club) {
            $clubDto = new ClubDto($club); 
            echo json_encode($clubDto); 
        } else {
            echo json_encode(["error" => "Club no encontrado"]);
        }
        break;

    case 'insertar':
        
        $data = [
            'nombre' => $_POST["nombre"],
            'deporte' => $_POST["deporte"],
            'ubicacion' => $_POST["ubicacion"],
            'fecha_fundacion' => $_POST["fecha_fundacion"]
        ];

        // Crear un objeto ClubDto con los datos recibidos
        $clubDto = new ClubDto($data);

        // Insertar el club en la base de datos
        $resultado = $clubesRepository->create($clubDto);

        if ($resultado) {
            echo json_encode(["message" => "Club insertado correctamente"]);
        } else {
            echo json_encode(["error" => "No se pudo insertar el club"]);
        }
        break;

    case 'actualizar':
        $idClub = $_POST["id"];
        // Crear un array con los nuevos datos del club
        $data = [
            'nombre' => $_POST["nombre"],
            'deporte' => $_POST["deporte"],
            'ubicacion' => $_POST["ubicacion"],
            'fecha_fundacion' => $_POST["fecha_fundacion"]
        ];

        // Crear un objeto ClubDto con los datos
        $clubDto = new ClubDto($data);

        // Actualizar el club en la base de datos
        $resultado = $clubesRepository->update($idClub, $clubDto);

        if ($resultado) {
            echo json_encode(["message" => "Club actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "No se pudo actualizar el club"]);
        }
        break;

    case 'eliminar':
        $idClub = $_POST["id"];

        // Eliminar el club de la base de datos
        $resultado = $clubesRepository->delete($idClub);

        if ($resultado) {
            echo json_encode(["message" => "Club eliminado correctamente"]);
        } else {
            echo json_encode(["error" => "No se pudo eliminar el club"]);
        }
        break;

    default:
        echo json_encode(["error" => "Operación no válida"]);
        break;
}
