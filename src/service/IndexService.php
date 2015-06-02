<?php
include_once(dirname(__FILE__)."/../controller/IndexController.php");
$controller = new IndexController();

if(isset($_POST["findAll"])){
	$controller->findAllFeeds();
}else if(isset($_POST["findOne"])){
	$controller->findOneFeedById();
}