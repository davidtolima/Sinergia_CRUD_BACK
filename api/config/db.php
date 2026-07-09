<?php

$host = "127.0.0.1";
$puerto = "3306";
$baseDatos = "sihos_pacientes";
$usuario = "root";
$password = "";

try {
    $conexion = new PDO(
        "mysql:host=$host;port=$puerto;dbname=$baseDatos;charset=utf8mb4",
        $usuario,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexion a la base de datos: " . $e->getMessage()]);
    exit;
}
