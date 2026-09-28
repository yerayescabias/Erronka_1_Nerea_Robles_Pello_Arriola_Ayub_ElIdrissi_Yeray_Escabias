# Despliegue en la DMZ

Estas plantillas preparan el proyecto para el servidor web de la DMZ `192.168.10.10`. No contienen certificados, claves ni contrasenas reales.

## Servidor web

1. Copiar el proyecto a `/var/www/ciberskola`.
2. Copiar `.env.dmz.example` como `.env` y completar el dominio, `APP_KEY`, credenciales MySQL y SMTP.
3. Instalar dependencias de produccion:

```bash
composer install --no-dev --optimize-autoloader
```

4. Crear la clave y preparar caches:

```bash
php artisan key:generate --force
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

5. Configurar permisos solo para los directorios escribibles:

```bash
chown -R www-data:www-data /var/www/ciberskola/storage /var/www/ciberskola/bootstrap/cache
chmod -R u=rwX,g=rX,o= /var/www/ciberskola/storage /var/www/ciberskola/bootstrap/cache
```

6. Copiar `apache/ciberskola.conf.example` a `/etc/apache2/sites-available/ciberskola.conf`, sustituir el dominio y las rutas de certificado, y activar Apache:

```bash
a2enmod rewrite ssl headers
a2ensite ciberskola.conf
 apachectl configtest
 systemctl reload apache2
```

## Comprobaciones antes de publicar

- El `DocumentRoot` debe ser `/var/www/ciberskola/public`, nunca la raiz del repositorio.
- El firewall debe permitir desde el servidor web `192.168.10.10` hacia MySQL `192.168.30.10:3306`.
- No ejecutar `php artisan migrate:fresh` en la base de datos de produccion.
- No copiar `.env`, certificados ni claves privadas al repositorio.
- Confirmar que `APP_DEBUG=false` y que la web funciona por HTTPS.
- Comprobar que `.env`, `vendor`, `storage` y archivos de configuracion no son accesibles desde Internet.
