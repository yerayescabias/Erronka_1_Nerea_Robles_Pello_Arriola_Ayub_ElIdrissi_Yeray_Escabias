# CiberEskola

Aplicacion web educativa de ciberseguridad construida con Laravel. Incluye autenticacion, roles de administracion y alumnado, gestion CRUD de cursos, matriculas y pruebas automatizadas.

## Documentacion de infraestructura

- [Infraestructura de red, VLAN, puertos, Proxmox y AD](docs/infraestructura-red.md)
- [Evidencias OF y checklist de evaluacion](docs/evidencias-of.md)

La documentacion distingue entre la configuracion implementada en el codigo y las comprobaciones que deben realizarse en el laboratorio fisico o virtual.

## Puesta en marcha

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Para verificar el proyecto:

```bash
php artisan test
php artisan route:list
```

Credenciales de demostracion sembradas: `admin@cibereskola.eus` / `admin123`. Cambiarlas en cualquier entorno real.

---

## Laravel

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---


































## Pendiente para dejar la web lista

Esta lista recoge las tareas que aun deben completarse antes de considerar CiberEskola preparada para produccion en la infraestructura del proyecto.

### 1. Infraestructura y red

- [ ] Crear o identificar en Proxmox la maquina virtual o contenedor que alojara la web.
- [ ] Asignarle la IP `192.168.10.10` dentro de la DMZ `192.168.10.0/24`.
- [ ] Configurar como gateway de la DMZ `192.168.10.254`.
- [ ] Confirmar la conectividad desde el servidor web hacia MySQL `192.168.30.10`.
- [ ] Confirmar que el servidor web no puede acceder a redes internas que no necesite.
- [ ] Documentar el ID, nombre, sistema operativo y recursos de la VM en Proxmox `192.168.74.10`.
- [ ] Reservar una IP fija y configurar DNS para el dominio de la aplicacion.

### 2. Servidor web

- [ ] Instalar y actualizar PHP, extensiones PHP necesarias, Composer y el servidor web.
- [ ] Sustituir `php artisan serve`, que solo sirve para desarrollo local, por Apache o Nginx.
- [ ] Configurar el document root exclusivamente en `proyecto_ciberseguridad_laravel/public`.
- [ ] Impedir el acceso web a `.env`, `vendor`, `storage` y archivos internos.
- [ ] Configurar HTTPS con un certificado valido.
- [ ] Redirigir HTTP a HTTPS.
- [ ] Configurar limites de peticiones, subida de archivos y tiempos de espera.
- [ ] Configurar los logs del servidor web y su rotacion.

### 3. Configuracion de Laravel

- [ ] Crear un `.env` exclusivo para produccion y no reutilizar las credenciales locales.
- [ ] Configurar como minimo:

	```env
	APP_ENV=production
	APP_DEBUG=false
	APP_URL=https://dominio-de-la-web
	DB_HOST=192.168.30.10
	DB_PORT=3306
	```

- [ ] Generar una `APP_KEY` propia y mantenerla fuera del repositorio.
- [ ] Ejecutar `composer install --no-dev --optimize-autoloader`.
- [ ] Configurar `storage` y `bootstrap/cache` con permisos minimos.
- [ ] Ejecutar `php artisan migrate --force` en produccion.
- [ ] No ejecutar `php artisan migrate:fresh` en produccion.
- [ ] Ejecutar `php artisan config:cache`, `php artisan route:cache` y `php artisan view:cache` despues de configurar el entorno.
- [ ] Configurar la cache, sesiones, correo y colas segun los servicios disponibles.

### 4. Base de datos

- [ ] Crear una base de datos de produccion en `192.168.30.10`.
- [ ] Crear un usuario MySQL exclusivo para Laravel, sin utilizar `root`.
- [ ] Permitir el puerto `3306` unicamente desde `192.168.10.10`.
- [ ] Verificar las tablas del esquema final: `Rol`, `Usuarios`, `cursos` y `UsuariosCursos`.
- [ ] Comprobar las claves externas y la restriccion unica de `UsuariosCursos`.
- [ ] No cargar usuarios, contrasenas ni cursos de demostracion en produccion sin revisarlos.
- [ ] Preparar migraciones incrementales para futuros cambios del esquema.
- [ ] Crear copias de seguridad cifradas y probar su restauracion.

### 5. Firewall y DMZ

- [ ] Permitir desde Internet hacia la web unicamente `443/tcp`.
- [ ] Permitir `80/tcp` solo para redireccion HTTPS o validacion del certificado.
- [ ] Permitir desde `192.168.10.10` hacia `192.168.30.10` unicamente `3306/tcp`.
- [ ] Bloquear desde Internet el acceso a MySQL, Active Directory y las VLAN internas.
- [ ] Permitir SSH solo desde una VLAN de administracion autorizada.
- [ ] Aplicar una politica de denegacion por defecto entre la DMZ y las redes internas.
- [ ] Registrar y revisar los eventos del firewall pfSense.

### 6. Seguridad de la aplicacion

- [ ] Revisar todas las reglas de validacion de formularios.
- [ ] Aplicar limitacion de intentos al login y proteccion frente a fuerza bruta.
- [ ] Mantener CSRF activo en todas las rutas web.
- [ ] Configurar cookies `Secure`, `HttpOnly` y `SameSite`.
- [ ] Anadir cabeceras HSTS, CSP, X-Frame-Options, X-Content-Type-Options y Referrer-Policy.
- [ ] Revisar que ningun log muestre contrasenas, tokens o datos sensibles.
- [ ] Ejecutar una auditoria de dependencias con Composer.
- [ ] Mantener PHP, Laravel y paquetes actualizados.
- [ ] Revisar si se usara autenticacion local o integracion con Active Directory mediante LDAPS.

### 7. Funcionalidad y datos

- [ ] Probar login, logout y registro con usuarios reales de prueba.
- [ ] Probar la separacion de permisos entre administrador y alumno.
- [ ] Probar alta, eliminacion y activacion de alumnos.
- [ ] Probar creacion, edicion y eliminacion de cursos.
- [ ] Probar matriculacion y cancelacion usando `UsuariosCursos`.
- [ ] Revisar los mensajes de error y confirmacion.
- [ ] Completar la traduccion de todas las vistas y mensajes entre castellano y euskera.
- [ ] Revisar que el cambio de idioma y de tema funcione en todas las paginas.
- [ ] Revisar la vista movil y los formularios en distintos navegadores.

### 8. Pruebas y entrega

- [ ] Mantener todas las pruebas automatizadas pasando con `php artisan test`.
- [ ] Anadir pruebas para registro, validacion, permisos, idiomas y cambio de tema.
- [ ] Probar la aplicacion desde la DMZ y desde cada VLAN autorizada.
- [ ] Comprobar que los puertos no autorizados no son accesibles desde Internet.
- [ ] Realizar una prueba de restauracion de la base de datos.
- [ ] Revisar los logs durante una prueba completa de usuario.
- [ ] Preparar un procedimiento de despliegue y rollback.
- [ ] Documentar las credenciales iniciales y cambiarlas antes de entregar el sistema.
- [ ] Documentar el nombre e ID de la VM de Proxmox que aloja el servidor web.
