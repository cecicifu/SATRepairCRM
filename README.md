# SATRepairCRM
> Este proyecto será un CRM (Customer relationship management), que constará de un panel BackOffice donde se podrá gestionar todo el
> sistema (usuarios, reparaciones, estados, clientes, productos y categorías), y 
> un FrontOffice muy sencillo que solo constará de un pequeño campo donde los clientes podrán
> introducir el número de seguimiento de su reparación para consultar el estado.
> El objetivo es que este proyecto pueda avanzar tanto que en un futuro consiga ser también un ERP (Enterprise Resource Planning) como Odoo

*Los elementos **opcionales** dependerán de las necesidades y el tiempo de desarrollo del proyecto.*

*Las librerías usadas no deberán ser estrictamente las descritas abajo, podrían variar entre otras alternativas dependiendo del rendimiento, peso y uso en la aplicación.*

## Diseño
-  ERD: *Entity-Relationship Diagram* para el diseño conceptual de la base de datos.
-  CD / OD: *Class Diagram* / *Object Diagram* para el diseño conceptual de la aplicación.
-  UCD: *Use Case Diagram* para el diseño funcional de la aplicación.

## Desarrollo
### Frontend
- HTML5: etiquetas semánticas (https://www.w3schools.com/html/html5_semantic_elements.asp).
- Javascript:
	- NPM: gestor de paquetes (https://www.npmjs.com/).
	- Axios: peticiones ajax (con CORS).
	- Dayjs: formateo de fechas y horas (https://github.com/iamkun/dayjs).
	- Datatable: tablas avanzadas.
	- Select2: selects con busquedas y filtros.
	- Fontawesome / Google Icons (https://fontawesome.com/ || https://fonts.google.com/icons/).
	- **(opcional)** Pace: loadings avanzados.
	- **(opcional)** Icheck: checkboxes y radio-buttons mejorados.
	- **(opcional)** Tippy: tooltips con mejor estética. (En este caso se incluiría con su motor **popper**)
	- **(opcional)** Ckeditor: textarea avanzados y con markdown.
	- **(opcional)** Toastr / Bootbox: alerts y ventanas avanzadas.
	- **(opcional)** Chart / Highcharts / Morris / Raphael: gráficos avanzados. 
		!Important [En principio no se incluirán gráficos en este proyecto, no está dentro del "main scope"]
	
- CSS:
	- **(opcional)** Tailwind: framework (https://tailwindcss.com/).
	- **(opcional)** sass / scss / stylus: preprocesador.

- JSON: formato principal para las peticiones. Cumpliendo con la JSONAPI (https://jsonapi.org/).
- Webpack: bundler (https://webpack.js.org/).
	
### Backend
- PHP (Versión +7.4): Symfony, Laravel o Vanilla. Todavía está por decidir.

	Orientación a objetos y principios "SOLID":
	- **(opcional)** Arquitectura Hexagonal (Estructura y composición de nuestra aplicación, es más escalable que MVC) (https://miro.medium.com/max/1718/1*yR4C1B-YfMh5zqpbHzTyag.png).
	- **(opcional)** DDD (Domain Drive Design) (https://leer.amazon.es/kp/embed?asin=B06ZYRPHMC&preview=newtab&linkCode=kpe&ref_=cm_sw_r_kb_dp_N8NY4MGSQPBKC0DJX1H8).
	- Microservicios y / o Eventos.
	- PDO (Permite el uso de diferentes drivers de bases de datos).
	- Otros patrones de diseño (repository, decorator, etc..).
			
	Seguridad:

	- Tokens (Comprobación de token autogenerado en todos los formularios, previene de ataques CSRF).
	- STMT (Sentencias preparadas, previene de injecciones SQL y rollbacks en caso de error).
	- Filters y sanitizes de los campos enviados por POST / GET.
	- Encriptación de contraseñas con algoritmos avanzados.
	- **(opcional)** Logger (Librerías como *Monolog* para saber que pasa en nuestra aplicación en todo momento) (https://github.com/Seldaek/monolog).
		
	**(opcional)** Twig: motor de plantilla (https://twig.symfony.com/).

	Composer: gestor de dependencias (https://getcomposer.org/).
		
	PSR-4: autoload de clases (Estándares PHP) (https://www.php-fig.org/).

	Faker: generar datos falsos (https://github.com/FakerPHP/Faker). 
	
- **(opcional)** AMQP: RabbitMQ, gestionar colas de mensajes.
- Apache (**opcional**: Nginx).
- MySQL: Siguiendo la metodología de algunos ejemplos de Microsoft SQL Server (http://www.wilsonmar.com/sql_adventureworks.htm).

## Pruebas
- Unit Test: partes individuales de la aplicación. Ej: (https://pestphp.com/).
- Integration Test: toda la aplicación o grandes conjuntos de ella.
- **(opcional)** Mutantion Testing: modifica nuestros test cambiando valores y condicionales para mejorar el coverage y reliability de nuestra aplicación (https://github.com/infection/infection).

## Análisis
- Test de accesibilidad.
	  https://www.w3.org/WAI/ER/tools/
	  https://wave.webaim.org/
- Tests de velocidad y rendimiento.

## Despliegue
- Host: VPS en [OVH](https://www.ovh.es/) o [Heroku](https://www.heroku.com/).
- Dominio: [Namecheap](https://www.namecheap.com/) o [Name](https://www.name.com/).
- **(opcional)** CDN: [Cloudflare](https://www.cloudflare.com/).
- **(opcional)** SSL: [Letsencrypt](https://letsencrypt.org/).

## Herramientas
- PhpStorm (IDE principal).
- VSCode (Editor de código).
- Laragon (Entorno de desarrollo).
- Filezilla (FTP).
- Postman (Peticiones HTTP para testeo de APIs).
- PuTTY (SSH).
- HeidiSQL (Interfaz gráfica para gestión de SQL).
- MySQL Workbench (Interfaz gráfico para gestión y diseño de MySQL).
- Git (Control de versión).
- Github (Repositorio del proyecto).
- Trello (Gestión de tareas).
- Google Chrome / Mozilla Firefox (Extensiones: *Wappalyzer*, *ColorZilla*, *Grid Ruler*, *JSON Formatter*). 
- Photoshop / https://bulkresizephotos.com (Edición y optimización de imágenes).