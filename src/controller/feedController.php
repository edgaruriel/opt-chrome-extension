<?php
include_once(dirname(__FILE__)."/../../library/simplepie/autoloader.php");
include_once(dirname(__FILE__)."/../services/DateFormat.php");
include_once(dirname(__FILE__)."/../services/FeedService.php");

class FeedController{
	
	//son todas las noticias filtradas por el tipo de periodico o sección y el número
	// de bloque para la página
	function action_findByNewsPaper(){
		
	}
	
	function action_findNextPage(){
		$page = $_REQUEST['page'];
		
	}
	
	//son todas las noticias de la base de datos
	function action_refresh(){
		$feedService = new FeedService();
		$feeds = $feedService->getAllDB();
		print("<pre>".print_r($feeds,true)."</pre>");
		exit();
		echo json_encode($feeds);
	}
	
	// Borra las noticas de la base de datos que no tenga ningun like o view y agrega
	// las nuevas noticas, regresa de todas las secciones
	function action_updateFeeds(){
		$feedService = new FeedService();
		$result = $feedService->updateFeeds();
		
		if($result){
			echo "TODO BIEN!!";
		}else{
			echo "ERROR";
		}
		exit();
	}
	
}
