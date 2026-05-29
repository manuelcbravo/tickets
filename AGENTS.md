# AGENTS.md

## Proyecto

Agendix es un sistema de gestión de citas para clínica dental construido con Laravel 12, React, Tailwind y shadcn/ui.

## Objetivo de este archivo

Este archivo define reglas obligatorias para cualquier agente, IA, asistente o generador de código que trabaje dentro del proyecto. Estas reglas deben respetarse siempre para mantener consistencia visual, técnica y funcional.

---

## Reglas globales de UI

### 1. Formularios dentro de dialog

Todo dialog que contenga formularios debe usar siempre este componente:

`C:\laragon\www\base_laravel_react\resources\js\components\crud-form-dialog.tsx`

Reglas:

* No crear dialogs alternos para formularios si este componente ya resuelve el caso.
* No duplicar lógica de submit/cancel dentro de otros dialogs personalizados.
* Si se necesita un formulario en modal/dialog, partir siempre de `crud-form-dialog.tsx`.
* Mantener consistencia de títulos, descripción, botones y manejo de loading según este componente.
* usar el componente resources\js\components\form-input-field.tsx para los inputs
* usar el componente resources\js\components\form-textarea-field.tsx para los textarea

### 2. Botones guardar fuera de dialog

Todo botón de guardado de formularios que esté fuera de un dialog debe usar siempre este componente:

`C:\laragon\www\base_laravel_react\resources\js\components\loading-submit-button.tsx`

Reglas:

* No usar botones submit manuales si el flujo es un formulario estándar fuera de dialog.
* Debe mostrar loading/spinner durante el envío.
* Debe bloquear doble submit.
* Debe mantener consistencia visual y de UX en todo el sistema.

### 3. Manejo de archivos

Para cualquier flujo relacionado con archivos, documentos, adjuntos, selección o asociación de archivos, usar siempre este componente:

`C:\laragon\www\base_laravel_react\resources\js\components\file-picker-dialog.tsx`

Reglas:

* No crear un file picker nuevo si este componente ya cubre el flujo.
* No crear una experiencia paralela para adjuntar archivos.
* Toda selección de archivos debe reutilizar este componente.
* Si hace falta adaptar comportamiento, extender la integración sin romper el patrón actual.

