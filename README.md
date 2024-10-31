# Reglas y Estándares de Desarrollo

Este proyecto sigue una serie de estándares y convenciones con el objetivo de garantizar la calidad, consistencia y mantenibilidad del código. Todos los desarrolladores que trabajen en este repositorio deberán seguir las pautas aquí descritas.

## Convencion de nombres (variables y clases)

## Convencion de tablas

## Indentación

El código utiliza una indentación consistente de **4 espacios por nivel**. Esto es un estándar común en PHP y en muchos otros lenguajes de programación, y mejora la legibilidad del código al mantener una estructura clara y fácil de seguir.

## Paradigma de Programación

- **Programación Orientada a Objetos (POO)**: Se implementa el paradigma POO para estructurar el código de manera modular y reutilizable.
- **Arquitectura MVC**: El proyecto sigue el patrón de diseño **Modelo-Vista-Controlador (MVC)**, lo cual facilita la separación de responsabilidades y mejora la escalabilidad.

## Principios de Diseño

Se aplican los siguientes principios de diseño en el desarrollo de este proyecto:

- **Separación de Responsabilidades (Separation of Concerns)**: Cada módulo o componente del sistema tiene una única responsabilidad específica.
- **Responsabilidad Única (Single Responsibility Principle)**: Cada clase o función está diseñada para cumplir una sola función.
- **No Repetir Código (DRY - Don't Repeat Yourself)**: Se evita la duplicación de código, promoviendo su reutilización.

## Flujo de Trabajo

El proyecto sigue la metodología **Gitflow** para el manejo de ramas y control de versiones. Esto permite un desarrollo organizado y facilita la colaboración en equipo.

### Convenciones de Ramas

- **Ramas basadas en el trabajo realizado**:
  - `feature/nombre`: Para nuevas funcionalidades.
  - `fix/nombre`: Para correcciones de errores.
  - `test/nombre`: Para agregar o modificar pruebas.
  - `release/nombre`: Para preparar nuevas versiones.

### Convención de Commits

Los mensajes de commit deben seguir el formato: `tipo(scope): mensaje`
Ejemplos:

- `feat(shopping cart): add the amazing button`
- `fix(user authentication): correct token generation bug`

## Reglas de Pull Request

- Todo merge debe realizarse mediante un **Pull Request (PR)** y debe ser revisado antes de su integración.
- No se permiten merges directos a la rama `main`, con el objetivo de mantener la integridad y estabilidad de la rama principal.

## Convención de Nombres para Bases de Datos

Las bases de datos utilizadas en el proyecto deben seguir la convención de incluir el prefijo **"restaurante"** en su nombre, para mantener un esquema uniforme y organizado.
