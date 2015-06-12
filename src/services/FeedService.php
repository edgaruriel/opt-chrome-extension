<?php
include_once(dirname(__FILE__)."/../model/mapper/FeedMapper.php");
include_once(dirname(__FILE__)."/../model/Feed.php");
include_once(dirname(__FILE__)."/../config/Config.php");
include_once(dirname(__FILE__)."/NewPaperService.php");

class FeedService{
	
	//toma los que ya se encuentran en la Base de datos
	// $page: es el n�mero de pagina o bloque de pagina que despliega, puede ser bloques de
	// 10 en 10 o de cualquier otro 
	public function getAllFeedFromDB($page = null){
		$feedMapper = new FeedMapper();
		
		$columns = Feed::$columns;
		array_push($columns, Feed::$primaryKey);
		if($page != null){
			$pageNumber = ($page * 10);
			$condition = "ORDER BY id ASC LIMIT ".$pageNumber.", 10";
			return $feedMapper->select($columns, $condition);
		}else{
			return $feedMapper->select($columns);
		}
	}
	
	// consulta nuevamente todos los feeds y actualiza la Base de datos, eliminando
	// los que nunca les dieron like o vistas
	public function updateFeeds(){
		$feedMapper = new FeedMapper();
		
		$this->deleteFeeds();
		$feedsFromDB = $this->getAllFeedFromDB();
		$feeds = $this->getFeedsFromUrl();
		
		$feedNews = $this->filterNotAdd($feedsFromDB, $feeds);
		foreach ($feedNews as $feed){
			$feedMapper->insert($feed);
		}
		return true;
	}
	
	public function updateLikes($feedId){
		$feedMapper = new FeedMapper();
		
		$condition = "WHERE new.id = ".$feedId;
		$columns = Feed::$columns;
		array_push($columns, Feed::$primaryKey);
		$feedArray = $feedMapper->select($columns,$condition);
		$feed = $feedArray[0];
		
		$likes = $feed->getLikes();
		$likes += 1;
		$feed->setLikes($likes);
		
		$feedMapper->update($feed);
	}
	
	public function updateViews($feedId){
		$feedMapper = new FeedMapper();
		
		$condition = "WHERE new.id = ".$feedId;
		$columns = Feed::$columns;
		array_push($columns, Feed::$primaryKey);
		$feedArray = $feedMapper->select($columns,$condition);
		$feed = $feedArray[0];
		
		$views = $feed->getViews();
		$views += 1;
		$feed->setViews($views);
		
		$feedMapper->update($feed);
	}
	
	// m�todo par filtrar las noticias por un texto enviado
	public function searchFeedByText($text, $page = null){
		$feedMapper = new FeedMapper();
		
		if($page != null){
		return	$feedMapper->searchByText($text, $page);
		}else{
		return	$feedMapper->searchByText($text);
		}
		 
	}
	
	// ordenar los feeds por varias condiciones
	public function orderFeedsArray($arrayFeeds){
		
	}
	
	//toma todo los feeds de la configuraci�n
	private function getFeedsFromUrl(){
		$newPaperService = new NewPaperService();
		$urls = Config::getInstance()->getConfigFeeds();
		
		$news = Array();
		foreach ($urls as $index => $url){
			$feed = new SimplePie();
			$feed->set_feed_url($url);
			$feed->enable_cache(false);
			
			$feed->init();
			
			$items = $feed->get_items();
			
			$idNewPaper = $index +1;
			foreach($items as $item){
				$feed = new Feed();
				$feed->setTitle($item->get_title());
				$feed->setAutor($item->get_author()->get_name());
				$feed->setDescription($item->get_description());
				$feed->setDate($item->get_date('Y-m-d H:i:s'));
				$feed->setLink($item->get_link());
				$feed->setIdExt($item->get_id(true));
				$feed->setLikes(0);
				$feed->setViews(0);
				$feed->setNewsPaper($newPaperService->findOneById($idNewPaper));
				array_push($news, $feed);
			}
		}
		return $news;
	}
	
	//elimina todos los feeds de la BD que no tiene ningun like o view
	// tomar a todos los like,views y eliminar todas las noticias menos los que tiene
	// almenos un registro de estos.
	private function deleteFeeds(){
		$feedMapper = new FeedMapper();
		$feedMapper->deleteOnlyLikeAndViewZero();
	}
	
	private function filterNotAdd($feedDB, $feedNews){
		$feedToAdd = Array();
		foreach ($feedNews as $feed){
			$flag = false;
			foreach ($feedDB as $feedAux){
				if($feed->getIdExt() == $feedAux->getIdExt()){
					$flag = true;
					break;
				}
			}
			
			if(!$flag){
				array_push($feedToAdd, $feed);
			}
			
		}
		return $feedToAdd;
	}

    public function countFeeds(){
        $feedMapper = new FeedMapper();
        return $feedMapper->countTotal();
    }

    public function countFeedsByText($text){
        $feedMapper = new FeedMapper();
        return $feedMapper->countTotalByText($text);
    }
	
}