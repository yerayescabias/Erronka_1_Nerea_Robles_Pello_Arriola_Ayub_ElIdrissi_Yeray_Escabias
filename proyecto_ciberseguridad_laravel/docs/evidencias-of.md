# Evidencias OF y guia de evaluacion

## OF 1: Integracion de equipos y perifericos

- La tabla de puertos, VLAN y equipos esta en [infraestructura-red.md](infraestructura-red.md).
- Cada conexion debe acompañarse de una foto del rack o AP, export de configuracion y salida de `ipconfig /all`.
- La matriz de pruebas indica quien puede acceder a cada servicio y desde que red.
- La informacion suficiente para que otra persona continue el trabajo se conserva en el repositorio, no solo en un equipo local.

**Pendiente de aportar en laboratorio:** fotografias, configuracion real del switch/firewall/AP y resultados de las pruebas de conectividad.

## OF 2: Tratamiento seguro y vulnerabilidades

- Segmentacion por VLAN y politica de denegacion por defecto.
- Red de invitados aislada.
- Solo HTTPS publicado; SSH y Proxmox limitados a administracion.
- Base de datos sin exposicion directa a Internet.
- Contraseñas de la aplicacion almacenadas con `Hash::make`, nunca en texto plano.
- Middleware `auth` y `role` separa alumnado y administracion.
- CSRF activo en formularios web y validacion de entradas en controladores.

**Revision antes de produccion:** activar HTTPS real, `APP_DEBUG=false`, revisar secretos del `.env`, actualizar dependencias y ejecutar un escaneo de puertos desde cada VLAN.

## OF 3: Sistemas operativos, dominio y Proxmox

El diseño de las VMs, direccionamiento, puertos, dominio y GPO esta documentado en [infraestructura-red.md](infraestructura-red.md). La aplicacion Laravel corresponde a `VM02-WEB`.

Para alcanzar el nivel maximo hay que adjuntar:

- Captura de Proxmox con VM01 y VM02 encendidas.
- Captura de AD DS/DNS y de las OUs.
- `gpresult /r` de un equipo unido al dominio.
- Evidencia de acceso HTTPS a la aplicacion desde un equipo de VLAN 30.

## OF 4: Programacion conectada a base de datos

| Criterio | Evidencia en el proyecto |
|---|---|
| Variables y tipos | IDs tipados como `int`, datos validados y arrays de entrada |
| Condicionales | Roles, estado activo, estado de matricula y validaciones |
| Repeticiones | Iteraciones Blade sobre usuarios, cursos y matriculas |
| Funciones propias | Metodos de dominio en `User`, `Curso` y `Matricula` |
| Librerias | Eloquent, Hash, Auth, validadores y helpers de Laravel |
| Excepciones/errores | `findOrFail`, validacion HTTP, respuestas 403 y mensajes de sesion |
| CRUD | Alta, consulta, edicion, activacion/desactivacion y baja de cursos; alta y cancelacion de matriculas |
| Pruebas | `tests/Feature/ApplicationFlowTest.php` prueba login, roles y ciclo de matricula |

Comando de evidencia:

```bash
php artisan test
```

Resultado esperado actual: 5 pruebas superadas.
