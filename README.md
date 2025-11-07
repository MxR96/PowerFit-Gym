Descripción del Proyecto

Gym PowerFit es una aplicación web desarrollada con PHP, MySQL, Bootstrap y JavaScript, orientada a la gestión de usuarios, reservas y planes dentro de un gimnasio.
Permite el registro de clientes, inicio de sesión seguro, interacción con un chatbot y un panel de administración exclusivo para usuarios autorizados.

Es un proyecto académico que aplica correctamente las buenas prácticas de seguridad, arquitectura web, diseño responsive y manejo de base de datos.

Funcionalidades Principales

Registro de usuarios con contraseñas encriptadas

Inicio de sesión seguro utilizando sesiones PHP

Control de acceso por roles (Administrador / Cliente)

Panel Administrativo con operaciones CRUD

Sistema de reservas e inscripciones

Perfil del usuario conectado a la base de datos

Chatbot con AJAX disponible solo para usuarios logueados

Diseño responsive mediante Bootstrap 5

Validación de formularios (frontend + backend)


Seguridad Implementada

password_hash()	Encriptación de contraseñas

password_verify()	Validación segura en login

PDO + Prepared Statements	Prevención de SQL Injection

Control de Sesiones	Bloqueo de acceso sin autenticación

Roles en servidor	Protección extra en rutas administrativas

La aplicación no expone datos sensibles en texto plano y controla accesos en servidor, no solo en la interfaz.

Tecnologías Utilizadas

Lenguaje Backend	PHP 8+

Base de Datos	MySQL

Conexión a BD	PDO (PHP Data Objects)

Frontend	HTML5, CSS3, Bootstrap 5

Scripts y lógica dinámica	JavaScript + AJAX (Fetch API)

Servidor Web (local)	XAMPP / WAMP


Estructura del Proyecto

/config          → conexión a la base de datos

/includes        → navbar, header, footer reutilizables

/public          → páginas principales del sitio

/sql             → script SQL de la base de datos

/assets          → estilos, JS, multimedia


Instalación y Uso

1️⃣ Clonar este repositorio
git clone https://github.com/usuario/powerfit-gym.git

2️⃣ Importar la base de datos desde /sql/gym_powerfit.sql en phpMyAdmin

3️⃣ Configurar credenciales en:
config/conexion.php

4️⃣ Iniciar servidor Apache + MySQL

5️⃣ Abrir en el navegador:
http://localhost/powerfit-gym/public/

Roles y Accesos

Cliente	| Contenido general	Reservas, inscripción, chatbot

Administrador |	Panel de gestión	CRUD de usuarios y reservas
