<?php

header("Access-Control-Allow-Origin: http://localhost:5500");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require "config/db.php";
require "controllers/obtener_pacientes.php";
require "controllers/agregar_paciente.php";
require "controllers/actualizar_paciente.php";
require "controllers/eliminar_paciente.php";

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"), true);
$id = $_GET["id"] ?? null;

switch ($metodo) {
    case "GET":
        obtenerPacientes($conexion, $id);
        break;

    case "POST":
        agregarPaciente($conexion, $datos);
        break;

    case "PUT":
        actualizarPaciente($conexion, $datos);
        break;

    case "DELETE":
        eliminarPaciente($conexion, $datos ?? ["id" => $id]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Metodo no permitido"]);
        break;
}
