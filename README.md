# intersys-prueba
Este proyecto es la solución a la prueba técnica para el puesto de desarrollador **Fullstack Junior** en LogiCorp. Consiste en un módulo interno para la administración del inventario de productos mediante componentes dinámicos y la generación automatizada de reportes ejecutivos en PDF utilizando procesamiento optimizado en la base de datos.

---

## 🛠️ Stack Tecnológico Utilizado

* **Backend:** Laravel 11 / PHP 8.3
* **Frontend:** Blade Templates + Bootstrap 5 + **jQuery** (interactividad total mediante peticiones AJAX)
* **Base de Datos:** MySQL
* **Generación de Reportes:** `barryvdh/laravel-dompdf`

---

## 🚀 Requisitos Previos

Asegúrate de contar con el siguiente entorno configurado de forma local antes de iniciar:
1. **PHP >= 8.2**
2. **Composer**
3. **Servidor MySQL** (a través de XAMPP, Laragon, Docker o de manera nativa)

---

## ⚙️ Instrucciones de Instalación Paso a Paso

Sigue esta secuencia de comandos en tu terminal para clonar, configurar y ejecutar el proyecto desde cero:
Instala todos los paquetes y dependencias del ecosistema del proyecto (incluido DomPDF):
composer install
composer require barryvdh/laravel-dompdf

2. Configurar el archivo de entorno
Copia la plantilla de ejemplo para inicializar tus variables de entorno esenciales:

Abrir el  archivo .env recién creado en tu editor de código. Localizar la sección de base de datos, asegúrate de retirar los símbolos de comentario # y ajusta los accesos correspondientes a tu servidor MySQL local:
Fragmento de código
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=logicorp_db
DB_USERNAME=root
DB_PASSWORD=

3. Crear la Base de Datos
Ingresar a; gestor de base de datos preferido (phpMyAdmin, TablePlus, DBeaver, etc.) y crea una base de datos vacía con el mismo nombre configurado en el archivo .env:
Nombre: logicorp_db

4. Inicializar la clave de seguridad
Genera la clave de encriptación única de Laravel requerida para el cifrado de cookies y sesiones de usuario:
php artisan key_generate

5. Ejecutar Migraciones y Poblar el Sistema (Seeders)
Este comando creará de forma automatizada toda la estructura de tablas y relaciones (categories, products, sales, sessions) y las poblará de inmediato con la data de prueba requerida (10 productos distribuidos en 3 categorías y 20 ventas ficticias ejecutadas de forma dinámica en el mes en curso):
php artisan migrate:fresh --seed

6. Iniciar el Servidor Local
Con toda la configuración lista, levanta el servidor local de desarrollo de Laravel:
php artisan serve

El sistema estará completamente operativo en tu navegador ingresando a la siguiente dirección:http://127.0.0.1:8000
