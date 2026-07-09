<?php

header("Access-Control-Allow-Origin: http://localhost:5500");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require "config/db.php";
require "controllers/obtener_catalogos.php";

obtenerCatalogos($conexion);
