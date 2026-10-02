# CiberEskola

Aplicacion web educativa de ciberseguridad construida con Laravel. Incluye autenticacion, roles de administracion y alumnado, gestion de cursos, matriculas, cambio de idioma castellano/euskera y temas claro/oscuro.

### 1. Aplicacion basica funcional

Se ha desarrollado una aplicacion web educativa llamada **CiberEskola**, orientada a la gestion de cursos de ciberseguridad y matriculas de alumnado. La aplicacion se ha construido con Laravel y sigue una arquitectura MVC (Modelo, Vista y Controlador).

Las funcionalidades principales que estan implementadas son:

- Pagina publica con el listado de cursos activos.
- Inicio y cierre de sesion.
- Activacion de cuentas de alumnado previamente registrado.
- Gestion diferenciada mediante los roles `admin` y `alumno`.
- Panel de administracion para gestionar usuarios, cursos y matriculas.
- Panel de alumnado para consultar cursos y matricularse.
- Cancelacion de las matriculas propias.
- Activacion y desactivacion de cursos.
- Busqueda y filtrado de informacion en el panel de administracion.

El flujo principal es el siguiente:

1. El administrador registra al alumno y crea los cursos.
2. El alumno activa su cuenta y establece una contrasena.
3. El alumno inicia sesion y accede a su panel.
4. El alumno se matricula en cursos activos.
5. El administrador consulta y gestiona las matriculas.

Las rutas se definen en [routes/web.php](routes/web.php), la autenticacion en [AuthController.php](app/Http/Controllers/AuthController.php), la administracion en [AdminController.php](app/Http/Controllers/AdminController.php) y las funciones del alumnado en [AlumnoController.php](app/Http/Controllers/AlumnoController.php).

### 2. PHP y programacion orientada a objetos

El proyecto esta desarrollado en PHP utilizando Laravel. Se aplican los principios de la programacion orientada a objetos mediante clases, propiedades, metodos, herencia y relaciones entre objetos.

Las clases principales son:

- `User`, que representa a los usuarios y sus roles.
- `Curso`, que representa los cursos disponibles.
- `Matricula`, que representa la relacion entre un alumno y un curso.
- Los controladores, que agrupan la logica de cada parte de la aplicacion.
- Los middleware, que controlan la autenticacion, los roles y las cabeceras de seguridad.

Los modelos utilizan Eloquent ORM, la capa de Laravel que permite trabajar con las tablas de la base de datos mediante objetos PHP. Por ejemplo, el modelo `Curso` permite consultar cursos activos y el modelo `Matricula` permite comprobar, crear y cancelar matriculas.

La organizacion por clases evita concentrar toda la logica en un unico archivo y facilita reutilizar el codigo, mantenerlo y ampliarlo.

Las evidencias principales se encuentran en [app/Models](app/Models), [app/Http/Controllers](app/Http/Controllers) y [app/Http/Middleware](app/Http/Middleware).

### 3. Organizacion avanzada del codigo PHP

Laravel proporciona una estructura avanzada para organizar el proyecto:

- **Modelos:** representan los datos y sus relaciones.
- **Controladores:** reciben las peticiones y ejecutan la logica de la aplicacion.
- **Middleware:** filtran las peticiones antes de llegar al controlador.
- **Rutas:** conectan las direcciones web con las acciones correspondientes.
- **Vistas Blade:** muestran la informacion al usuario.
- **Migraciones:** describen la estructura de la base de datos mediante clases PHP.
- **Seeders:** insertan los datos iniciales.

Los controladores utilizan validacion de datos, redirecciones y mensajes de sesion. Los modelos definen los campos que se pueden guardar y las relaciones entre tablas. Ademas, se utilizan metodos reutilizables para consultas como la obtencion de cursos activos o la comprobacion de matriculas duplicadas.

Esta organizacion permite aplicar el principio de responsabilidad unica: cada parte del proyecto tiene una funcion concreta y las responsabilidades estan separadas.

### 4. Gestion de la base de datos: CRUD

La aplicacion realiza operaciones CRUD sobre la informacion almacenada:

| Operacion | Funcion implementada |
| --- | --- |
| Create | El administrador crea usuarios y cursos; las matriculas se crean cuando un alumno se inscribe. |
| Read | Se consultan cursos, usuarios, matriculas y estadisticas desde las vistas correspondientes. |
| Update | El administrador modifica los datos de los cursos y cambia su estado. |
| Delete | El administrador elimina usuarios y cursos; el alumno puede cancelar sus propias matriculas. |

Las tablas y relaciones se crean mediante las migraciones de [database/migrations](database/migrations). Las tablas principales son:

- `Rol`, con los roles de la aplicacion.
- `Usuarios`, con los datos de los usuarios.
- `cursos`, con la informacion de los cursos.
- `UsuariosCursos`, que relaciona usuarios y cursos.

La tabla `UsuariosCursos` tiene una restriccion unica para impedir que un alumno se matricule dos veces en el mismo curso. Las claves externas utilizan borrado en cascada para mantener la integridad de los datos.

