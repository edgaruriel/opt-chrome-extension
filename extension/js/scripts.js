var track_load = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
var total_groups = 0; //total record group(s)

var isSearch = false; // bandera que se activa cuando seleccionan buscar y tenga algo escrito en el input
var textToSearch = ""; // se alamcena el texto del input, por si llega a borrar el texto y no da clic en buscar
var total_groups_search = 1;
var track_load_search = 0;
var loading_search  = false; //to prevents multipal ajax loads
var isActiveButtonSearch = false;

var isViews = false;
var isLikes = false;
	
$(document).ready(function(){
	
	$('#btnSearch').click(function(event){
		event.preventDefault();
		var text = $("#txtSearch").val();
		if(text != ""){
			isActiveButtonSearch = true;
			textToSearch = text;
			isSearch = true;
			isLikes = false;
			isViews = false;
			track_load_search = 0;
			getTotalByText();
			
			$('#feed').empty();
			getFeedSearch();
		}else{
			textToSearch = "";
			isSearch = false;
		}
	});
	
	$("#btnRefresh").click(getFeedRefresh);
	
	$("#btnFavorites").click(initFavorites);
	$("#btnViews").click(initViews);
	$("#btnNews").click(getFeedRefresh);
	
	$(window).scroll(function() {
	   if($(window).scrollTop() + $(window).height() == $(document).height()) {
		   
		   if(isSearch && textToSearch!=""){
			   if(track_load_search <= total_groups_search && loading_search==false && isActiveButtonSearch == false) {
					loading_search = true; //prevent further ajax loading
					$('.animation_image').show(); //show loading image
					getFeedSearch();
				}
			}else if(isLikes){
				if(track_load <= total_groups && loading==false && isActiveButtonSearch == false) {
					loading = true; //prevent further ajax loading
					$('.animation_image').show(); //show loading image
					getFeedFavorites();
				}
			}else if(isViews){
				if(track_load <= total_groups && loading==false && isActiveButtonSearch == false) {
					loading = true; //prevent further ajax loading
					$('.animation_image').show(); //show loading image
					getFeedViews();
				}
			}else{
				if(track_load <= total_groups && loading==false && isActiveButtonSearch == false) {
					loading = true; //prevent further ajax loading
					$('.animation_image').show(); //show loading image
					getFeed();
				}
			}
	   }
	});
	
}); 

function getFeedRefresh(){
	$('ul.nav a[id="btnFavorites"]').parent().removeClass('active');
	$('ul.nav a[id="btnViews"]').parent().removeClass('active');
	$('ul.nav a[id="btnNews"]').parent().addClass('active');
	isActiveButtonSearch = true;
	track_load=0;
	loading = false;
	isSearch = false;
	isLikes = false;
	isViews = false;
	textToSearch="";
	$('#feed').empty();
	getFeed();
}

function initFavorites(){
	$('ul.nav a[id="btnViews"]').parent().removeClass('active');
	$('ul.nav a[id="btnNews"]').parent().removeClass('active');
	$('ul.nav a[id="btnFavorites"]').parent().addClass('active');
	isActiveButtonSearch = true;
	track_load=0;
	loading = false;
	isSearch = false;
	isLikes = true;
	isViews = false;
	textToSearch="";
	$('#feed').empty();
	getFeedFavorites();
}

function initViews(){
	$('ul.nav a[id="btnFavorites"]').parent().removeClass('active');
	$('ul.nav a[id="btnNews"]').parent().removeClass('active');
	$('ul.nav a[id="btnViews"]').parent().addClass('active');
	isActiveButtonSearch = true;
	track_load=0;
	loading = false;
	isSearch = false;
	isLikes = false;
	isViews = true;
	textToSearch="";
	$('#feed').empty();
	getFeedViews();
}

