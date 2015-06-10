<?php 
class Config {
	private static $instance = null;
	
	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new Config();
		}
		return self::$instance;
	}

	function getConfigFeeds(){
		return Array(
		
		'http://yucatan.com.mx/feed',	//Ultimas noticias
		'http://yucatan.com.mx/feed?cat=30', // M�rida
		'http://yucatan.com.mx/feed?cat=57', //Yucat�n
		'http://yucatan.com.mx/feed?cat=36', //M�xco
		'http://yucatan.com.mx/feed?cat=4', //Deportes
		'http://yucatan.com.mx/feed?cat=335' //Quintana roo
		
		);
		//'http://www.theverge.com/rss/index.xml'
	}
	
	function getConfigDataBase(){
		return Array(
			"host" => "localhost",
			"username" => "root",
			"password" => "root",
			"schema" => "feeds",
			"dbtype"=> "mysql"
					);
	}

}