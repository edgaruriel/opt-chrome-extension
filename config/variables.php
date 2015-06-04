<?php
/**
* Declaracion de variables para la ubicacion del sistema y elementos iniciales
*
* @package configuracion
* @author Victor Hugo Menendez Dominguez <mdoming@uady.mx>
* @version 1.5
* @date 11/Abril/2009
**/

/**
* Nombre de la aplicacion
* @global string $aplicacion
*/
$aplicacion = 'optChromeExtension';

/**
* Sistema operativo (WINDOWS|UNIX|MAC)
* @global string $sistema_operativo
*/
$sistema_operativo = 'WINDOWS';

/**
* Directorio de instalacion de la aplicacion
* @global string $directorio_base
*/
$directorio_base = 'c:/xampp/htdocs/aplicacion/';

/**
* URL de la aplicacion
* @global string $url_base
*/
$url_base = 'http://localhost/optChromeExtension/';

/**
* Controlador por defecto
* @global string $controlador_predefinido
*/
$controlador_predefinido = 'index';

/**
* Accion por defecto
* @global string $accion_predefinida
*/
$accion_predefinida = 'index';

/**
* Extension del archivo del modelo
* @global string $modelo_extension
*/
$modelo_extension = 'Model.php';

/**
* Extension del archivo de la vista
* @global string $vista_extension
*/
$vista_extension = 'View.php';

/**
* Extension del archivo del controlador
* @global string $controlador_extension
*/
$controlador_extension = 'Controller.php';

?>