<?php
include_once(dirname(__FILE__)."/DBConnection.php");
include_once(dirname(__FILE__)."/../NewPaper.php");

class NewPaperMapper{
	private $connection;
	
	function __construct()
	{
		$this->connection = DBConnection::getInstance();
	}
	
	public function execute($query){
		$result = $this->connection->getPdo()->query($query);
		return $result;
	}
	
	public function select($columns,$conditions = ''){
		$result = Array();
			
		$query = '';
		$keys = array_values($columns);
		$query = implode(",", $keys);
		if($conditions != ''){
			$conditions = 'WHERE '.$conditions;
		}
		$sentence = $this->connection->getPdo()->prepare("SELECT ".$query." FROM news_paper ".$conditions);
			
		$sentence->execute();
		while ($fila = $sentence->fetch()) {
			 $newPaper = new NewPaper();
			 $newPaper->setId($fila["id"]);
			 $newPaper->setName($fila["name"]);
			 array_push($result, $newPaper);
		}
		return $result;
	}
	
	public function findById($id){
		$sentence = $this->connection->getPdo()->prepare("SELECT * FROM news_paper WHERE id =".$id);
		$sentence->execute();
		$newPaper = new NewPaper();
		
		$fila = $sentence->fetch();
		$newPaper->setId($fila["id"]);
		$newPaper->setName($fila["name"]);
		
		return $newPaper;
	}
	
	
}