### 5. Uso de MySQL

La aplicacion esta preparada para utilizar **MySQL** en el entorno de produccion. La conexion se configura en el archivo `.env` mediante las variables de Laravel:

```env
DB_CONNECTION=mysql
DB_HOST=192.168.30.10
DB_PORT=3306
DB_DATABASE=centro_educativo
DB_USERNAME=ciberskola_app
DB_PASSWORD=CONTRASENA_REAL
```

MySQL almacena de forma permanente los usuarios, cursos, roles y matriculas. El servidor web se encuentra en la DMZ y se conecta al servidor MySQL de la red de servicios utilizando el puerto `3306`. El firewall limita el acceso para que solamente el servidor web pueda conectarse a la base de datos.

Para crear la estructura de tablas en MySQL se ejecutan las migraciones de Laravel:

```bash
php artisan migrate --force
```

Durante el desarrollo local se utiliza SQLite para facilitar las pruebas sin depender de un servidor externo. El cambio entre SQLite y MySQL se realiza modificando `DB_CONNECTION` en `.env`; el codigo de la aplicacion se mantiene igual porque Laravel utiliza Eloquent ORM.

### 6. Interfaz y elementos adicionales

La interfaz se ha desarrollado con vistas Blade, HTML, CSS y JavaScript. Las vistas comparten la estructura de [app.blade.php](resources/views/layouts/app.blade.php), que contiene la navegacion, el logo, los mensajes y el pie de pagina.

Se han añadido los siguientes elementos para mejorar la experiencia de uso:

- Diseño adaptable a ordenador, tablet y movil.
- Tema claro y tema oscuro guardados en `localStorage`.
- Cambio de idioma entre castellano y euskera.
- Mensajes de confirmacion y notificaciones tipo toast.
- Indicadores de carga al enviar formularios.
- Confirmacion antes de eliminar datos o cancelar matriculas.
- Busqueda y filtrado de tablas en el panel de administracion.
- Estilos diferenciados para cursos, estados, botones y paneles.

El comportamiento dinamico se implementa principalmente con JavaScript en las vistas Blade. La configuracion de recursos frontend se encuentra en [vite.config.js](vite.config.js) y los recursos generales en [resources/js](resources/js) y [resources/css](resources/css).

### 7. Seguridad aplicada

Ademas de las funcionalidades de la rubrica, se han aplicado medidas de seguridad:

- Contraseñas almacenadas mediante hash.
- Proteccion CSRF en los formularios.
- Middleware `auth` para las zonas privadas.
- Middleware de roles para separar administradores y alumnos.
- Limitacion de intentos de inicio de sesion.
- Validacion de los datos recibidos.
- Prevencion de matriculas duplicadas.
- Cabeceras HTTP de seguridad mediante `SecurityHeaders`.
- Restriccion para que cada alumno solo pueda cancelar sus propias matriculas.

Las comprobaciones de seguridad se encuentran principalmente en [CheckRole.php](app/Http/Middleware/CheckRole.php), [SecurityHeaders.php](app/Http/Middleware/SecurityHeaders.php) y en los controladores.

### 8. Evidencias para la evaluacion

Para demostrar el funcionamiento de la aplicacion se pueden realizar las siguientes pruebas:

1. Acceder a la pagina publica y comprobar que aparecen los cursos activos.
2. Iniciar sesion como administrador y crear, editar, activar y eliminar un curso.
3. Registrar un alumno desde el panel de administracion.
4. Activar la cuenta del alumno y acceder con sus credenciales.
5. Matricularse en un curso y comprobar que aparece en el panel del alumno.
6. Intentar repetir la matricula y comprobar que el sistema la rechaza.
7. Cancelar la matricula desde la cuenta del alumno.
8. Comprobar que un alumno no puede acceder al panel de administracion.
9. Cambiar el idioma y el tema visual.
10. Ejecutar las pruebas automaticas con `php artisan test`.

Estas pruebas cubren las funcionalidades principales, la programacion orientada a objetos, las operaciones CRUD, la persistencia en base de datos, los roles y los elementos adicionales de la interfaz.

## Ejecucion local sin XAMPP

Esta configuracion utiliza PHP directamente, SQLite y el servidor integrado de Laravel. No necesita XAMPP, Apache ni MySQL.

### Paso 1. Instalar los requisitos

- PHP 8.0.2 o superior.
- Composer.
- Extensiones PHP `sqlite3` y `pdo_sqlite`.

PHP y Composer deben estar disponibles desde PowerShell o una terminal. No es necesario instalar XAMPP, Apache ni MySQL para esta configuracion local.

### Paso 2. Comprobar PHP y SQLite

```bash
php -v
php -m
```

La salida debe incluir `sqlite3` y `pdo_sqlite`. Si no aparecen, activar `extension=sqlite3` y `extension=pdo_sqlite` en `php.ini` y abrir una nueva terminal.

### Paso 3. Abrir el proyecto

Desde PowerShell, situarse en la carpeta que contiene el archivo `artisan`:

