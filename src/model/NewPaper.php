<?php
class NewPaper{
	public static $columns = Array(
			'name'
	);
	
	public static $primaryKey = 'id';
	public static $nameTable = 'news_paper';
	
	public $id = null;
	public $name = null;
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	
	
}