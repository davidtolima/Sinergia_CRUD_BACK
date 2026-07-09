<?php

function obtenerCatalogos($conexion)
{
    $departamentos = $conexion->query("SELECT id, nombre FROM departamentos ORDER BY nombre")->fetchAll();
    $municipios = $conexion->query("SELECT id, departamento_id, nombre FROM municipios ORDER BY nombre")->fetchAll();
    $tiposDocumento = $conexion->query("SELECT id, nombre FROM tipos_documento ORDER BY nombre")->fetchAll();
    $generos = $conexion->query("SELECT id, nombre FROM generos ORDER BY nombre")->fetchAll();

    echo json_encode([
        "departamentos" => $departamentos,
        "municipios" => $municipios,
        "tipos_documento" => $tiposDocumento,
        "generos" => $generos,
    ]);
}
