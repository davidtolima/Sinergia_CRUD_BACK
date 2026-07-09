<?php

function actualizarPaciente($conexion, $datos)
{
    if (empty($datos["id"])) {
        http_response_code(422);
        echo json_encode(["error" => "El id del paciente es obligatorio"]);
        return;
    }

    $errores = validarPaciente($datos);

    if (!empty($errores)) {
        http_response_code(422);
        echo json_encode(["errores" => $errores]);
        return;
    }

    $sql = "UPDATE pacientes SET
                tipo_documento_id = :tipo_documento_id,
                numero_documento = :numero_documento,
                nombre1 = :nombre1,
                nombre2 = :nombre2,
                apellido1 = :apellido1,
                apellido2 = :apellido2,
                genero_id = :genero_id,
                departamento_id = :departamento_id,
                municipio_id = :municipio_id,
                correo = :correo,
                foto = :foto,
                updated_at = NOW()
            WHERE id = :id";

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
        $consulta->bindValue(":id", $datos["id"], PDO::PARAM_INT);
        $consulta->execute();

        if ($consulta->rowCount() === 0) {
            http_response_code(404);
            echo json_encode(["error" => "Paciente no encontrado"]);
            return;
        }

        echo json_encode(["mensaje" => "Paciente actualizado correctamente"]);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            http_response_code(409);
            echo json_encode(["error" => "El numero de documento ya existe"]);
            return;
        }

        http_response_code(500);
        echo json_encode(["error" => "Error al actualizar el paciente: " . $e->getMessage()]);
    }
}
