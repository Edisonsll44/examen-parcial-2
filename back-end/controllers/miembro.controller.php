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
require_once '../config/MiembrosRepository.php';
require_once '../dto/MiembroDto.php';
require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$miembroRepository = new MiembroRepository($db);

switch ($_GET["op"]) {
    case 'todos':
        $miembros = $miembroRepository->findAll();
        $miembroDtos = array_map(function($miembro) {
            return new MiembroDto($miembro); 
        }, $miembros);
        echo json_encode($miembroDtos); 
        break;

    case 'uno':
        $idMiembro = $_POST["id"];
        $miembro = $miembroRepository->findById($idMiembro); 
        if ($miembro) {
            $miembroDto = new MiembroDto($miembro); 
            echo json_encode($miembroDto); 
        } else {
            echo json_encode(["error" => "Miembro no encontrado"]);
        }
        break;

    case 'insertar':
        if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["email"]) && isset($_POST["telefono"]) && isset($_POST["club_id"])) {
            $data = [
                'nombre' => $_POST["nombre"],
                'apellido' => $_POST["apellido"],
                'email' => $_POST["email"],
                'telefono' => $_POST["telefono"],
                'club_id' => $_POST["club_id"]
            ];

            // Crear un objeto MiembroDto con los datos recibidos
            $miembroDto = new MiembroDto($data);

            // Insertar el miembro en la base de datos
            $resultado = $miembroRepository->create($miembroDto);

            if ($resultado) {
                echo json_encode(["message" => "Miembro insertado correctamente"]);
            } else {
                echo json_encode(["error" => "No se pudo insertar el miembro asociado a un club"]);
            }
        } else {
            echo json_encode(["error" => "Datos incompletos"]);
        }
        break;

        case 'actualizar':
            // Verificar que se envía el ID del miembro
            if (!isset($_POST["miembro_id"])) {
                echo json_encode(["error" => "ID del miembro no proporcionado"]);
                break;
            }
    
            $idMiembro = $_POST["miembro_id"];
    
            // Validar que los datos para actualizar fueron enviados
            if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["email"]) && isset($_POST["telefono"]) && isset($_POST["club_id"])) {
                // Crear un array con los nuevos datos del miembro
                $data = [
                    'nombre' => $_POST["nombre"], 
                    'apellido' => $_POST["apellido"],
                    'email' => $_POST["email"],
                    'telefono' => $_POST["telefono"],
                    'club_id' => $_POST["club_id"]
                ];
            
                // Actualizar el miembro en la base de datos
                $resultado = $miembroRepository->update($idMiembro, miembro: $data);
            
                if ($resultado) {
                    echo json_encode(["message" => "Miembro actualizado correctamente"]);
                } else {
                    echo json_encode(["error" => "No se pudo actualizar el miembro"]);
                }
            } else {
                echo json_encode(["error" => "Datos incompletos para la actualización"]);
            }
            break;

    case 'eliminar':
        $idMiembro = $_POST["id"];

        // Eliminar el miembro de la base de datos
        $resultado = $miembroRepository->delete($idMiembro);

        if ($resultado) {
            echo json_encode(["message" => "Miembro eliminado correctamente"]);
        } else {
            echo json_encode(["error" => "No se pudo eliminar el miembro"]);
        }
        break;

    default:
        echo json_encode(["error" => "Operación no válida"]);
        break;
}
