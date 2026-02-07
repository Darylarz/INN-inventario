# Load tests para Inventario (k6)

Instrucciones rápidas para ejecutar las pruebas de carga que crean artículos en `/inventario/store`.

Requisitos:
- k6 instalado en tu máquina (Manjaro ya lo tienes instalado).
- La app Laravel corriendo accesible en `BASE_URL`.
- Un usuario de prueba con permisos y contraseña.

Variables de entorno recomendadas:
- `BASE_URL` (ej: http://localhost:8000)
- `USER_EMAIL` y `USER_PASS` para login web
- `TIPO` nombre de `tipo_item` existente si el script no lo detecta
 - `LOADTEST_API_KEY` clave para la ruta API temporal (si usas los scripts API)

Comandos básicos:
```bash
# prueba ligera (script form-based que extrae CSRF)
BASE_URL="http://localhost:8000" USER_EMAIL="tu@correo" USER_PASS="tu_password" k6 run k6_create_inventario.js

# prueba de carga alta (rampa a 200 VUs, 5min hold)
BASE_URL="http://localhost:8000" USER_EMAIL="tu@correo" USER_PASS="tu_password" k6 run k6_create_inventario_high.js

# usando la ruta API sin CSRF (recomendado para carga alta):
LOADTEST_API_KEY="mi_secreto" BASE_URL="http://localhost:8000" TIPO="Computadoras" k6 run k6_create_inventario_api.js

# prueba alta con API
LOADTEST_API_KEY="mi_secreto" BASE_URL="http://localhost:8000" TIPO="Computadoras" k6 run k6_create_inventario_api_high.js
```

Consejos:
- Antes de una gran carga, desactiva herramientas que escriban mucho (Telescope, logs de debug) para no sesgar resultados.
- Si los formularios cambian, usa `TIPO` para forzar una categoría válida: `TIPO="Computadoras" k6 run ...`
- Para pruebas repetibles, ajusta los `stages` dentro del script.

Archivos:
- `k6_create_inventario.js` : script principal (login form -> CSRF -> POST /inventario/store)
- `k6_create_inventario_high.js` : variante con stages más agresivos
- `k6_create_inventario_api.js` : script que usa `/api/loadtest/inventario` y `X-API-KEY` (sin CSRF)
- `k6_create_inventario_api_high.js` : variante de alta carga usando la ruta API
