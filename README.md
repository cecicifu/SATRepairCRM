# SATRepairCRM
> Este proyecto constará de un panel BackOffice donde se podrá gestionar todo el
> sistema (usuarios, reparaciones, estados, clientes, productos y categorías), y 
> un FrontOffice muy sencillo que solo constará de un pequeño campo donde los clientes podrán
> introducir el número de seguimiento de su reparación para consultar el estado.

## Frontend:
- HTML5: etiquetas semánticas (https://www.w3schools.com/html/html5_semantic_elements.asp).
- Javascript:
	- NPM: gestor de paquetes (https://www.npmjs.com/).
	- Axios: peticiones ajax (con CORS).
	- Momentjs: formateo de fechas y horas.
	- Datatable: tablas avanzadas.
	- select2: selects con busquedas y filtros.
	- Fontawesome/Google Icons (https://fontawesome.com/ || https://fonts.google.com/icons/).
	- (opcional) pacejs: loadings avanzados.
	- (opcional) icheck: checkbox y radio-buttons mejorados.
	- (opcional) ckeditor: textarea avanzados y con markdown.
	- (opcional) toastr/bootbox: alerts y ventanas avanzadas.
	- (opcional) chartjs/highcharts/morris/raphael: gráficos avanzados. 
			!Important [En principio no se incluirán gráficos en este proyecto, no está dentro del "main scope"]
	
- CSS:
	- (opcional) Tailwind: framework (https://tailwindcss.com/).
	- (opcional) sass/scss/stylus: preprocesador.

	- JSON: como formato principal para las peticiones cumpliendo con la JSONAPI (https://jsonapi.org/).
	- Webpack: como bundler (https://webpack.js.org/).
	
## Backend:
- PHP (Versión +7.4): Será vanilla, no se usará ningún framework.

    Orientación a objetos y principios "SOLID":
	- Arquitectura Hexagonal (Estructura y composición de nuestra aplicación, es más escalable de MVC) (https://miro.medium.com/max/1718/1*yR4C1B-YfMh5zqpbHzTyag.png).
	- DDD (Domain Drive Design) (https://leer.amazon.es/kp/embed?asin=B06ZYRPHMC&preview=newtab&linkCode=kpe&ref_=cm_sw_r_kb_dp_N8NY4MGSQPBKC0DJX1H8).
	- TDD (Test Unitarios e Integración).
	- Microservicios y/o Eventos.
	- PDO (Permite el uso de diferentes drivers de bases de datos).
	- Y otros patrones de diseño (repository, decorator, etc..).
			
	Seguridad:

	- Tokens (comprobación de token autogenerado en todos los formularios, previene de ataques CSRF).
	- STMT (Sentencias preparadas, previene de injecciones SQL).
	- Filters y sanitazes de los campos enviados por POST/GET.
	- Encriptación de contraseñas con algoritmos avanzados.
		
	(opcional) Twig: motor de plantillas (https://twig.symfony.com/).

	Composer: gestor de dependencias (https://getcomposer.org/).
		
	PSR: Autoloading de clases (https://www.php-fig.org/psr/).
	
- (opcional) RabbitMQ: gestionar colas y eventos.
- Apache (opcional: Nginx).
- MySQL (Incluído UML): La construcción de la base de datos seguirá la metodología de algunos
	c  ejemplos de Microsoft SQL Server (http://www.wilsonmar.com/sql_adventureworks.htm).
	
## Para finalizar:
- Test de accesibilidad.
	  https://www.w3.org/WAI/ER/tools/
	  https://wave.webaim.org/
		
** Los elementos opcionales dependerán de las necesidades y el tiempo de desarrollo del proyecto.

Herramientas que se usarán:
- PhpStorm (IDE principal).
- VSCode. (Editor de código secundario).
- Laragon (entorno de desarrollo).
- Filezilla (FTP).
- Postman (Peticiones HTTP).
- PuTTY (SSH).
- HeidiSQL.
- MySQL Workbench.
- Git.
- Trello.
- Google Chrome / Mozilla Firefox.
- Photoshop / https://bulkresizephotos.com.