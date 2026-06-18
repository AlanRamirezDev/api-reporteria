# Motor de Artefactos y Reportería Dinámica (Microservicio)

Microservicio *stateless* backend desarrollado en PHP 8.3 y Laravel 13, diseñado para actuar como un motor de generación de documentos (PDF/CSV) de alta precisión.
## Arquitectura y Decisiones Técnicas
* **Gestión de Memoria:** Generación de archivos en tiempo real y de memoria (`php://temp`) para optimizar el consumo de RAM.
* **Patrones de Diseño:** Implementación estricta de principios SOLID utilizando el patrón **Strategy** para la delegación del renderizado de formatos.
* **Calidad y Precisión:** Flujo de auditoría respaldado por **Pest** para garantizar la integridad matemática de los reportes generados.
