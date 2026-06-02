## Reglas de arquitectura del proyecto

Este proyecto usa Laravel 12, Inertia, React, TypeScript, Tailwind CSS, shadcn/ui y PostgreSQL.

Reglas obligatorias:

* Los controladores deben ser delgados.
* Toda lógica de negocio debe vivir en `app/Services` o `app/Actions`.
* Toda validación debe realizarse mediante Form Requests.
* No colocar lógica de negocio compleja dentro de componentes React.
* No duplicar componentes si ya existe un componente reutilizable.
* No crear estructuras paralelas si el proyecto ya tiene una convención existente.
* Toda nueva funcionalidad debe respetar la arquitectura actual del sistema base.

---

## Reglas de base de datos

Reglas obligatorias:

* Usar PostgreSQL como base de datos.
* No escribir migraciones o consultas que dependan exclusivamente de MySQL.
* Usar nombres de tablas y columnas en `snake_case`.
* Las entidades principales deben usar `softDeletes()` cuando aplique.
* Las entidades críticas deben registrar quién creó o actualizó el registro cuando aplique.
* Las tablas principales del módulo de tickets deben conservar integridad referencial mediante foreign keys.
* No eliminar información histórica importante de tickets; usar historial, logs o soft delete.

Tablas esperadas para el módulo de tickets:

* `tickets`
* `ticket_messages`
* `ticket_attachments`
* `ticket_statuses`
* `ticket_priorities`
* `ticket_categories`
* `ticket_assignments`
* `ticket_activity_logs`
* `ticket_ai_suggestions`
* `ticket_sla_policies`

---

## Reglas del dominio de tickets

Un ticket representa una solicitud de soporte, mantenimiento, cambio, error o mejora reportada por un cliente o usuario interno.

Estados base sugeridos:

* Nuevo
* En revisión
* Asignado
* En proceso
* En espera del cliente
* Resuelto
* Cerrado
* Reabierto

Reglas obligatorias:

* Un ticket debe tener título, descripción, estado, prioridad y categoría.
* Un ticket puede tener responsable asignado.
* Un ticket puede tener mensajes, adjuntos, historial y sugerencias de IA.
* Un ticket cerrado no debe modificarse directamente.
* Si un cliente responde un ticket cerrado, debe evaluarse si se reabre o si se crea un nuevo ticket relacionado.
* No se debe cerrar un ticket sin registrar una resolución.
* Todo cambio importante debe registrarse en el historial del ticket.

---

## Reglas de permisos

Todo módulo, acción, botón y endpoint debe respetar permisos.

Permisos sugeridos:

* `tickets.view`
* `tickets.create`
* `tickets.update`
* `tickets.assign`
* `tickets.reply`
* `tickets.close`
* `tickets.reopen`
* `tickets.delete`
* `tickets.ai.review`
* `tickets.ai.execute`
* `tickets.reports.view`
* `tickets.settings.manage`

Reglas obligatorias:

* Ninguna acción sensible debe depender solo de ocultar botones en frontend.
* Toda acción debe validarse también en backend.
* No permitir asignar tickets a usuarios que no tengan rol o permiso válido.
* No permitir que clientes vean tickets de otros clientes.

---

## Reglas para IA dentro del sistema

La IA puede apoyar en:

* Clasificar tickets.
* Sugerir prioridad.
* Sugerir dificultad.
* Detectar si el ticket es soporte, bug, mejora o desarrollo nuevo.
* Generar una propuesta técnica.
* Generar checklist de solución.
* Redactar respuestas sugeridas para el cliente.

Reglas obligatorias:

* La IA no debe cerrar tickets automáticamente sin aprobación humana.
* La IA no debe ejecutar cambios críticos en producción sin aprobación de un usuario autorizado.
* Toda sugerencia de IA debe guardarse en historial.
* Toda acción aceptada o rechazada por un usuario debe quedar registrada.
* La IA debe ser tratada como asistente, no como autoridad final.

---

## Reglas de UI para tickets

Reglas obligatorias:

