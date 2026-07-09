<?php

function eliminarPaciente($conexion, $datos)
{
    if (empty($datos["id"])) {
        http_response_code(422);
        echo json_encode(["error" => "El id del paciente es obligatorio"]);
        return;
    }

    $sql = "DELETE FROM pacientes WHERE id = :id";

    try {
        $consulta = $conexion->prepare($sql);
        $consulta->bindValue(":id", $datos["id"], PDO::PARAM_INT);
        $consulta->execute();

        if ($consulta->rowCount() === 0) {
            http_response_code(404);
            echo json_encode(["error" => "Paciente no encontrado"]);
            return;
        }

        echo json_encode(["mensaje" => "Paciente eliminado correctamente"]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Error al eliminar el paciente: " . $e->getMessage()]);
    }
}
