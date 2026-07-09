# Sinergia_CRUD_BACK

API RESTful en PHP plano (PDO) para la gestion de pacientes del sistema SIHOS. Consume MySQL y expone endpoints JSON consumidos por el frontend en [Sinergia_CRUD_FRONT](https://github.com/davidtolima/Sinergia_CRUD_FRONT).

## Requisitos

- XAMPP (o cualquier MySQL corriendo en `127.0.0.1:3306`)
- PHP 8.0 o superior con las extensiones `pdo_mysql`, `mbstring`, `openssl` habilitadas

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

### 3. Levantar el servidor

```bash
php -S localhost:8000
```

La API queda disponible en `http://localhost:8000/api`.

## Usuario administrador de prueba

| Campo | Valor |
|---|---|
| Correo | admin@sihos.com |
| Contrasena | 1234567890 |

## Endpoints

| Metodo | Ruta | Descripcion |
|---|---|---|
| GET | `/api/paciente.php` | Lista todos los pacientes |
| GET | `/api/paciente.php?id=1` | Obtiene un paciente por id |
| POST | `/api/paciente.php` | Crea un paciente |
| PUT | `/api/paciente.php` | Actualiza un paciente (requiere `id` en el body) |
| DELETE | `/api/paciente.php?id=1` | Elimina un paciente |
| GET | `/api/catalogos.php` | Devuelve departamentos, municipios, tipos de documento y generos |

## Estructura del proyecto

```
api/
  config/
    db.php              -> Conexion PDO a MySQL
  controllers/
    obtener_pacientes.php
    agregar_paciente.php
    actualizar_paciente.php
    eliminar_paciente.php
    obtener_catalogos.php
  paciente.php           -> Router del CRUD de pacientes
  catalogos.php          -> Router de catalogos
database/
  schema.sql             -> Creacion de tablas
  seeders.sql             -> Datos de prueba
```
