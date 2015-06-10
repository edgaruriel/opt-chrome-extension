<?php
include_once(dirname(__FILE__)."/../model/mapper/NewPaperMapper.php");

class NewPaperService{
	
	public function findAllFromDB(){
		$newPaperMapper = new NewPaperMapper();
		$columns = NewPaper::$columns;
		array_push($columns, NewPaper::$primaryKey);
		return $newPaperMapper->select($columns);
	}
	
	public function findOneById($id){
		$newPaperMapper = new NewPaperMapper();
		return $newPaperMapper->findById($id);
	}
	
}