* Las listas de tickets deben incluir filtros por estado, prioridad, categoría, responsable y fecha.
* Los estados deben mostrarse con badges visuales.
* Las prioridades deben tener colores consistentes.
* El detalle del ticket debe mostrar conversación, adjuntos, historial y datos principales.
* Las respuestas del ticket deben mostrarse como timeline o conversación.
* Los adjuntos de deben de guardar siempre en la tabla de Files, usando File y los campos related_table y related_uuid.
* Los adjuntos deben usar siempre `resources/js/components/file-picker-dialog.tsx`.
* Los formularios dentro de modal deben usar `resources/js/components/crud-form-dialog.tsx`.
* Los inputs deben usar `resources/js/components/form-input-field.tsx`.
* Los textarea deben usar `resources/js/components/form-textarea-field.tsx`.
* Los botones de guardado fuera de dialog deben usar `resources/js/components/loading-submit-button.tsx`.
* Los formatos de fecha siempre ponlo en dd/mm/yyyy y si tiene horas incluyelas en formato AM/PM
* Todas las accinoes necesitan regresar una confirmación con un Sonner.
---

## Estructura frontend sugerida

Usar la siguiente estructura para el módulo de tickets:

```txt
resources/js/pages/tickets/
resources/js/components/tickets/
resources/js/types/tickets.ts
```

Reglas obligatorias:

* Usar TypeScript.
* Evitar `any` salvo caso justificado.
* Reutilizar componentes existentes antes de crear nuevos.
* Separar formularios grandes en componentes pequeños.
* Mantener consistencia visual con shadcn/ui.

---

## Reglas de rutas

Las rutas del módulo de tickets deben usar prefijo y nombres consistentes.

Ejemplos:

```txt
tickets.index
tickets.create
tickets.store
tickets.show
tickets.edit
tickets.update
tickets.assign
tickets.close
tickets.reopen
tickets.messages.store
tickets.attachments.store
tickets.settings.categories.index
tickets.settings.priorities.index
```

Reglas obligatorias:

* Todas las rutas deben estar protegidas con autenticación.
* Las rutas sensibles deben estar protegidas por permisos.
* No crear rutas duplicadas para la misma acción.
* No usar nombres de rutas ambiguos.

---

## Reglas de validación

Usar Form Requests para validar acciones principales.

Requests sugeridos:

* `StoreTicketRequest`
* `UpdateTicketRequest`
* `StoreTicketMessageRequest`
* `AssignTicketRequest`
* `CloseTicketRequest`
* `ReopenTicketRequest`

Reglas obligatorias:

* No validar directamente dentro del controlador si existe Form Request.
* No permitir cerrar ticket sin resolución.
* No permitir responder tickets cerrados sin pasar por flujo de reapertura.
* No permitir adjuntar archivos sin validación de tipo, tamaño y relación con el ticket.

---

## Reglas de historial y auditoría

Toda acción importante debe registrarse en `ticket_activity_logs`.

Acciones mínimas a registrar:

* Creación de ticket.
* Cambio de estado.
* Cambio de prioridad.
* Cambio de categoría.
* Asignación de responsable.
* Respuesta agregada.
* Archivo adjuntado.
* Sugerencia de IA generada.
* Sugerencia de IA aceptada o rechazada.
* Ticket cerrado.
* Ticket reabierto.

---

## Reglas de pruebas

Toda funcionalidad importante debe incluir pruebas cuando aplique.

Pruebas mínimas sugeridas:

* Crear ticket.
* Editar ticket.
* Responder ticket.
* Asignar ticket.
* Cambiar estado.
* Cerrar ticket.
* Reabrir ticket.
* Validar permisos.
* Validar visibilidad por rol.
* Validar historial de actividad.

---

## Reglas para trabajo por sprints

Reglas obligatorias:

* No avanzar fuera del alcance del sprint solicitado.
* No modificar módulos no relacionados salvo que sea estrictamente necesario.
* Si algo ya existe, reutilizarlo.
* Si una decisión técnica no está clara, seguir la convención existente del proyecto.
* Cada sprint debe dejar el sistema en estado funcional.
* No dejar código muerto, rutas sin uso o componentes duplicados.
* Toda nueva funcionalidad debe integrarse con permisos, navegación y validaciones.