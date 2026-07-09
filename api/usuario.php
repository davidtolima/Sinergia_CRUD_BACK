<?php

header("Access-Control-Allow-Origin: http://localhost:5500");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require "config/db.php";
require "config/jwt.php";
require "controllers/UserController.php";

$metodo = $_SERVER["REQUEST_METHOD"];
$datos = json_decode(file_get_contents("php://input"), true);

switch ($metodo) {
    case "POST":
        iniciarSesion($conexion, $datos);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Metodo no permitido"]);
        break;
}
