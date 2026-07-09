-- Datos de prueba para SIHOS - Modulo de Pacientes
-- Ejecutar despues de schema.sql

USE sihos_pacientes;

INSERT INTO departamentos (nombre) VALUES
('Antioquia'), ('Cundinamarca'), ('Valle del Cauca'), ('Atlantico'), ('Tolima');

INSERT INTO municipios (departamento_id, nombre) VALUES
(1, 'Medellin'), (1, 'Envigado'),
(2, 'Bogota'), (2, 'Soacha'),
(3, 'Cali'), (3, 'Palmira'),
(4, 'Barranquilla'), (4, 'Soledad'),
(5, 'Ibague'), (5, 'Espinal');

INSERT INTO tipos_documento (nombre) VALUES
('Cedula de Ciudadania'), ('Tarjeta de Identidad');

INSERT INTO generos (nombre) VALUES
('Masculino'), ('Femenino');

INSERT INTO pacientes (tipo_documento_id, numero_documento, nombre1, nombre2, apellido1, apellido2, genero_id, departamento_id, municipio_id, correo) VALUES
(1, '1001234567', 'Juan', 'Carlos', 'Perez', 'Gomez', 1, 1, 1, 'juan.perez@mail.com'),
(1, '1002345678', 'Maria', NULL, 'Lopez', 'Diaz', 2, 2, 3, 'maria.lopez@mail.com'),
(1, '1003456789', 'Andres', NULL, 'Ramirez', NULL, 1, 3, 5, 'andres.ramirez@mail.com'),
(2, '1004567890', 'Sofia', 'Isabel', 'Torres', 'Vargas', 2, 4, 7, 'sofia.torres@mail.com'),
(1, '1005678901', 'Camilo', NULL, 'Rojas', 'Munoz', 1, 5, 9, 'camilo.rojas@mail.com');

-- Usuario administrador (contrasena: 1234567890, hasheada con bcrypt)
INSERT INTO users (name, email, password) VALUES
('Admin', 'admin@sihos.com', '$2y$12$1Qh.d2QurI9.guJZrc6koO5n.VRdOWsOMTrOKo4yL7HoCz9GXauJC');
