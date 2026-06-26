# 📄 Generador de Reportes Dinámico

¡Te doy la bienvenida al Generador de Reportes de mi portafolio!

Este proyecto actúa como un microservicio *stateless* de alta precisión. Está optimizado para ingerir cargas útiles de datos (JSON) y transformarlas dinámicamente en reportes financieros (PDF y CSV), minimizando el impacto de I/O en la infraestructura.

## 🚀 Características del Proyecto & Arquitectura Backend

- **Patrón Estrategia (Strategy Pattern):** Desacoplamiento absoluto en el controlador principal mediante expresiones `match` de PHP 8. La lógica de renderizado se delega a contratos (`ReportStrategy`), cumpliendo el principio Open/Closed SOLID para escalar nuevos formatos fácilmente.
- **Gestión de Memoria Stateless:** Uso de flujos de memoria (`php://temp`) para compilar archivos binarios pesados (como CSVs) directamente en la RAM del servidor. Evita la escritura en disco físico, haciéndolo ideal para despliegues Serverless.
- **Sanitización Gráfica y Datos Defensivos:** Intercepción de datos no paramétricos. Si el payload contiene estados financieros no reconocidos, el motor los clasifica automáticamente bajo un comodín visual, aplicando propiedades CSS estrictas para evitar desbordamientos en la vista impresa.
- **Testing Automatizado:** Cobertura de la integridad matemática de los reportes y validación de la estructura de exportación mediante **Pest**.

---

## 🛠️ Stack Tecnológico

| Tecnología | Versión | Propósito en el proyecto |
| :--- | :--- | :--- |
| **Laravel** | `^13.0` | Framework base operando en modo API REST |
| **PHP** | `^8.3` | Lenguaje de servidor (tipado estricto y match expressions) |
| **Dompdf** | `^3.0` | Motor de compilación para transformar vistas HTML/CSS a PDF |
| **Pest** | `^3.0` | Framework de pruebas para validación de artefactos |

---

## 💻 Comandos de Desarrollo y Despliegue

Instrucciones para levantar el entorno localmente. Se asume que el puerto `8000` está libre para el microservicio.

| Comando | Acción |
| :--- | :--- |
| `composer install` | Instala las dependencias del generador de reportes |
| `cp .env.example .env` | Genera el archivo de variables de entorno |
| `php artisan serve --port=8000` | Inicia el servidor de desarrollo local |
| `php artisan test` | Ejecuta la suite de pruebas automatizadas con Pest |

---

## 📡 Documentación de la API (Endpoints)

El microservicio expone rutas ligeras diseñadas para la comunicación inter-servicios o llamadas asíncronas desde el frontend.

### Health Check (`/api`)
| Método | Endpoint | Descripción | Respuesta |
| :--- | :--- | :--- | :--- |
| `GET`  | `/ping` | Valida la disponibilidad del motor y despierta servidores en *Cold Start*. | `200 OK` (JSON) |

### Renderizado de Artefactos (`/api/reportes`)
| Método | Endpoint | Descripción | Payload Requerido |
| :--- | :--- | :--- | :--- |
| `POST` | `/generar` | Compila el documento solicitado y devuelve el archivo binario (`Blob`). | JSON con `formato` (pdf/csv) y `data.items` |