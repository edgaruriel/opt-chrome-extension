<?php
class Feed{
	public static $columns = Array(
				'title','description','author','date','link','id_ext','news_paper_id'
			);
	
	public static $primaryKey = 'id';
	public static $nameTable = 'new';
	
	public $id = null;
	public $title = null;
	public $description = null;
	public $autor = null;
	public $date = null;
	public $link = null;
	public $likes = null;
	public $views = null;
	public $idExt = null;
	public $newsPaper = null;
	
	
	/**
	 * @return the $idExt
	 */
	public function getIdExt() {
		return $this->idExt;
	}

	/**
	 * @param field_type $idExt
	 */
	public function setIdExt($idExt) {
		$this->idExt = $idExt;
	}

	/**
	 * @return the $likes
	 */
	public function getLikes() {
		return $this->likes;
	}

	/**
	 * @return the $views
	 */
	public function getViews() {
		return $this->views;
	}

	/**
	 * @param field_type $likes
	 */
	public function setLikes($likes) {
		$this->likes = $likes;
	}

	/**
	 * @param field_type $views
	 */
	public function setViews($views) {
		$this->views = $views;
	}

	/**
	 * @return the $link
	 */
	public function getLink() {
		return $this->link;
	}

	/**
	 * @param field_type $link
	 */
	public function setLink($link) {
		$this->link = $link;
	}

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return the $autor
	 */
	public function getAutor() {
		return $this->autor;
	}

	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @return the $newsPaper
	 */
	public function getNewsPaper() {
		return $this->newsPaper;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @param field_type $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @param field_type $autor
	 */
	public function setAutor($autor) {
		$this->autor = $autor;
	}

	/**
	 * @param field_type $date
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	 * @param field_type $newsPaper
	 */
	public function setNewsPaper($newsPaper) {
		$this->newsPaper = $newsPaper;
	}

	
	
	
	
}