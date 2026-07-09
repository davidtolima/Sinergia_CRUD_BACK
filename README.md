# Sinergia_CRUD_BACK

API RESTful en PHP plano (PDO) para la gestion de pacientes de la Clinica Tolima. Consume MySQL y expone endpoints JSON consumidos por el frontend en [Sinergia_CRUD_FRONT](https://github.com/davidtolima/Sinergia_CRUD_FRONT).

## Requisitos

- XAMPP (o cualquier MySQL corriendo en `127.0.0.1:3306`)
- PHP 8.0 o superior con las extensiones `pdo_mysql`, `mbstring`, `openssl` habilitadas
- Composer (para instalar PHPUnit)

## Instalacion

### 1. Crear la base de datos

Con MySQL corriendo (XAMPP), ejecuta los scripts en orden desde phpMyAdmin (pestana SQL) o por consola:

```bash
mysql -u root < database/schema.sql
mysql -u root < database/seeders.sql
```

Esto crea la base `sihos_pacientes` con las tablas `departamentos`, `municipios`, `tipos_documento`, `generos`, `pacientes`, `users`, y las llena con datos de prueba (incluye un usuario administrador).

### 2. Configurar la conexion

La conexion esta en [api/config/db.php](api/config/db.php). Por defecto usa:

```
host: 127.0.0.1
puerto: 3306
base de datos: sihos_pacientes
usuario: root
password: (vacio)
```

Ajusta esos valores si tu instalacion de MySQL usa credenciales distintas.

### 3. Instalar dependencias (solo para las pruebas unitarias)

```bash
composer install
```

### 4. Levantar el servidor

```bash
php -S localhost:8000
```

La API queda disponible en `http://localhost:8000/api`.

## Autenticacion

Todos los endpoints de `paciente.php` requieren un token JWT. El flujo es:

1. Llamar a `POST /api/usuario.php` con el correo y la contrasena para obtener el token.
2. Enviar ese token en cada peticion siguiente con la cabecera `Authorization: Bearer <token>`.

El token expira despues de 1 hora (configurable en [api/config/jwt.php](api/config/jwt.php)).

### Usuario administrador de prueba

| Campo | Valor |
|---|---|
| Correo | admin@sihos.com |
| Contrasena | 1234567890 |

Ejemplo de login:

```bash
curl -X POST http://localhost:8000/api/usuario.php \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@sihos.com","password":"1234567890"}'
```

## Endpoints

| Metodo | Ruta | Requiere token | Descripcion |
|---|---|---|---|
| POST | `/api/usuario.php` | No | Inicia sesion y devuelve el JWT |
| GET | `/api/catalogos.php` | No | Devuelve departamentos, municipios, tipos de documento y generos |
| GET | `/api/paciente.php` | Si | Lista todos los pacientes |
| GET | `/api/paciente.php?id=1` | Si | Obtiene un paciente por id |
| POST | `/api/paciente.php` | Si | Crea un paciente |
| PUT | `/api/paciente.php` | Si | Actualiza un paciente (requiere `id` en el body) |
| DELETE | `/api/paciente.php?id=1` | Si | Elimina un paciente |

## Pruebas unitarias

Con las dependencias instaladas (`composer install`):

```bash
php vendor/bin/phpunit
```

Cubre la funcion de validacion de datos del paciente (`validarPaciente()`): datos validos, correo con formato invalido, campos obligatorios faltantes.

## Estructura del proyecto

```
api/
  config/
    db.php                -> Conexion PDO a MySQL
    jwt.php                -> Generacion y validacion de tokens JWT
  controllers/
    UserController.php     -> Login
    obtener_pacientes.php
    agregar_paciente.php
    actualizar_paciente.php
    eliminar_paciente.php
    obtener_catalogos.php
  middleware/
    autenticacion.php      -> Verifica el token JWT en cada peticion protegida
  paciente.php              -> Router del CRUD de pacientes (protegido)
  catalogos.php             -> Router de catalogos (publico)
  usuario.php                -> Router de login
database/
  schema.sql                -> Creacion de tablas
  seeders.sql                -> Datos de prueba
tests/
  PacienteValidacionTest.php -> Pruebas unitarias con PHPUnit
```
