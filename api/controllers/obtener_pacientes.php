<?php

function obtenerPacientes($conexion, $id = null)
{
    $sql = "SELECT
                p.id,
                p.tipo_documento_id,
                td.nombre AS tipo_documento,
                p.numero_documento,
                p.nombre1,
                p.nombre2,
                p.apellido1,
                p.apellido2,
                p.genero_id,
                g.nombre AS genero,
                p.departamento_id,
                d.nombre AS departamento,
                p.municipio_id,
                m.nombre AS municipio,
                p.correo,
                p.foto,
                p.created_at,
                p.updated_at
            FROM pacientes p
            INNER JOIN tipos_documento td ON td.id = p.tipo_documento_id
            INNER JOIN generos g ON g.id = p.genero_id
            INNER JOIN departamentos d ON d.id = p.departamento_id
            INNER JOIN municipios m ON m.id = p.municipio_id";

    if ($id !== null) {
        $sql .= " WHERE p.id = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(":id", $id, PDO::PARAM_INT);
        $consulta->execute();

        $paciente = $consulta->fetch();

        if (!$paciente) {
            http_response_code(404);
            echo json_encode(["error" => "Paciente no encontrado"]);
            return;
        }

        echo json_encode($paciente);
        return;
    }

    $sql .= " ORDER BY p.id DESC";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();

    echo json_encode($consulta->fetchAll());
}