```powershell
cd C:\ruta\al\proyecto_ciberseguridad_laravel
```

### Paso 4. Instalar Laravel

```bash
composer install
copy .env.example .env
php artisan key:generate
```

### Paso 5. Configurar SQLite

Editar `.env` y dejar esta configuracion:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

No es necesario configurar `DB_HOST`, `DB_PORT`, `DB_USERNAME` ni `DB_PASSWORD` con SQLite.

En Windows:

```powershell
New-Item -ItemType File database\database.sqlite -Force
```

En Linux o macOS:

```bash
touch database/database.sqlite
```

### Paso 6. Crear las tablas y datos iniciales

```bash
php artisan config:clear
php artisan migrate --seed
```

### Paso 7. Iniciar la web

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Mantener la terminal abierta y abrir en el navegador:

```text
http://127.0.0.1:8000
```

Para detener el servidor, pulsar `Ctrl+C` en esa terminal.

### Paso 8. Acceso de demostracion

```text
Correo: admin@cibereskola.eus
Contraseña: admin123
```

Estas credenciales solo son para local. Deben cambiarse antes de cualquier despliegue real.

### Paso 9. Comprobaciones

```bash
php artisan test
php artisan route:list
php artisan view:cache
```

## Despliegue en la DMZ

La arquitectura prevista es:

```text
Servidor web Laravel: 192.168.10.10
Red DMZ:              192.168.10.0/24
Gateway DMZ:          192.168.10.254
Base de datos MySQL:  192.168.30.10
Dominio:              https://cibereskola.eus
```

En produccion no se utiliza XAMPP ni `php artisan serve`. Se utiliza Apache o Nginx con PHP, y MySQL en la red de servicios.

### Paso 1. Preparar el servidor web

1. Crear o identificar la VM de Proxmox que alojara la web.
2. Asignarle `192.168.10.10/24`.
3. Configurar como gateway `192.168.10.254`.
4. Instalar Apache, PHP, extensiones PHP y Composer.
5. Copiar el proyecto a `/var/www/ciberskola`.

### Paso 2. Configurar el entorno de produccion

Copiar la plantilla:

```bash
cp .env.dmz.example .env
```

Editar `.env` y completar los valores reales:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://cibereskola.eus

DB_CONNECTION=mysql
DB_HOST=192.168.30.10
DB_PORT=3306
DB_DATABASE=centro_educativo
DB_USERNAME=ciberskola_app
DB_PASSWORD=CONTRASEÑA_REAL
```

La contraseña real nunca debe guardarse en GitHub ni en el repositorio.

### Paso 3. Instalar y preparar Laravel

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

No ejecutar `php artisan migrate:fresh` en produccion porque elimina todas las tablas y datos.

### Paso 4. Configurar Apache

Usar la plantilla [ciberskola.conf.example](deploy/apache/ciberskola.conf.example).

El `DocumentRoot` debe apuntar exclusivamente a:

```text
/var/www/ciberskola/public
```

Activar modulos y sitio:

```bash
a2enmod rewrite ssl headers
a2ensite ciberskola.conf
apachectl configtest
systemctl reload apache2
```

Configurar un certificado HTTPS valido para `cibereskola.eus` y redirigir HTTP a HTTPS.

### Paso 5. Configurar MySQL y firewall

- Crear la base `centro_educativo` en `192.168.30.10`.
- Crear el usuario `ciberskola_app` con una contraseña segura.
- Permitir MySQL solo desde `192.168.10.10`.
- Permitir desde la DMZ hacia MySQL solo `TCP 3306`.
- Permitir desde Internet hacia la web solo `TCP 443`.
- Bloquear desde Internet el acceso a MySQL, Active Directory y VLAN internas.
- Permitir SSH únicamente desde la VLAN de administracion.

### Paso 6. Permisos y comprobaciones

```bash
chown -R www-data:www-data /var/www/ciberskola/storage /var/www/ciberskola/bootstrap/cache
chmod -R u=rwX,g=rX,o= /var/www/ciberskola/storage /var/www/ciberskola/bootstrap/cache
```

Comprobar que:

- `APP_DEBUG=false`.
- `.env`, `vendor` y archivos internos no son accesibles desde Internet.
- La web carga por HTTPS.
- Laravel conecta con MySQL.
- Login, registro, roles, cursos y matriculas funcionan.
- Los logs no muestran contraseñas ni secretos.

## Seguridad implementada

- Proteccion CSRF en las rutas web.
- Limitacion de intentos de login.
- Middleware de roles para administradores y alumnos.
- Cabeceras de seguridad HTTP.
- Bloqueo de autoeliminacion del administrador.
- Contraseñas almacenadas mediante hash.
- Cookies de sesion preparadas para HTTPS.
- Pruebas automatizadas de login, roles y matriculas.

## Estado de las pruebas

Ejecutar:

```bash
php artisan test
```

El proyecto debe terminar con todas las pruebas en estado `PASS` antes de subirlo a la DMZ.
