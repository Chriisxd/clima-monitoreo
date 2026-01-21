<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---------------------------------------------------------------------------------------
# Sistema de Monitoreo Climático en Tiempo Real

## Descripción
Aplicación web desarrollada en **Laravel** que permite consultar, almacenar, actualizar y eliminar datos de clima en tiempo real utilizando la API de **OpenWeatherMap**

---------------------------------------------------------------------------------------

## Instalación y Despliegue Paso a Paso

1. Clonar el repositorio desde GitHub (cuenta con su respectivo 
historial de commits).

2. Instalar las dependencias de backend con composer install.

3. Instalar dependencias de frontend con npm install.

4. Crear un archivo .env con la configuración de la base de datos:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clima
DB_USERNAME=root
DB_PASSWORD=

5. Instalación de Breeze y todos sus componentes (en este caso no se utilizó Livewire 
para el frontend, pero en su lugar se utilizó otra tecnología como Bootstrap)

## CLAVE API KEY UTILIZADA
OPENWEATHER_API_KEY=afe53cf9953843e8bbb2b2e885c97f41

* php artisan key:generate (Generar clave)
* php artisan migrate (Ejecutar migraciones para crear tablas)
* php artisan serve (Levantar servidor)

6. Acceder a la aplicación en http://127.0.0.1:8000/.
7. Crear un usuario desde la pantalla de registro.
8. Ingresar con el usuario registrado para acceder al sistema.

## Funcionalidades
Consulta de clima en tiempo real usando la API de OpenWeatherMap.
CRUD de climas: crear, actualizar y eliminar.
Visualización de temperatura en °C y °F.
Fecha de consulta mostrando solo el día.
Autenticación de usuarios (registro, login, logout).
Auditoría de acciones: logs al actualizar o eliminar climas, indicando usuario, ciudad y clima afectado.

## API
La aplicación utiliza la API de OpenWeatherMap para obtener los datos de clima.
La aplicación utiliza la API de Laravel para interactuar con la base de datos.

## Base de datos

La aplicación utiliza MySQL para almacenar los datos de clima.
Las tablas se crean mediante migraciones.
Modelo principal: Clima.

## Servicios
WeatherService → Interactúa con la API de OpenWeatherMap.

## Explicación de Diseño
* Se utilizó la arquitectura Modelo-Vista-Controlador (MVC) de Laravel.
Vistas presentan la información al usuario y manejan la interfaz con Bootstrap.

* Separación de responsabilidades y SOLID
La lógica de consulta a la API de clima se encapsula en el servicio WeatherService.

* Gestión de usuarios y seguridad. Se implementó autenticación completa con registro, login y logout. Solo usuarios autenticados pueden crear, actualizar o eliminar climas.

* Los logs de auditoría registran qué usuario realizó cada acción, aumentando la trazabilidad,optimización y performance

* Se utiliza caché con Laravel para almacenar temporalmente los datos de la API y reducir llamadas repetidas.

Se aplicaron accessors en el modelo Clima para calcular automáticamente la temperatura en Fahrenheit.

* Frontend y usabilidad se utilizó Bootstrap para una interfaz limpia y responsive.

* Se definieron colores distintos para botones según la acción: azul para actualizar, rojo para eliminar, etc. Se muestra solo la fecha en la tabla de consultas para mayor claridad.

* Auditoría y logs. Se registran logs informativos al actualizar o eliminar climas, incluyendo usuario, ciudad y clima afectado.

## Compatibilidad

Laravel 8.x
PHP 7.4+
MySQL 8.x
Bootstrap 5.x

## Evaluación dos puntos mas
1. Se utilizo algunas validaciones JavaScript
no en su totalida, aun con Blade, en:
Envio de formularios Vacios como:
* Buscar ciudad
* Agregar coemntarios vacios
* Eliminar, actualizar y guardar.

2. Se aumento CRUD a los comentarios por cada registro
con:
* Editar, eliminar y confirmación para guardar.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
