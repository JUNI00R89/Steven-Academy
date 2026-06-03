# STEVEN ACADEMY

Sistema de Gestión Académica Web desarrollado para instituciones educativas.

     ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
     ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
     ![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
     ![Apache](https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white)

## 📋 Descripción

**STEVEN ACADEMY** es una plataforma web académica que permite gestionar estudiantes, registrar notas, manejar observaciones disciplinarias y organizar la información institucional de forma **segura, eficiente y centralizada**.

Este proyecto fue desarrollado como **Producto Integrador** para el curso de **Seguridad Informática** del SENA.

---

## ✨ Características Principales

- Gestión completa de usuarios y roles (Administrador, Docente, Estudiante)
- Registro y consulta de notas académicas
- Control de observaciones disciplinarias
- Autenticación y autorización segura
- Protección contra vulnerabilidades comunes
- Despliegue fácil mediante Docker

---

## 🛠️ Tecnologías Utilizadas

- **Backend:** PHP 8.2 (principal)
- **Base de Datos:** MySQL 8.0
- **Servidor Web:** Apache
- **Frontend:** HTML, CSS, JavaScript
- **Autenticación:** PHP Sessions + `password_hash()`
- **Contenerización:** Docker + Docker Compose

*(Nota: Algunas funcionalidades adicionales pueden estar soportadas con Node.js en módulos específicos)*

---

## 🚀 Instalación y Ejecución

### Opción Recomendada: Docker

```bash
# 1. Clonar el repositorio
git clone https://github.com/tuusuario/steven-academy.git
cd steven-academy

# 2. Copiar archivo de entorno
cp .env.example .env

# 3. Levantar los contenedores
docker-compose up -d --build
La aplicación estará disponible en: http://localhost:8080

Opción Manual (sin Docker)
Instalar PHP 8.2+, Apache y MySQL (recomendado XAMPP o WAMP).
Crear la base de datos steven_academy.
Configurar el archivo .env.
Colocar el proyecto en la carpeta del servidor web.
Acceder mediante el navegador.
📁 Estructura del Proyecto
text


Copy
steven-academy/
├── src/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   └── config/
├── public/             # CSS, JS, imágenes
├── docker/
├── Dockerfile
├── docker-compose.yml
├── .env.example
├── .dockerignore
└── README.md
🔐 Seguridad
Este proyecto implementa buenas prácticas de seguridad:

Contraseñas cifradas con password_hash()
Uso de Prepared Statements contra SQL Injection
Control de acceso por roles (RBAC)
Variables de entorno protegidas
Política de contraseñas robusta
Principio de mínimo privilegio
📋 Variables de Entorno
Copia .env.example a .env y configura:

DB_HOST, DB_USER, DB_PASSWORD
APP_ENV=production
Claves de sesión y seguridad

👨‍💻 Autores

 *Hector Steven Cuesta

 *Frank Junior Benítez Mosquera

Proyecto desarrollado para el Servicio Nacional de Aprendizaje (SENA)

Curso: Seguridad Informática

📄 Licencia
Este proyecto es para fines educativos.

