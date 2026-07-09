<?php

function iniciarSesion($conexion, $datos)
{
    if (empty($datos["email"]) || empty($datos["password"])) {
        http_response_code(422);
        echo json_encode(["error" => "El correo y la contrasena son obligatorios"]);
        return;
    }

    $sql = "SELECT id, name, email, password FROM users WHERE email = :email";
    $consulta = $conexion->prepare($sql);
    $consulta->bindValue(":email", $datos["email"]);
    $consulta->execute();

    $usuario = $consulta->fetch();

    if (!$usuario || !password_verify($datos["password"], $usuario["password"])) {
        http_response_code(401);
        echo json_encode(["error" => "Credenciales invalidas"]);
        return;
    }

    $token = generarJWT([
        "sub" => $usuario["id"],
        "name" => $usuario["name"],
        "email" => $usuario["email"],
    ]);

    echo json_encode([
        "mensaje" => "Inicio de sesion exitoso",
        "token" => $token,
        "usuario" => [
            "id" => $usuario["id"],
            "name" => $usuario["name"],
            "email" => $usuario["email"],
        ],
    ]);
}