function getFeed(){
		$.ajax({
		type:"POST",
		data: {page:track_load},
		url: "http://localhost/optChromeExtension/Feed/findNextPage",
		success: function(result){
			isActiveButtonSearch = false;
			var FEEDS = jQuery.parseJSON(result);
			var i = 0;
			for(i=0;i<FEEDS.length;i++){
				var feed = FEEDS[i];
				var notice="";
				notice += "<a href=\"#\" class=\"list-group-item\"\">";
				notice += "<h4 class=\"list-group-item-heading\">"+feed.title+" <button id=\"btnFav"+feed.id+"\" class=\"btn pull-right btn-danger btn-xs\"><span class=\"glyphicon glyphicon-heart\"><\/span>&nbsp;"+feed.likes+"<\/button><\/h4>";
				notice += "<p class=\"list-group-item-text\">"+feed.description+"<button id=\"btnUrl"+feed.id+"\" class=\"btn pull-right btn-info btn-xs\"><span class=\"glyphicon glyphicon-eye-open\"><\/span>&nbsp;"+feed.views+"<\/button><\/p>";
				notice += "<\/a>";
				
				$('#feed').append(notice);
				
				$('#btnUrl'+feed.id).click(createTab(feed.link,feed.id));
				$('#btnFav'+feed.id).click(sendFavorite(feed.id));
			}
			track_load++;
			loading = false;
			$('.animation_image').hide();
		}});
}

function getFeedSearch(){
		$.ajax({
				type:"POST",
				data: {text:textToSearch, page:track_load_search},
				url: "http://localhost/optChromeExtension/Feed/searchByText",
				success: function(result){
					isActiveButtonSearch = false;
					var FEEDS = jQuery.parseJSON(result);
					var i = 0;
					for(i=0;i<FEEDS.length;i++){
						var feed = FEEDS[i];
						var notice="";
						notice += "<a href=\"#\" class=\"list-group-item\"\">";
						notice += "<h4 class=\"list-group-item-heading\">"+feed.title+" <button id=\"btnFav"+feed.id+"\" class=\"btn pull-right btn-danger btn-xs\"><span class=\"glyphicon glyphicon-heart\"><\/span>&nbsp;"+feed.likes+"<\/button><\/h4>";
						notice += "<p class=\"list-group-item-text\">"+feed.description+"<button id=\"btnUrl"+feed.id+"\" class=\"btn pull-right btn-info btn-xs\"><span class=\"glyphicon glyphicon-eye-open\"><\/span>&nbsp;"+feed.views+"<\/button><\/p>";
						notice += "<\/a>";
						
						$('#feed').append(notice);
						
						$('#btnUrl'+feed.id).click(createTab(feed.link,feed.id));
						$('#btnFav'+feed.id).click(sendFavorite(feed.id));
					}
					track_load_search++;
					loading_search = false;
					$('.animation_image').hide();

			}});
}

function getFeedFavorites(){
		$.ajax({
				type:"POST",
				data: {filterBy:"likes", page:track_load},
				url: "http://localhost/optChromeExtension/Feed/findNextPage",
				success: function(result){
					isActiveButtonSearch = false;
					var FEEDS = jQuery.parseJSON(result);
					var i = 0;
					for(i=0;i<FEEDS.length;i++){
						var feed = FEEDS[i];
						var notice="";
						notice += "<a href=\"#\" class=\"list-group-item\"\">";
						notice += "<h4 class=\"list-group-item-heading\">"+feed.title+" <button id=\"btnFav"+feed.id+"\" class=\"btn pull-right btn-danger btn-xs\"><span class=\"glyphicon glyphicon-heart\"><\/span>&nbsp;"+feed.likes+"<\/button><\/h4>";
						notice += "<p class=\"list-group-item-text\">"+feed.description+"<button id=\"btnUrl"+feed.id+"\" class=\"btn pull-right btn-info btn-xs\"><span class=\"glyphicon glyphicon-eye-open\"><\/span>&nbsp;"+feed.views+"<\/button><\/p>";
						notice += "<\/a>";
						
						$('#feed').append(notice);
						
						$('#btnUrl'+feed.id).click(createTab(feed.link,feed.id));
						$('#btnFav'+feed.id).click(sendFavorite(feed.id));
					}
					track_load++;
					loading = false;
					$('.animation_image').hide();

			}});
}

