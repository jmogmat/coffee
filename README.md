# ☕ Coffee – Proyecto de Demostración con Vue 3 + Symfony

**Coffee** es una aplicación web fullstack en desarrollo, construida con [Vue 3](https://vuejs.org/) en el frontend y [Symfony](https://symfony.com/) en el backend, usando PHP 8.2. Está diseñada como un proyecto de muestra personal, con el objetivo de integrar tecnologías modernas en un solo stack, sin separar frontend y backend.

Este repositorio tiene fines educativos y curriculares, y está pensado para ilustrar una arquitectura completa de aplicación web de tipo monolito, con un enfoque moderno.

Actualmente el proyecto se encuentra en desarrollo, con actualizaciones semanales, aunque con pequeños cambios ya que me encuentro haciendo otras tareas y otros proyectos independientes a este en cuestión.

---

## 🚀 Estado del Proyecto

Actualmente implementado:

- Registro de usuarios con envío de correo de confirmación.
- Autenticación de usuarios (login funcional).
- Envío de correos a través de [Mailtrap](https://mailtrap.io/), con enlaces de activación embebidos.
- Configuración local con **Nginx**, sirviendo desde `http://coffee.localhost`.
- Integración con Bootstrap 5 y SassCSS para el diseño.
- Única entidad: `User`.

---

## 🧱 Tecnologías Utilizadas

### Frontend
- **Vue 3** con Composition API
- **Pinia** (instalado, sin uso de momento)
- **SassCSS**
- **Bootstrap 5**

### Backend
- **Symfony**
- **PHP 8.2**
- **Twig** (como motor de plantillas)

### Infraestructura
- **Nginx** como servidor web
- **Mailtrap** para pruebas de email
- Configuración en archivo `hosts` apuntando a `coffee.localhost`

---

## 📁 Estructura del Repositorio

El proyecto está desarrollado como **monorepo**, es decir, frontend y backend comparten el mismo repositorio. Esto simplifica el despliegue y la configuración local durante la fase de aprendizaje.

---

## ⚙️ Requisitos

- Node.js `v22.4.0`
- PHP `8.2`
- Composer
- Nginx
- Yarn o npm (usamos npm)
- Mailtrap account (para pruebas de correo)

---

## 🧪 Cómo ejecutar en local

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/jmogmat/coffee.git
   cd coffee
