<?php

function requiereAutenticacion()
{
    $encabezados = getallheaders();
    $autorizacion = $encabezados["Authorization"] ?? $encabezados["authorization"] ?? "";

    if (!$autorizacion || !str_starts_with($autorizacion, "Bearer ")) {
        http_response_code(401);
        echo json_encode(["error" => "Token no proporcionado"]);
        exit;
    }

    $token = substr($autorizacion, 7);
    $payload = validarJWT($token);

    if (!$payload) {
        http_response_code(401);
        echo json_encode(["error" => "Token invalido o expirado"]);
        exit;
    }

    return $payload;
}
