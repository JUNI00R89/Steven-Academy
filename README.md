# STEVEN ACADEMY

Sistema de Gestión Académica Web desarrollado para instituciones educativas.

![Node.js](https://img.shields.io/badge/Node.js-339933?style=for-the-badge&logo=node.js&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)

## 📋 Descripción

**STEVEN ACADEMY** es una plataforma web académica que permite gestionar estudiantes, registrar notas, manejar observaciones disciplinarias y organizar la información institucional de forma **segura, eficiente y centralizada**.

Este proyecto fue desarrollado como **Producto Integrador** para el curso de **Seguridad Informática** del SENA.

---

## ✨ Características Principales

- Autenticación segura con JWT
- Gestión de usuarios por roles (Administrador, Docente, Estudiante)
- Registro y consulta de notas académicas
- Registro de observaciones disciplinarias
- Control de acceso basado en roles (RBAC)
- Protección contra ataques comunes (SQL Injection, XSS, Fuerza Bruta)
- Soporte completo con **Docker** y **Docker Compose**
- Cumple con buenas prácticas de seguridad

---

## 🛠️ Tecnologías Utilizadas

- **Backend:** Node.js + Express
- **Base de Datos:** MySQL 8.0
- **Frontend:** HTML, CSS, JavaScript (EJS)
- **Autenticación:** JWT + bcrypt
- **Contenerización:** Docker + Docker Compose
- **Seguridad:** Helmet, Rate Limiting, Validación de datos

---

## 🚀 Instalación y Ejecución

### Opción Recomendada: Docker

```bash
# Clonar el repositorio
git clone https://github.com/tuusuario/steven-academy.git
cd steven-academy

# Levantar los contenedores
docker-compose up -d --build
La aplicación estará disponible en: http://localhost:3000

Opción Manual (sin Docker)
Instalar Node.js y MySQL
Crear la base de datos steven_academy
Copiar .env.example a .env y configurar las variables
Instalar dependencias:
Bash


Copy
npm install
Iniciar el servidor:
Bash


Copy
npm start
📁 Estructura del Proyecto
text


Copy
steven-academy/
├── src/
│   ├── controllers/
│   ├── routes/
│   ├── middleware/     # auth, validation, security
│   ├── config/
│   └── utils/
├── public/             # Archivos estáticos
├── views/              # Plantillas EJS
├── Dockerfile
├── docker-compose.yml
├── .env.example
├── .dockerignore
└── README.md
🔐 Seguridad
Este proyecto implementa múltiples capas de seguridad:

Contraseñas cifradas con bcrypt
Tokens JWT con expiración corta
Rate limiting
Validación y sanitización de entradas
Principio de mínimo privilegio
Política de contraseñas robusta
📋 Variables de Entorno
Copia el archivo .env.example a .env y configura:

DB_HOST, DB_USER, DB_PASSWORD
JWT_SECRET (¡cámbialo por una clave fuerte!)
NODE_ENV=production
🧪 Ambientes
Desarrollo: NODE_ENV=development
Producción: NODE_ENV=production
👨‍💻 Autor
Frank Junior Benítez Mosquera
Proyecto SENA - Seguridad Informática
📄 Licencia
Este proyecto es para fines educativos.