function getFeedViews(){
		$.ajax({
				type:"POST",
				data: {filterBy:"views", page:track_load},
				url: "http://localhost/optChromeExtension/Feed/findNextPage",
				success: function(result){
					isActiveButtonSearch = false;
					var FEEDS = jQuery.parseJSON(result);
					var i = 0;
					for(i=0;i<FEEDS.length;i++){
						var feed = FEEDS[i];
						var notice="";
						notice += "<a href=\"#\" class=\"list-group-item\"\">";
						notice += "<h4 class=\"list-group-item-heading\">"+feed.title+" <button id=\"btnFav"+feed.id+"\" class=\"btn pull-right btn-danger btn-xs\"><span class=\"glyphicon glyphicon-heart\"><\/span>&nbsp;"+feed.likes+"<\/button><\/h4>";
						notice += "<p class=\"list-group-item-text\">"+feed.description+"<button id=\"btnUrl"+feed.id+"\" class=\"btn pull-right btn-info btn-xs\"><span class=\"glyphicon glyphicon-eye-open\"><\/span>&nbsp;"+feed.views+"<\/button><\/p>";
						notice += "<\/a>";
						
						$('#feed').append(notice);
						
						$('#btnUrl'+feed.id).click(createTab(feed.link,feed.id));
						$('#btnFav'+feed.id).click(sendFavorite(feed.id));
					}
					track_load++;
					loading = false;
					$('.animation_image').hide();

			}});
}


function createTab( url,id ){
  return function(){
    chrome.tabs.create({ url: url , active: false});
	$.ajax({
				type:"POST",
				data: {feedId:id},
				url: "http://localhost/optChromeExtension/Feed/updateViews",
				success: function(result){
					if(isSearch && textToSearch!=""){
						isActiveButtonSearch = true;
						isSearch = true;
						isLikes = false;
						isViews = false;
						track_load_search = 0;
						$('#feed').empty();
						getFeedSearch();
					}else if(isLikes){
						initFavorites();
					}else if(isViews){
						initViews();
					}else{
						getFeedRefresh();
					}
					
			}});
  };
}

function sendFavorite( id ){
  return function(){
    $.ajax({
				type:"POST",
				data: {feedId:id},
				url: "http://localhost/optChromeExtension/Feed/updateLikes",
				success: function(result){
					if(isSearch && textToSearch!=""){
						isActiveButtonSearch = true;
						isSearch = true;
						isLikes = false;
						isViews = false;
						track_load_search = 0;
						$('#feed').empty();
						getFeedSearch();
					}else if(isLikes){
						initFavorites();
					}else if(isViews){
						initViews();
					}else{
						getFeedRefresh();
					}
			}});
  };
}

function getTotal(){
	$.ajax({
				type:"POST",
				data: {},
				url: "http://localhost/optChromeExtension/Feed/countTotal",
				success: function(result){
					var TOTAL = jQuery.parseJSON(result);
					total_groups = TOTAL;
			}});
}

function getTotalByText(){
	$.ajax({
				type:"POST",
				data: {text:textToSearch},
				url: "http://localhost/optChromeExtension/Feed/countTotalByText",
				success: function(result){
					var TOTAL = jQuery.parseJSON(result);
					total_groups_search = TOTAL;
			}});
}

chrome.tabs.executeScript( {
code: "window.getSelection().toString();"
}, function(selection) {
	if(selection != null && selection[0] != ""){
		$('#txtSearch').val(selection[0]);
		
		textToSearch = selection[0];
		isSearch = true;
		track_load_search = 0;
		getTotalByText();
		
		$('#feed').empty();
		getFeedSearch();
	}else{
		getTotal();
		getFeed();
	}
});