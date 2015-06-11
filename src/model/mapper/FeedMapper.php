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
				"'".$obj->getTitle()."'",
				"'".$obj->getDescription()."'",
				"'".$obj->getAutor()."'",
				"'".$obj->getDate()."'",
				"'".$obj->getLink()."'",
				"'".$obj->getIdExt()."'",
				$obj->getNewsPaper()->getId()
				);
		$valuesAux = implode(",", $data);
		
		$sentence = $this->connection->getPdo()->prepare('INSERT INTO new ('.$query.') VALUES ('.$valuesAux.')');
		$sentence->execute();
		$obj->setId($this->lastInsertId());
		return $obj;
	}
	
	public function update($obj){
		$keys = array_values($obj::columns);
		$query = implode(",", $keys);
		
		$data = Array(
				$obj->getTitle(),
				$obj->getDescription(),
				$obj->getAutor(),
				$obj->getDate(),
				$obj->getNewsPaper()->getId()
		);
		$valuesAux = implode(",", $data);
		
		$query = implode(",", $valuesAux);
		$sentence = $this->connection->getPdo()->prepare('UPDATE new SET '.$query.' WHERE id = '.$obj->getId());
		$sentence->execute();
		return $this->lastInsertId();
	}
	
	public function select($columns,$conditions = ''){
		$result = Array();
		$newPaperMapper = new NewPaperMapper(); 
		
		$query = '';
		$keys = array_values($columns);
		$query = implode(",", $keys);
// 		if($conditions != ''){
// 			$conditions = 'WHERE '.$conditions;
// 		}
		$sentence = $this->connection->getPdo()->prepare("SELECT ".$query." FROM  new ".$conditions);
		 
		$sentence->execute();
		while ($fila = $sentence->fetch()) {
			$feed = new Feed();
			$feed->setId($fila["id"]);
			$feed->setTitle($fila["title"]);
			$feed->setDescription($fila["description"]);
			$feed->setAutor($fila["author"]);
			$feed->setDate($fila["date"]);
			$feed->setLink($fila["link"]);
			$feed->setIdExt($fila["id_ext"]);
			$feed->setNewsPaper($newPaperMapper->findById($fila["news_paper_id"]));
			
			array_push($result, $feed);
		}
		return $result;
	}
	
	public function deleteById($obj){
		$sentence = $this->connection->getPdo()->prepare('DELETE FROM new WHERE id = '.$obj->getId());
		$sentence->execute();
	}
	
	public function findAllLikesIds(){
		$result = Array();
		
		$sentence = $this->connection->getPdo()->prepare("SELECT new_id FROM  likes ");
		$sentence->execute();
		while ($fila = $sentence->fetch()) {
			array_push($result, $fila["new_id"]);
		}
		return $result;
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
				$pageNumber = ($page * 5);
				$sWhere .= "ORDER BY id ASC LIMIT ".$pageNumber.", 5";
			}
			$result = $this->select($columnsAux, $sWhere);
		}
		return $result;
	}
	
	public function findOneLikeByNewId(){
		
	}
	
	public function findOneViewByNewId(){
		
	}
	
	public function findAllViewsIds(){
		$result = Array();
		
		$sentence = $this->connection->getPdo()->prepare("SELECT new_id FROM  views ");
		$sentence->execute();
		while ($fila = $sentence->fetch()) {
			array_push($result, $fila["new_id"]);
		}
		return $result;
	}
	
	//elimina todas las noticias menos los que se encuentran en el arreglo.
	public function deleteOnlyLikeAndViewZero($arrayIds){
		$ids = implode(",",array_unique($arrayIds));
		$sentence = $this->connection->getPdo()->prepare('DELETE new FROM new WHERE new.id NOT IN ('.$ids.')');
		$sentence->execute();
	}
	
	private function lastInsertId($name = NULL) {
		return $this->connection->getPdo()->lastInsertId($name);
	}
		
	
}