<?php

function agregarPaciente($conexion, $datos)
{
    $errores = validarPaciente($datos);

    if (!empty($errores)) {
        http_response_code(422);
        echo json_encode(["errores" => $errores]);
        return;
    }

    $sql = "INSERT INTO pacientes
                (tipo_documento_id, numero_documento, nombre1, nombre2, apellido1, apellido2,
                 genero_id, departamento_id, municipio_id, correo, foto, created_at, updated_at)
            VALUES
                (:tipo_documento_id, :numero_documento, :nombre1, :nombre2, :apellido1, :apellido2,
                 :genero_id, :departamento_id, :municipio_id, :correo, :foto, NOW(), NOW())";

    try {
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(":tipo_documento_id", $datos["tipo_documento_id"], PDO::PARAM_INT);
        $consulta->bindValue(":numero_documento", $datos["numero_documento"]);
        $consulta->bindValue(":nombre1", $datos["nombre1"]);
        $consulta->bindValue(":nombre2", $datos["nombre2"] ?? null);
        $consulta->bindValue(":apellido1", $datos["apellido1"]);
        $consulta->bindValue(":apellido2", $datos["apellido2"] ?? null);
        $consulta->bindValue(":genero_id", $datos["genero_id"], PDO::PARAM_INT);
        $consulta->bindValue(":departamento_id", $datos["departamento_id"], PDO::PARAM_INT);
        $consulta->bindValue(":municipio_id", $datos["municipio_id"], PDO::PARAM_INT);
        $consulta->bindValue(":correo", $datos["correo"]);
        $consulta->bindValue(":foto", $datos["foto"] ?? null);
        $consulta->execute();

        http_response_code(201);
        echo json_encode([
            "mensaje" => "Paciente creado correctamente",
            "id" => $conexion->lastInsertId(),
        ]);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            http_response_code(409);
            echo json_encode(["error" => "El numero de documento ya existe"]);
            return;
        }

        http_response_code(500);
        echo json_encode(["error" => "Error al crear el paciente: " . $e->getMessage()]);
    }
}

function validarPaciente($datos)
{
    $errores = [];

    if (empty($datos["tipo_documento_id"])) {
        $errores[] = "El tipo de documento es obligatorio";
    }

    if (empty($datos["numero_documento"])) {
        $errores[] = "El numero de documento es obligatorio";
    }

    if (empty($datos["nombre1"])) {
        $errores[] = "El primer nombre es obligatorio";
    }

    if (empty($datos["apellido1"])) {
        $errores[] = "El primer apellido es obligatorio";
    }

    if (empty($datos["genero_id"])) {
        $errores[] = "El genero es obligatorio";
    }

    if (empty($datos["departamento_id"])) {
        $errores[] = "El departamento es obligatorio";
    }

    if (empty($datos["municipio_id"])) {
        $errores[] = "El municipio es obligatorio";
    }

    if (empty($datos["correo"])) {
        $errores[] = "El correo es obligatorio";
    } elseif (!filter_var($datos["correo"], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo no tiene un formato valido";
    }

    return $errores;
}
