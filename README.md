Usuario:admin1
Contraseña:12345

1. Manejo y validación de la conexión a la Base de Datos
¿Cómo manejan la conexión y qué pasa si los datos son incorrectos?
La conexión se maneja de forma centralizada en el archivo db.php utilizando la función nativa de PHP mysqli_connect(), a la cual se le pasan las credenciales (servidor, usuario, contraseña y nombre de la base de datos).
Si alguno de estos datos es incorrecto (por ejemplo, si el servidor de MySQL en XAMPP está apagado o la contraseña es equivocada), la función falla y devuelve un valor booleano false.

Justificación de la validación de la conexión:
La validación se realiza mediante una estructura condicional if (!$conexion) { die("Error de conexión..."); }.
Se justifica el uso de la función die() porque detiene inmediatamente la ejecución de todo el script PHP. Esto es crucial ya que, si no hay conexión a la base de datos, no tiene sentido que el resto de la página intente cargar consultas o mostrar la interfaz. Además, previene que se muestren errores técnicos confusos o que se expongan vulnerabilidades al usuario final.

2. Diferencia entre $_GET y $_POST en PHP
Diferencias y cuándo usar cada uno:

$_GET: Envía la información a través de la URL de la página. Es visible para el usuario y tiene un límite de caracteres (alrededor de 2000). Es apropiado para acciones que no modifican datos, como realizar búsquedas, aplicar filtros o navegar entre páginas (ej. ?pagina=2).

$_POST: Envía la información oculta en el cuerpo (body) de la petición HTTP. No es visible en la URL y permite enviar grandes cantidades de datos (como imágenes o textos largos). Es apropiado para enviar información sensible (contraseñas) o para modificar datos en la base de datos (insertar, actualizar, eliminar).

Ejemplo real en el proyecto:
En nuestro archivo login.php y admin.php, utilizamos $_POST. Cuando el administrador registra a un nuevo estudiante en admin.php, el formulario hace un method="POST". Si hubiéramos usado GET, los datos personales del estudiante quedarían expuestos en el historial del navegador del usuario de esta manera: admin.php?nombre=Juan&carrera=Sistemas, lo cual es una mala práctica de privacidad y estética.

3. Riesgos de Seguridad y su Mitigación (Contexto Zona Oriental / UGB)
Dado que la aplicación manejará datos reales de estudiantes en la zona oriental (como en la Universidad Gerardo Barrios), existen riesgos críticos a considerar:

Riesgos identificados:

Inyección SQL (SQLi): Un atacante podría ingresar código SQL malicioso en el formulario de login o de registro para robar, borrar o alterar los datos de la base de datos.

Exposición de contraseñas (Plain Text): Actualmente, las contraseñas en la BD didáctica están en texto plano (12345). Si un atacante vulnera la BD, tendría acceso inmediato a las cuentas.

Cross-Site Scripting (XSS): Un atacante podría ingresar código JavaScript en el campo "Observaciones" y afectar a los administradores que vean la tabla.

¿Cómo los mitigaríamos?

Para la Inyección SQL: En el código actual usamos mysqli_real_escape_string como una medida básica, pero la mitigación profesional ideal es utilizar Sentencias Preparadas (Prepared Statements) con PDO o mysqli_stmt. Esto separa completamente el código SQL de los datos ingresados por el usuario.

Para las contraseñas: Antes de guardar un usuario en la base de datos, se debe usar la función password_hash() de PHP. Para el login, se usaría password_verify(). Así, si roban la base de datos, solo verán códigos indescifrables.

Para el XSS: Al mostrar los datos en la tabla pública (index.php), debemos envolver las variables de texto con la función htmlspecialchars(). Esto convierte los caracteres especiales de código en texto inofensivo.

### Diccionario de Datos

#### Tabla: usuarios
| Columna | Tipo de dato | Límite | ¿Es nulo? | Descripción |
| :--- | :--- | :--- | :--- | :--- |
| `id` | INT | N/A | NO | Identificador único (Primary Key). |
| `usuario` | VARCHAR | 50 | NO | Nombre de cuenta para el login. |
| `password` | VARCHAR | 255 | NO | Contraseña (se recomienda usar hash). |
| `rol` | VARCHAR | 20 | NO | Nivel de permiso (admin/staff). |

#### Tabla: estudiantes
| Columna | Tipo de dato | Límite | ¿Es nulo? | Descripción |
| :--- | :--- | :--- | :--- | :--- |
| `id` | INT | N/A | NO | Identificador único (Primary Key). |
| `nombre_completo` | VARCHAR | 100 | NO | Nombre del aspirante. |
| `carrera` | VARCHAR | 100 | NO | Carrera a la que aplica. |
| `genero` | VARCHAR | 20 | NO | Género del estudiante. |
| `observaciones` | TEXT | N/A | **SÍ** | Notas adicionales (opcional). |

