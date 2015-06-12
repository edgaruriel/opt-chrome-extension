<?php
include_once(dirname(__FILE__)."/../../library/simplepie/autoloader.php");
include_once(dirname(__FILE__)."/../services/DateFormat.php");
include_once(dirname(__FILE__)."/../services/FeedService.php");

class FeedController{
	
	//son todas las noticias filtradas por el tipo de periodico o secci�n y el n�mero
	// de bloque para la p�gina
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
		
		$feeds = Array();
		if(isset($_REQUEST['filterBy'])){
			$filter = $_REQUEST['filterBy'];
			$filter .= " DESC ";
			$feeds = $feedService->getAllFeedFromDB($groupNumber, $filter);
		}else{
			$feeds = $feedService->getAllFeedFromDB($groupNumber);
		}
		
		
		echo json_encode($feeds);
	}
	
	
	// m�todo que encuentra coicidencias dentro de la noticia y con la opci�n de 
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

        echo json_encode($feeds);
	}

    function action_countTotal(){
        $feedService = new FeedService();
        $total = $feedService->countFeeds();
        //$value = round($total/10, 0, PHP_ROUND_HALF_DOWN);
        $value = floor($total/10);
        echo json_encode($value);
    }

    function action_countTotalByText(){
        $feedService = new FeedService();
        $total = $feedService->countFeedsByText($_REQUEST['text']);
        //$value = round($total/10, 0, PHP_ROUND_HALF_DOWN);
        $value = floor($total/10);
        echo json_encode($value);
    }
	
	//son todas las noticias de la base de datos
	function action_refresh(){
		$feedService = new FeedService();
		$feeds = $feedService->getAllFeedFromDB();
		echo json_encode($feeds);
	}
	
	function action_updateLikes(){
		$feedId = $_REQUEST['feedId'];
		$feedService = new FeedService();
		$feedService->updateLikes($feedId);
	}
	
	function action_updateViews(){
		$feedId = $_REQUEST['feedId'];
		$feedService = new FeedService();
		$feedService->updateViews($feedId);
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
