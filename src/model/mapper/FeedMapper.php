<?php
include_once(dirname(__FILE__)."/DBConnection.php");
include_once(dirname(__FILE__)."/NewPaperMapper.php");

class FeedMapper{
	private $connection;
	
	function __construct()
	{
		$this->connection = DBConnection::getInstance();
	}
	
	public function execute($query){
		$result = $this->connection->getPdo()->query($query);
		return $result;
	}
	
	public function insert($obj){
		$keys = array_values($obj::$columns);
		$query = implode(",", $keys);
		
		$data = Array(
				"'".utf8_encode($obj->getTitle())."'",
				"'".utf8_encode($obj->getDescription())."'",
				"'".utf8_encode($obj->getAutor())."'",
				"'".$obj->getDate()."'",
				"'".$obj->getLink()."'",
				"'".$obj->getIdExt()."'",
				$obj->getLikes(),
				$obj->getViews(),
				$obj->getNewsPaper()->getId()
				);
		$valuesAux = implode(",", $data);
		
		$sentence = $this->connection->getPdo()->prepare('INSERT INTO new ('.$query.') VALUES ('.$valuesAux.')');
		$sentence->execute();
		$obj->setId($this->lastInsertId());
		return $obj;
	}
	
	public function updateLikesAndViews($obj){
		
		$data = Array(
				"likes =".$obj->getLikes(),
				"views =".$obj->getViews()
		);
		$valuesAux = implode(",", $data);
		$sentence = $this->connection->getPdo()->prepare('UPDATE new SET '.$valuesAux.' WHERE id = '.$obj->getId());
		$sentence->execute();
	}
	
	public function select($columns,$conditions = ''){
		$result = Array();
		$newPaperMapper = new NewPaperMapper(); 
		
		$query = '';
		$keys = array_values($columns);
		$query = implode(",", $keys);
		$sentence = $this->connection->getPdo()->prepare("SELECT ".$query." FROM  new ".$conditions);
		 
		$sentence->execute();
		while ($fila = $sentence->fetch()) {
			$feed = new Feed();
			$feed->setId($fila["id"]);
			$feed->setTitle(utf8_decode($fila["title"]));
			
			$description = utf8_decode($fila["description"]);
			$shortDescription = "";
			if(strlen($description)>90){
				$shortDescription = substr($description, 0,90);
			}else{
				$shortDescription = $description;
			}
			$shortDescription .= '...';
			$feed->setDescription($shortDescription);
			$feed->setAutor(utf8_decode($fila["author"]));
			$feed->setDate($fila["date"]);
			$feed->setLink($fila["link"]);
			$feed->setIdExt($fila["id_ext"]);
			$feed->setLikes($fila["likes"]);
			$feed->setViews($fila["views"]);
			$feed->setNewsPaper($newPaperMapper->findById($fila["news_paper_id"]));
			
			array_push($result, $feed);
		}
		return $result;
	}
	
	public function deleteById($obj){
		$sentence = $this->connection->getPdo()->prepare('DELETE FROM new WHERE id = '.$obj->getId());
		$sentence->execute();
	}
	
	public function searchByText($text, $page = null){
		$result = Array();
		$columnsAux = Feed::$columns;
		$aColumns = array();
		foreach ($columnsAux as $value){
			array_push($aColumns, 'new.'.$value);
		}
		
		if ( $text != "" )
		{
			$text = utf8_encode($text);
			$sWhere = "WHERE ";
			$sWhere .= "(";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= "".$aColumns[$i]." LIKE '%".$text."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';

			array_push($columnsAux, Feed::$primaryKey);
			
			if($page != null){
				$pageNumber = ($page * 10);
				$sWhere .= "ORDER BY id ASC LIMIT ".$pageNumber.", 10";
			}
			$result = $this->select($columnsAux, $sWhere);
		}
		return $result;
	}
	
// 	public function findAllLikesIds(){
// 		$result = Array();

// 		$sentence = $this->connection->getPdo()->prepare("SELECT new_id FROM  likes ");
// 		$sentence->execute();
// 		while ($fila = $sentence->fetch()) {
// 			array_push($result, $fila["new_id"]);
// 		}
// 		return $result;
// 	}
	
// 	public function findAllViewsIds(){
// 		$result = Array();
		
// 		$sentence = $this->connection->getPdo()->prepare("SELECT new_id FROM  views ");
// 		$sentence->execute();
// 		while ($fila = $sentence->fetch()) {
// 			array_push($result, $fila["new_id"]);
// 		}
// 		return $result;
// 	}
	
	//elimina todas las noticias menos los que se encuentran en el arreglo.
	public function deleteOnlyLikeAndViewZero(){
		$sentence = $this->connection->getPdo()->prepare('DELETE new FROM new WHERE new.likes = 0 AND new.views = 0') ;
		$sentence->execute();
	}

    public function countTotal(){
        $sentence = $this->connection->getPdo()->prepare('SELECT COUNT(*) as total FROM new') ;
        $sentence->execute();
        $total=0;
        while ($fila = $sentence->fetch()) {
            $total = $fila["total"];
        }
        return $total;
    }

    public function countTotalByText($text){
        $text = utf8_encode($text);
        $sentence = $this->connection->getPdo()->prepare("SELECT
    COUNT(*) AS total
FROM
    new
WHERE (new.title LIKE '%$text%' OR new.description LIKE '%$text%' OR new.author LIKE '%$text%' OR new.date LIKE '%$text%' OR new.link LIKE '%$text%' OR new.id_ext LIKE '%$text%' OR new.likes LIKE '%$text%' OR new.views LIKE '%$text%' OR new.news_paper_id LIKE '%$text%' )") ;
        $sentence->execute();
        $total=0;
        while ($fila = $sentence->fetch()) {
            $total = $fila["total"];
        }
        return $total;
    }
	
	private function lastInsertId($name = NULL) {
		return $this->connection->getPdo()->lastInsertId($name);
	}
		
	
}