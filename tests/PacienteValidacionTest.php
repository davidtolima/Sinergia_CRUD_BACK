<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../api/controllers/agregar_paciente.php";

class PacienteValidacionTest extends TestCase
{
    private function pacienteValido()
    {
        return [
            "tipo_documento_id" => 1,
            "numero_documento" => "1005678901",
            "nombre1" => "Camilo",
            "apellido1" => "Rojas",
            "genero_id" => 1,
            "departamento_id" => 5,
            "municipio_id" => 9,
            "correo" => "camilo.rojas@mail.com",
        ];
    }

    public function testDatosCompletosYValidosNoDevuelveErrores()
    {
        $errores = validarPaciente($this->pacienteValido());

        $this->assertEmpty($errores);
    }

    public function testCorreoSinArrobaDevuelveError()
    {
        $datos = $this->pacienteValido();
        $datos["correo"] = "correo-invalido-sin-arroba";

        $errores = validarPaciente($datos);

        $this->assertContains("El correo no tiene un formato valido", $errores);
    }

    public function testNumeroDocumentoVacioDevuelveError()
    {
        $datos = $this->pacienteValido();
        $datos["numero_documento"] = "";

        $errores = validarPaciente($datos);

        $this->assertContains("El numero de documento es obligatorio", $errores);
    }

    public function testDatosVaciosDevuelveVariosErrores()
    {
        $errores = validarPaciente([]);

        // Con el arreglo vacio, los 8 campos obligatorios deben fallar
        $this->assertCount(8, $errores);
    }
}
