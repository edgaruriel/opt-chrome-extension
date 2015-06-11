<?php
include_once(dirname(__FILE__)."/../../library/simplepie/autoloader.php");
include_once(dirname(__FILE__)."/../services/DateFormat.php");
include_once(dirname(__FILE__)."/../services/FeedService.php");

class FeedController{
	
	//son todas las noticias filtradas por el tipo de periodico o sección y el número
	// de bloque para la página
	function action_findByNewsPaper(){
		
	}
	
	// todas las noticias filtradas unicamente por bloques de 5 noticias
	function action_findNextPage(){
		$feedService = new FeedService();
		$page = $_REQUEST['page'];
		
		//sanitize post value
		$groupNumber = filter_var($page, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		
		//throw HTTP error if group number is not valid
		if(!is_numeric($groupNumber)){
			header('HTTP/1.1 500 Invalid number!');
			exit();
		}
		$feeds = $feedService->getAllFeedFromDB($groupNumber);
		print("<pre>".print_r($feeds,true)."</pre>");
		exit();
	}
	
	
	// método que encuentra coicidencias dentro de la noticia y con la opción de 
	// paginar las noticias
	function action_searchByText(){
		$feedService = new FeedService();
		$text = $_REQUEST['text'];
		
		$feeds = Array();
		if(isset($_REQUEST['page'])){
			$feeds = $feedService->searchFeedByText($text,$_REQUEST['page']);
		}else{
			$feeds = $feedService->searchFeedByText($text);
		}
		
		print("<pre>".print_r($feeds,true)."</pre>");
		echo "termino";
		exit();
	}
	
	//son todas las noticias de la base de datos
	function action_refresh(){
		$feedService = new FeedService();
		$feeds = $feedService->getAllFeedFromDB();
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
