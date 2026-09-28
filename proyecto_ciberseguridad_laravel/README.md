# CiberEskola

Aplicacion web educativa de ciberseguridad construida con Laravel. Incluye autenticacion, roles de administracion y alumnado, gestion de cursos, matriculas, cambio de idioma castellano/euskera y temas claro/oscuro.

## Documentacion

- [Infraestructura de red, VLAN, puertos, Proxmox y Active Directory](docs/infraestructura-red.md)
- [Evidencias y checklist de evaluacion](docs/evidencias-of.md)
- [Despliegue en la DMZ](deploy/README.md)

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
